<?php
session_start();
$base_dir = '../upload';

$invalid_formats = array('php', 'html', 'sh');

if (isset($_GET['directory'])) {
	$path = urldecode($_GET['directory']);
	$path = str_replace('..', '', $path);
	
	if ($_GET['directory'] == "root") {
		$path = "";
		$_SESSION['file_path'] = $path;
	} else {
		if ($path == "" && isset($_SESSION['file_path'])) {
			$path = $_SESSION['file_path'];
		} else {
			$_SESSION['file_path'] = $path;
		}
	}
} else {
	if (isset($_SESSION['file_path'])) {
		$path = $_SESSION['file_path'];
	} else {
		$path = '';
	}
}

$dirs = scandir($base_dir.$path);

?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-info">
			<div class="box-header with-border">
				<?php 
				if ($path != $base_dir) {
					$last_dir = explode('/', $path);
					array_pop($last_dir);
					$last_dir = implode('/', $last_dir);
					if ($last_dir == "") $last_dir = 'root';
				?>
				
					<button onclick="load_directory('<?=$last_dir?>');" title="Voltar" class="btn btn-default btn-xs"><i class="fa fa-reply"></i></button>
					
				<?php } ?>
				<h6 class="box-title">
					<small>Listando arquivos em: raiz<?=$path?></small>
				</h6>
				
				<button id="delete-folder" data-path="<?=$path?>" class="btn btn-danger pull-right">
					<i class="fa fa-trash"></i>
				</button>
				
				<button id="create-folder" data-path="<?=$path?>" class="btn btn-info pull-right pad-right">
					<i class="fa fa-folder"></i>
				</button>
				
				<button id="upload-file" class="btn btn-success pull-right pad-right">
					<i class="fa fa-cloud-upload"></i>
				</button>
				<input id="upload-file-input" data-path="<?=$path?>" name="file" type="file" multiple style="display:none;" />
				
			</div>
			<div class="box-body">
			<?php
			
			foreach ($dirs as $dir) {
				if ($dir == '.' || $dir == '..') continue;
				
				if (!!strpos($dir, '.')) {
					$format = explode('.', $dir);
					$format = $format[1];
					
					if (!in_array($format, $invalid_formats)) {
						if (@is_array(getimagesize("../upload/$path/$dir"))) {
							$img_src = "<img src='../upload/$path/$dir' />";
						} else {
							$img_src = "<i class='fa fa-fw fa-file-archive-o'></i>";
						}
						
						echo "
						<label title='$dir' class='file-archive' ondblclick='select_file(this)'>
							<div class='img-wrapper'>
								$img_src
							</div>
							<input class='file-selector' value='$dir' full-path='$path/$dir' type='checkbox' /><label class='file-name'>$dir</label>
						</label>";
					}
				} else {
					echo "
						<label title='$dir' class='file-archive' ondblclick='load_directory(\"$path/$dir\")'>
							<div class='img-wrapper'>
								<img src='assets/img/folder-i.png' />
							</div>
							<input class='file-selector' value='$dir' type='checkbox' /><label class='file-name'>$dir</label>
						</label>";
				}
			}
			
			?>
			</div>
		</div>
	</div>
</div>
<style>

.file-archive {
	float:left;
	margin-top:10px;
	margin-left:10px;
	text-align:center;
	width:62px;
	height:100px;
	overflow:hidden;
	border:1px solid #FFF;
	padding:5px;
}
.file-archive * {
	cursor:pointer;
}
.img-wrapper {
	width:50px;
	height:50px;
	overflow:hidden;
}
.img-wrapper i {
	width:50px;
	height:50px;
	font-size:40px;
}
.file-archive img {
	min-width:50px;
	max-height:50px;
}
.file-selector {
	opacity:0;
	float: left !important;
	margin-top: -25px !important;
	margin-left: 5px !important;
}
.file-name {
	cursor:pointer;
	font-size:10px;
	font-weight:normal;
	max-width:100%;
	word-wrap:break-word;
	overflow: hidden;
	text-overflow: ellipsis;
}
.file-checked {
	border:1px solid #AAA;
	background-color:#DDD;
}
</style>
<script type="text/javascript">
	$('.file-selector').change(function(e) {
		if($(this).is(':checked')) {
			$(this).parent('label').addClass('file-checked');
		} else {
			$(this).parent('label').removeClass('file-checked');
		}
	});

	$("#create-folder").on("click", function(e) {
		var name = window.prompt("Entre com o nome da pasta: ", "Nova Pasta");
		if (name == null || name == '') return;
		var path = $(this).attr("data-path");

		$.ajax({
			url: "ajax.files.php?action=create-dir",
			data: {path:path, name:name},
			method: 'POST'
		}).done(function(data) {
			load_directory(path);
		}).fail(function(err) {
			console.log(err.responseText);
		});
	});

	$("#delete-folder").on("click", function(e) {
		if (window.confirm('Tem certeza de que deseja excluir os itens selecionados?')) {
			var path = $(this).attr('data-path');
			
			var data = [];
			$(".file-selector").each(function(index) {
				if ($(this).is(':checked')) {
					data.push($(this).attr('value'));
				}
			});
	
			$.ajax({
				url: "ajax.files.php?action=delete-dir",
				data: {path:path, files:data},
				method: 'POST'
			}).done(function(data) {
				if (data.error) alert('Um ou mais diretórios não estão vazios!');
				load_directory(path);
			}).fail(function(err) {
				console.log(err.responseText);
			});
		}
	});

	
	$("#upload-file").on("click", function(e) {
		$("#upload-file-input").trigger("click");
	});
	$("#upload-file-input").on("change", function(e) {
		files = this.files;
		path = $(this).attr('data-path');
		
		form_data = new FormData();

		for (var i = 0, f; f = files[i]; i++) {
			if (f.size > 1000000) {
				alert('Os arquivos enviados devem ter menos de 1MB');
			} else {
				form_data.append('files[]', f);
			}
		}

		form_data.append('path', path);

		$("#upload-file").html('<i class="fa fa-spinner fa-spin"></i>');
		$("#upload-file").attr('disabled', 'disabled');
		
		$.ajax({
			url: 'ajax.files.php?action=upload-file',
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			type: 'post',
			success: function(data) {
				try {
					data = JSON.parse(data);
					if (data.error_message)	alert(data.error_message);
				} catch(err) {
					console.log(err.message);
				}
			}
		}).done(function() {
			load_directory(path);
		});
	});
	

	function select_file(el) {
		$(el).children('input').first().prop('checked', true);
		$('#files-done').trigger('click');
	}
</script>
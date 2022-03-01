<?php 
$metadata = db::get_meta($_GET['page']);

if ($_GET['action'] == 'new') {
	$box_title = "Criando novo registro em: ".$breadcrumb['name'];
	
	foreach ($metadata as $index=>$meta) {
		if ($meta['COLUMN_NAME'] == 'id') { unset($metadata[$index]); continue; }
		$default_values[$meta['COLUMN_NAME']] = "";
	}
	
} else if ($_GET['action'] == 'edit') {
	$box_title = "Editando registro em: ".$breadcrumb['name'];
	
	$data = db::get_by_id($_GET['page'], $_GET['id']);

	foreach ($metadata as $index=>$meta) {
		$default_values[$meta['COLUMN_NAME']] = $data[$meta['COLUMN_NAME']];
	}
	
}

if (isset($_SESSION['data'])) {
	foreach ($_SESSION['data'] as $key=>$value) {
		$default_values[$key] = $_SESSION['data'][$key];
	}
	unset($_SESSION['data']);
}

?>
<div class="row">
	<div class="col-md-12">
	
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?=$box_title?></h3>
			</div>
	
			<form class="form-horizontal" method="POST" action="?page=<?=$_GET['page']?>&action=save" enctype="multipart/form-data">
				<div class="box-body">
				
				<?php foreach ($metadata as $meta) {

						$name = $meta['COLUMN_NAME'];
						$label = (isset($meta['COLUMN_COMMENT']['name']['value'])) ? $meta['COLUMN_COMMENT']['name']['value'] : ucfirst($meta['COLUMN_NAME']);
						$required = ($meta['IS_NULLABLE'] == 'NO')?"required":"";
						$max_length = $meta['CHARACTER_MAXIMUM_LENGTH'];
						$group_class = "";
						
						$placeholder = $label;
						
						$input = 'input';
						$value = $default_values[$meta['COLUMN_NAME']];
						$content = "";
						$type = "text";
						
						$options = "";
						if (isset($meta['COLUMN_COMMENT']['min-length']['value'])) {
							$options .= " min-length='".$meta['COLUMN_COMMENT']['min-length']['value']."'";
						}
						
						if ($meta['COLUMN_KEY'] == 'UNI') {
							$options .= " unique unique-table='$_GET[page]'";
						}
						
						$class = array('form-control');
						
						switch ($meta['DATA_TYPE']) {
							case 'int':
								
								if ($meta['COLUMN_KEY'] == 'PRI') {
									$type = "hidden";
									$group_class = " hidden";
								} else if ($meta['COLUMN_COMMENT']['fk']) {
									$fk = $meta['COLUMN_COMMENT']['fk'];
									$input = "select";
									$class[] = "select2";
									
									$data = db::get_all($fk['table']);
									
									foreach ($data as $option) {
										$ref = $option[$fk['ref']];
									
										$selected = "";
										if ($option['id'] == $value) $selected = " selected"; 
										
										$content .= "<option value='$option[id]'$selected>$ref</option>";
									}
								}
								
							break;
							
							case 'text':
								if (isset($meta['COLUMN_COMMENT']['photo'])) {
									$max = (isset($meta['COLUMN_COMMENT']['photo']['max']))?$meta['COLUMN_COMMENT']['photo']['max']:'0';
									
									$input = "div";
									$placeholder = "";
									$class[] = 'galery';
									
									if ($value == "") $value = "[]";
									foreach (json_decode($value) as $pic) {
										if (@is_array(getimagesize("../upload$pic"))) {
											$img_src = "../upload$pic";
										} else {
											$img_src = "assets/img/file.png";
										}
										
										$content .= "<input onclick='remove_this(this)' class='galery-item' name='".$name."[]' value='$pic' style='background-image: url(\"$img_src\")' title='$pic' />"; 
									}
									
									$content .= "<button type='button' photo-max='$max' class='btn btn-default btn-lg galery-button'><i class='fa fa-plus'></i></button>";
									
									$value = "";
									
								} else if (isset($meta['COLUMN_COMMENT']['toolbar'])) {
									$class[] = 'wysiwyg';
									$input = 'textarea';
									$content = $default_values[$meta['COLUMN_NAME']];
									$value = "";
									$class[] = 'no-resize';
								} else {
									$input = 'textarea';
									$content = $default_values[$meta['COLUMN_NAME']];
									$value = "";
									$class[] = 'no-resize';
								}
								
							break;
							
							case 'varchar':
								if (isset($meta['COLUMN_COMMENT']['url'])) {
									$type = "url";
								} else if (isset($meta['COLUMN_COMMENT']['email'])) {
									$type = "email";
								} else if (isset($meta['COLUMN_COMMENT']['color'])) {
									$type = "color";
								} else if (isset($meta['COLUMN_COMMENT']['password'])) {
									$type = "password";
								} else if (isset($meta['COLUMN_COMMENT']['youtube'])) {
									$type = "url";
									$class[] = "youtube";
								} else if (isset($meta['COLUMN_COMMENT']['icon'])) {
									$type = "text";
									$class[] = "font-awesome-icon";
									$options .= "readonly='readonly'";
								}
							break;
							
							case 'date':
								if (isset($meta['COLUMN_COMMENT']['auto'])) {
									$type = "hidden";
									$group_class = " hidden";
								} else {
									$type = "text";
									$placeholder = "dd/mm/yyyy";
								}
							break;
							
							case 'tinyint':
								if ($value == '1') $options .= "checked='checked'";
								$class[] = 'flat-red';
								$type = 'checkbox';
								$required = "";
							break;
						}
						
						
				?>
				
						<div class="form-group col-md-6<?=$group_class?>">
							<label class="col-sm-2 control-label" for="<?=$name?>"><?=$label?></label>
		
							<div class="col-sm-10">
								<?php
								echo "
								
									<$input id='$name' class='".implode(' ', $class)."' name='$name' value='$value' placeholder='$placeholder' type='$type' $required $options>$content</$input>
									
								";
								?>
							</div>
						</div>
	
				<?php } ?>
					
				</div>
	
				<div class="box-footer">
					<a href="?page=<?=$_GET['page']?>&action=show" class="btn btn-danger" type="submit"><i class="fa fa-mail-reply"></i> Cancelar</a>
					<button class="btn btn-success pull-right" type="submit"><i class="fa fa-save"></i> Salvar</button>
				</div>
			</form>
			
			<script type="text/javascript">
				$(document).ready(function() {
					<?php
					
					if (isset($_SESSION['error'])) {
						foreach ($_SESSION['error'] as $field=>$error) {
							echo "
								$('#$field').get(0).setCustomValidity('$error');
								
								$('#$field').on('input', function(e) {
									$(this).get(0).setCustomValidity('');
								});
							";
						}
						unset($_SESSION['error']);
					}
					
					?>

				});
			</script>
			
		</div>
			<div id="files" class="modal">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button class="close" data-dismiss="modal" type="button"><span>×</span></button>
							<h4 class="modal-title"><i class="fa fa-folder"></i> Arquivos</h4>
						</div>
		
						<div id="files-main" class="modal-body">
							<p>
								
							</p>
						</div>
		
						<div class="modal-footer">
							<button class="btn btn-default pull-left" data-dismiss="modal" type="button"><i class="fa fa-times"></i> Fechar</button>
							<button id="files-done" class="btn btn-primary" type="button"><i class="fa fa-check"></i> Pronto</button>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
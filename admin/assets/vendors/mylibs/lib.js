function load_directory(dir) {
	dir = encodeURI(dir);
	$("#files-main").load("files.php?directory="+dir);
}
function execute_callback(dir) {
	filecallback(dir);
}
function ytVidId(url) {
	var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
	return (url.match(p)) ? true /*RegExp.$1*/ : false;
}
filecallback = function() {};
function remove_this(e) {
	$(e).remove();
}
function count_photos(div) {
	var itens = $(div).children('.galery-item');
	return(itens.length);
}




$(document).ready(function() {

	$(".youtube").on("keyup", function(e) {
		if (!ytVidId($(this).val())) {
			$(this).get(0).setCustomValidity('A URL Fornecida não é uma URL válida do Youtube.');
		} else {
			$(this).get(0).setCustomValidity('');
		}
	});
	
	$("input[min-length]").on("input", function(e) {
		var length = $(this).attr("min-length");
		
		if ($(this).val().length < length) {
			$(this).get(0).setCustomValidity('O campo deve ter ao menos '+length+' caracteres');
		} else {
			$(this).get(0).setCustomValidity('');
		}
	});
	
	$("input[unique]").on("blur", function(e) {
		input = $(this).get(0);
		var table = $(this).attr('unique-table');
		var field = $(this).attr('name');
		var value = $(this).val();
		
		$(this).attr('disabled', 'disabled');
		input.setCustomValidity('Aguarde');
	
		$.ajax({
			url: "ajax.php?page="+table+"&field="+field+"&action=unique",
			data: {value:value},
			method: 'POST'
		}).done(function(data) {
			$(input).removeAttr('disabled');
			if (data.success) {
				input.setCustomValidity('');
			} else {
				input.setCustomValidity('Já existe um registro com essas informações');
			}
		}).fail(function(err) {
			console.log(err.responseText);
		});
	});
	
	$(".confirm").on("click", function(e) {
		e.preventDefault();
		
		if (window.confirm("Tem certeza de que deseja excluir o registro?")) {
			location.href = $(this).attr('href');
		}
	});
	
	$(".galery-button").on("click", function(e){
		count_photos($(this).parent());
		
		var max = parseInt($(this).attr('photo-max'));
		if (max == 0) max = Infinity;
		
		if (count_photos($(this).parent()) < max) {
			var parent = $(this);
			var name = $(parent).parent().attr('name');
			
			filecallback = function(data) {
				var count = 0;
				data.forEach(function(value) {
					if (count < max) {
						if (!value.match(/\.(jpg|jpeg|png|gif)$/)) {
							img_addr = "assets/img/file.png";
						} else {
							img_addr = "../upload"+value;
						}
	
						$(parent).before(
							"<input title='"+value+"' onclick='remove_this(this)' class='galery-item' name='"+name+"[]' value='"+value+"' style='background-image: url(\""+img_addr+"\")'/>"
						);
						count++;
					}
				});
			};
			
			load_directory('');
			$("#files").modal();
		} else {
			alert('Limite de fotos excedido');
		}
	});
	
	$("#files-done").on("click", function(e) {
		var data = [];
		$(".file-selector").each(function(index) {
			if ($(this).is(':checked')) {
				data.push($(this).attr('full-path'));
			}
		});
		execute_callback(data);
		$("#files").modal('hide');
	});

});
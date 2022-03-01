<?php

if (isset($_POST['id'])) {
	$is_new = false;
} else {
	$is_new = true;
}

$metadata = db::get_meta($_GET['page']);

$error = array();
foreach ($metadata as $key=>$meta) {

	// CHECA SE É CHAVE PRIMÁRIA
	if ($meta['COLUMN_KEY'] == 'PRI' && $is_new) { 
		unset($metadata[$key]);
		continue;
	}
	
	// TRATA O TINYINT
	if ($meta['DATA_TYPE'] == 'tinyint') {
		if (isset($_POST[$meta['COLUMN_NAME']])) {
			$_POST[$meta['COLUMN_NAME']] = '1';
		} else {
			$_POST[$meta['COLUMN_NAME']] = '0';
		}
	}
	
	// CHECA SE ESTÁ EXISTE A VARIAVEL
	if (!isset($_POST[$meta['COLUMN_NAME']])) { 
		if ($meta['DATA_TYPE'] == 'tinyint') {
			$_POST[$meta['COLUMN_NAME']] = '0';
		} else {
			$_POST[$meta['COLUMN_NAME']] = '';
			$error[$meta['COLUMN_NAME']] = 'Este campo é obrigatório';
		}
	}
	
	if ($meta['DATA_TYPE'] == 'date') {
		if (isset($meta['COLUMN_COMMENT']['auto'])) {
			$_POST[$meta['COLUMN_NAME']] = date('Y-m-d');
		} else {
			$_POST[$meta['COLUMN_NAME']] = implode('-', array_reverse(explode('/', $_POST[$meta['COLUMN_NAME']])));
		}
	}
	
	// CHECA SE O CAMPO É E SE PODE SER VAZIO
	if ($_POST[$meta['COLUMN_NAME']] == '' && $meta['IS_NULLABLE'] == 'NO') { 
		$error[$meta['COLUMN_NAME']] = 'Este campo é obrigatório';
	}
	
	// CHECA AS FOTOS
	if (isset($meta['COLUMN_COMMENT']['photo'])) {
		$_POST[$meta['COLUMN_NAME']] = json_encode($_POST[$meta['COLUMN_NAME']]);
	}
	
	// CHECA O MAXLENGTH
	if ($meta['CHARACTER_MAXIMUM_LENGTH'] != null) {
		if (strlen($_POST[$meta['COLUMN_NAME']]) > $meta['CHARACTER_MAXIMUM_LENGTH']) {
			$error[$meta['COLUMN_NAME']] = 'O campo ultrapassa o limite máximo de caracteres (max: '.$meta['CHARACTER_MAXIMUM_LENGTH'].')';
		}
	}
	
	// CHECA O MINLENGTH
	if (isset($meta['COLUMN_COMMENT']['min-length']['value'])) {
		if (strlen($_POST[$meta['COLUMN_NAME']]) < $meta['COLUMN_COMMENT']['min-length']['value']) {
			$error[$meta['COLUMN_NAME']] = 'O campo não possui o mínimo de caracteres requeridos (min: '.$meta['COLUMN_COMMENT']['min-length']['value'].')';
		}
	}
	
	// CHECA OS TIPOS
	if (isset($meta['COLUMN_COMMENT']['url'])) {
		
		if (filter_var($_POST[$meta['COLUMN_NAME']], FILTER_VALIDATE_URL) === FALSE) {
			$error[$meta['COLUMN_NAME']] = 'A URL fornecida é inválida';
		}
		
	} else if (isset($meta['COLUMN_COMMENT']['email'])) {
		
		if (filter_var($_POST[$meta['COLUMN_NAME']], FILTER_VALIDATE_EMAIL) === FALSE) {
			$error[$meta['COLUMN_NAME']] = 'O endereço de e-mail fornecido é inválido';
		}
		
	} else if (isset($meta['COLUMN_COMMENT']['youtube'])) {
		
		$url = $_POST[$meta['COLUMN_NAME']];

		$regex_pattern = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
		$match;
		
		if(preg_match($regex_pattern, $url, $match)){
			
		}else{
		    $error[$meta['COLUMN_NAME']] = 'O link do Youtube fornecido é inválido';
		}
		
	}

	$data[$meta['COLUMN_NAME']] = $_POST[$meta['COLUMN_NAME']];
}

if (empty($error)) {
	if ($is_new) {
		if (db::insert($_GET['page'], $data)) {
			echo "
			<script type='text/javascript'>
				location.href='?page=$_GET[page]&action=show';
			</script>
			";
		}
	} else {
		if (db::update($_GET['page'], $data)) {
			echo "
			<script type='text/javascript'>
				location.href='?page=$_GET[page]&action=show';
			</script>
			";
		}
	}
} else {
	$_SESSION['error'] = $error;
	$_SESSION['data'] = $data;
	
	if ($is_new) {
		$action = 'new';
	} else {
		$action = 'edit&id='.$_POST['id'];
	}
	
	echo "
	<script type='text/javascript'>
		location.href='?page=$_GET[page]&action=$action';
	</script>
	";
	die();
}

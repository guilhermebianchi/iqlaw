<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
	$data = db::get_by_conditions('_login', array('username'=>$_POST['username']));
	if (empty($data)) {
		$error['username'] = "Seu nome de usuário é inválido!";
	} else {
		$data = $data[0];
		if ($data['password'] != $_POST['password']) {
			$error['password'] = "Sua senha é inválida";
		} else {
			unset($data['password']);
			$_SESSION['login'] = $data;
			header("Location: ?page=home&action=show");
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta content="IE=edge" http-equiv="X-UA-Compatible">

	<title>Login</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><!-- Bootstrap 3.3.5 -->
	<link href="assets/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet"><!-- Font Awesome -->
	<link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"><!-- Ionicons -->
	<!-- <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet"><!-- Theme style -->
	<link href="assets/vendors/dist/css/AdminLTE.min.css" rel="stylesheet"><!-- iCheck -->
	<link href="assets/vendors/iCheck/square/blue.css" rel="stylesheet"><!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="#">Painel</a>
		</div>
		<div class="login-box-body">
			<p class="login-box-msg">Faça login para iniciar sua sessão</p>

			<form id="form" method="post">
				<div class="form-group has-feedback">
					<input id="username" value="<?=(isset($_POST['username']))?$_POST['username']:''?>" name="username" class="form-control" placeholder="Nome de usuário" type="text" required> <span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>


				<div class="form-group has-feedback">
					<input id="password" value="<?=(isset($_POST['password']))?$_POST['password']:''?>" name="password" class="form-control" placeholder="Senha" type="password" required> <span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>


				<div class="row">
					<div class="col-xs-8">
					</div>

					<div class="col-xs-4">
						<button id="submit" class="btn btn-primary btn-block btn-flat" type="submit">Entrar</button>
					</div>
				</div>
				<div id="err"></div>
			</form>
		</div>
	</div>

	<!-- jQuery 2.1.4 -->
	<script src="assets/vendors/jQuery/jQuery-2.1.4.min.js"></script> <!-- Bootstrap 3.3.5 -->
	<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script> <!-- iCheck -->
	<script src="assets/vendors/iCheck/icheck.min.js"></script> <script>
	$(function () {
		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%'
		});
	});
	$(document).ready(function() {
		$('#username').on('input', function(e) {
			$(this).get(0).setCustomValidity('');
		});
		$('#password').on('input', function(e) {
			$(this).get(0).setCustomValidity('');
		});
		
		<?=(isset($error['username']))?"
			$('#username').get(0).setCustomValidity('$error[username]');
		":""?>
		<?=(isset($error['password']))?"
			$('#password').get(0).setCustomValidity('$error[password]');
		":""?>
		<?=(isset($error['username']) || isset($error['password']))?"
			$('#submit').trigger('click');
		":""?>
	});
	</script>
</body>
</html>

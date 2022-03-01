<?php
db::delete($_GET['page'], $_GET['id']);

echo '
<script type="text/javascript">
	location.href="?page='.$_GET['page'].'&action=show";
</script>';

?>

<h3>Registro excluido com sucesso. <a class="btn btn-default" href="?page=<?=$_GET['page']?>&action=show">Voltar</a></h3>
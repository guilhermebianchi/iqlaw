<?php 
$breadcrumbs = db::get_by_conditions('_menu', array('page'=>$_GET['page']));

if (!empty($breadcrumbs)) {
	$breadcrumb = $breadcrumbs[0];
}

switch ($_GET['action']) {
	case 'show':
		$act = "Listar";
		$actbc = "list-ul";
	break;
	case 'new':
		$act = "Novo";
		$actbc = "plus";
	break;
	case 'edit':
		$act = "Editar";
		$actbc = "edit";
	break;
	default:
		$act = "";
		$actbc = "keyboard-o";
	break;
}
?>

<h1><i class="fa fa-<?=$breadcrumb['icon']?>"></i> <?=$breadcrumb['name']?> <small><?=$act;?></small></h1>

<ol class="breadcrumb">
	<li>
		<a href="?page=<?=$_GET['page']?>&action=show"><i class="fa fa-<?=$breadcrumb['icon']?>"></i> <?=$breadcrumb['name']?></a>
	</li>
	<li class="active"><i class="fa fa-<?=$actbc?>"></i> <?=$act?></li>
</ol>
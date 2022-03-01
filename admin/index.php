<?php
include '../core.php';
session_start();

if (!isset($_SESSION['login'])) {
	include 'inc/login.php';
} else {
	if (!isset($_GET['page'])) {
		header("Location: ?page=param&action=show");
	}
	if ($_GET['page'] == 'logout') {
		unset($_SESSION['login']);
		session_destroy();
		header("Location: ?page=login");
	}
	if (!isset($_GET['action'])) {
		$_GET['action'] = 'show';
	}

?>

<!DOCTYPE html>
<html>
    <head>
        <?php include 'common/header.php'; ?>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <span class="logo">PAINEL</span>


                <nav class="navbar navbar-static-top">
                    <?php include 'common/top.php'; ?>
                </nav>
            </header>

            <aside class="main-sidebar">
                <?php include 'common/menu.php'; ?>
            </aside>

            <div class="content-wrapper">
                <section class="content-header">
                    <?php include 'common/breadcrumb.php'; ?>
                </section>

                <section class="content">
                    <?php
                        switch ($_GET['action']) {
                            case 'show':
                                include 'inc/show.php';
                            break;
                            case 'new':
                            case 'edit':
                                include 'inc/form.php';
                            break;
                            case 'save':
                                include 'inc/save.php';
                            break;
                            case 'remove':
                                include 'inc/delete.php';
                            break;
                        }
                    ?>
                </section>
            </div>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 4.9.16
                </div>
                <strong>Copyright &copy; Todos os direitos reservados.
            </footer>

            <aside class="control-sidebar control-sidebar-dark">
                <?php include 'common/config.php'; ?>
            </aside>

            <div class="control-sidebar-bg"></div>
        </div>

        <?php include 'common/footer.php'; ?>
    </body>
</html>

<?php
}
?>

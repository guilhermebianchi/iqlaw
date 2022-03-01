<?php

try {
	include_once 'config.php';
	include_once 'lib/Functions.class.php';

	$root_dir = explode('/', $config['document_root']);
	$root_dir = array_filter($root_dir);
	$root_dir = implode('/', $root_dir);

	define('RELATIVE_PATH', $root_dir);
	define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/'.$root_dir.'/');
	define('DBHOST', $config['db_host']);
	define('DBUSER', $config['db_username']);
	define('DBPASS', $config['db_password']);
	define('DATABASE', $config['database_name']);

	function __autoload($class) {
		$filename = ROOT.'lib/'.$class.'.class.php';
		if (is_file($filename)) {
			include($filename);
		}
	}

	function clear_url($url) {
		$url = array_filter(explode('/', $url));
		foreach ($url as $key=>$piece) {
			if ($piece == RELATIVE_PATH) unset($url[$key]);
		}
		return $url;
	}

	$url = clear_url($_SERVER['REQUEST_URI']);
	$file = array_shift($url);
	if (!$file || $file == 'home') $file = 'index';

	$params = array_values($url);

	for($i = 0; $i < count($params); $i=$i+2) {
		if (isset($params[$i+1])) {
			$_GET["$params[$i]"] = $params[$i+1];
		} else {
			$_GET['url'] = $params[$i];
		}
	}

	if( strpos( $file, '?' ) !== false ){
        $FileExplode = explode( '?', $file );
        if( $FileExplode[ 0 ] != '' ){
            $file = $FileExplode[ 0 ];
        }else{
            $file = 'index';
        }
    }

	if ($file != 'admin') {
		$filename = 'public/'.$file.'.php';
		if (file_exists($filename)) {
			include $filename;
		} else {
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
			include 'errors/404.php';
		}
	}
} catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    include 'errors/500.php';
    die();
}

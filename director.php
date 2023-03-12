<?php
require_once 'route/function.php';
require_once 'route/route.php';

//Nhằm không để mỗi route đều phải khai báo path
require_once 'helpers/path.php';

$url = explode('/', $_GET['url']);
if (!empty($_GET['url'])) {
	$url = explode('/', $_GET['url']);
	if ($url[0] == 'Admin') {
		$path = handle();
	} else {
		$path = handle_user();
	}
} else {
	$path = 'view/index.php';
}

if (file_exists($path)) {
	if (!session_id()) {
		session_start();
	}

	Path::path_file_include('Session', 'General', 'Database', 'Format');
	require_once $path;
} else {
	Path::path_file_include('Session');
	if ($url[0] == 'Admin') {
		require_once 'Admin/view/error/404.php';
	} else {
		require_once 'view/error/404.php';
	}
}
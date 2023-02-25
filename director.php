<?php
require_once 'route/function.php';
require_once 'route/route.php';

//Nhằm không để mỗi route đều phải khai báo path
require_once 'helpers/path.php';

// if (!empty($_GET['url'])) {
// 	$path = handle();
// } else {
// 	$path = 'view/index.php';
// }
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

?>

<!-- <pre>
	<h3>Địa chỉ url: </h3>
	<?php echo $_GET['url']; ?>
	<h3>Đường dẫn cụ thể: </h3>
	<?php echo $GLOBALS['path'] ?>
</pre> -->
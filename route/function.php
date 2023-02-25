<?php
function handle()
{

	global $routes;

	$url = trim($_GET['url'], '/');
	$arrayUrl = explode('/', $url);

	if (count($arrayUrl) == 1) {
		$url = 'Admin/view/index';
	} else {
		foreach ($routes as $key => $value) {
			$pattern = '~^' . $key . '~i';
			if (preg_match($pattern, $url)) {

				$url = preg_replace($pattern, $value, $url);

				if (count($arrayUrl) > 2) {

					$url = parse_url($url, PHP_URL_PATH);
				}

				break;
			}
		}
	}

	// Xét tới điều kiện có đuôi (đường dẫn theo tên thư mục) và không đuôi (đường dẫn đã điều chỉnh)
	return empty(pathinfo($url, PATHINFO_EXTENSION)) ? $url . ".php" : $url;
}
function handle_user()
{

	global $routes_user;

	$url = trim($_GET['url'], '/');
	$arrayUrl = explode('/', $url);

	foreach ($routes_user as $key => $value) {
		$pattern = '~^' . $key . '~i';
		if (preg_match($pattern, $url)) {

			$url = preg_replace($pattern, $value, $url);

			$url = parse_url($url, PHP_URL_PATH);

			break;
		}
	}

	// Xét tới điều kiện có đuôi (đường dẫn theo tên thư mục) và không đuôi (đường dẫn đã điều chỉnh)
	return empty(pathinfo($url, PATHINFO_EXTENSION)) ? $url . ".php" : $url;
}

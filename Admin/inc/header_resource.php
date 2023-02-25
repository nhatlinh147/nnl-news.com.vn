<?php

if (empty($GLOBALS['no_session'])) {
	Session::checkSession();
}

?>
<?php

?>
<!DOCTYPE html>

<head>
	<title><?php echo !empty($GLOBALS['title']) ? $GLOBALS['title'] : 'Trang bán hàng NNShop - Chuyên bán quần áo nam'; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>

	<!-- bootstrap-css -->
	<link rel="stylesheet" href="<?php echo Path::path_file('Css_bootstrap.min') ?>" />
	<!-- //bootstrap-css -->

	<!-- Custom CSS -->
	<link rel="stylesheet" href="<?php echo Path::path_file('Css_style') ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo Path::path_file('Css_style-responsive') ?>" type="text/css" />

	<!-- font CSS -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

	<!-- font-awesome icons -->
	<link rel="stylesheet" href="<?php echo Path::path_file('Css_font') ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo Path::path_file('Css_font-awesome') ?>" type="text/css" />

	<link rel="stylesheet" href="<?php echo Path::path_file('Css_morris') ?>" type="text/css" />

	<!-- calendar -->
	<link rel="stylesheet" href="<?php echo Path::path_file('Css_monthly') ?>" type="text/css" />
	<!-- //calendar -->

	<!-- //font-awesome icons -->
	<script src="<?php echo Path::path_file('Js_jquery2.0.3.min') ?>"></script>
	<script src="<?php echo Path::path_file('Js_raphael-min') ?>"></script>
	<script src="<?php echo Path::path_file('Js_morris') ?>"></script>

	<!-- Các thư viện ui css trong jquery -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<style>
		form input.error {
			border: 3px solid #ff847b;
		}

		form label.error {
			margin: 15px 0px 5px;
			color: #ff5959;
		}

		table tr td[class^="content_status_"] i {
			cursor: pointer;
		}

		div.notify-error {
			color: #ff0e0e;
			margin: 1rem 0.6rem;
			font-weight: 500;
		}
	</style>

</head>
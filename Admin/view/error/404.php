<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
	$filepath = realpath(dirname(__FILE__));
	include_once($filepath.'/../../../helpers/path.php');
	Path::path_file_include('General');
?>

<!DOCTYPE html>
<?php Path::path_file_include('Inc_header_resource') ?>
<body>
<!--main content start-->
<div class="eror-w3">
	<div class="agile-info">
		<h3>Lỗi</h3>
		<h2>404</h2>
		<p>Địa chỉ đẫn đến trang web sai "CMNR" ! Quay xe đi</p>
		<a href="<?php echo General::view_link('trang-chu.html') ?>">go home</a>
	</div>
</div>

<?php Path::path_file_include('Inc_update_status_script') ?>
<?php Path::path_file_include('Inc_script_resource') ?>

</body>
</html>
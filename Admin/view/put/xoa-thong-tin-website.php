<?php
<<<<<<< HEAD
include('D:\xampp\htdocs\nnl-news.com.vn\helpers\path.php');
=======
include('D:\xampp\htdocs\Projec PHP thuần\helpers\path.php');
>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95
Path::path_file_include('Database','Format','General','Info');
$info = new info();
$get_method = $info->delete_info();
echo json_encode($get_method);
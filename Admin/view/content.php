<?php
include('D:\xampp\htdocs\Projec PHP thuần\helpers\path.php');
Path::path_file_include('Database','Format','Info');
$info = new info();
$get_method = $info->delete_info();
echo json_encode($get_method);
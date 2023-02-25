<?php
include('D:\xampp\htdocs\nnl-news.com.vn\helpers\path.php');
Path::path_file_include('Database','Format','General','Info');
$info = new info();
$get_method = $info->delete_info();
echo json_encode($get_method);
<?php
include('D:\xampp\htdocs\nnl-news.com.vn\helpers\path.php');
Path::path_file_include('Database','Format','General','User_home');
$Home = new Home();
$get_method = $Home->search_product();
echo json_encode($get_method);
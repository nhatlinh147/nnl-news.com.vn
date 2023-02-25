<?php
include('D:\xampp\htdocs\nnl-news.com.vn\helpers\path.php');
Path::path_file_include('Database','Format','General','User_comment');
$Comment = new Comment();
$get_method = $Comment->getComment();
echo json_encode($get_method);
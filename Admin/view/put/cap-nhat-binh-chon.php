<?php
include('D:\Xampp\htdocs\nnl-news.com.vn\helpers\path.php');
Path::path_file_include('Database','Format','General','User_comment');
$Comment = new Comment();
$get_method = $Comment->updateVoted();
echo json_encode($get_method);
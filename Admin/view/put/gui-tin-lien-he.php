<?php
include('D:\xampp\htdocs\Projec PHP thuần\helpers\path.php');
Path::path_file_include('Database','Format','General','User_contact');
$Contact = new Contact();
$get_method = $Contact->exeContact();
echo json_encode($get_method);
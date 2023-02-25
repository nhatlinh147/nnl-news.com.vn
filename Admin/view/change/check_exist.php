<?php
ob_start();
Path::path_file_include('AdminSignIn', 'AdminSignUp');

$var_name = $_POST["var_name"];
$value = $_POST[$var_name];

$login = new AdminSignUp();
$database = new Database();

$$var_name = mysqli_real_escape_string($database->link, $value);

if (!empty($account_email)) {
    $query = "SELECT * FROM tbl_account WHERE Account_Email = '$account_email' LIMIT 1";
} else if (!empty($account_user)) {
    $query = "SELECT * FROM tbl_account WHERE Account_User = '$account_user' LIMIT 1";
} else if (!empty($banner_title)) {
    $query = "SELECT * FROM tbl_banner WHERE Banner_Title = '$banner_title' LIMIT 1";
} else if (!empty($cate_pro_name)) {
    $query = "SELECT * FROM tbl_category_product WHERE Cate_Pro_Name = '$cate_pro_name' LIMIT 1";
}

$result = $database->select($query);

if ($result) {
    echo 'false';
} else {
    echo 'true';
}

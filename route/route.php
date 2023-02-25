<?php
$routes = [
	"dang-ky" => "login/sign-up",
	"dang-nhap" => "login/sign-in",
	"trang-chu" => "index",
	"them-anh-bia" => "banner/banner_add",
	"danh-sach-anh-bia" => "banner/banner_list",
	"phan-trang-anh-bia" => "banner/banner_pagination",

	"them-danh-muc-san-pham" => "category/category_add",
	"danh-sach-danh-muc-san-pham" => "category/category_list",
	"phan-trang-danh-muc-san-pham" => "category/category_pagination",
	"sua-danh-muc-san-pham/(.+)/(\d+)" => "category/category_edit.php",

	"them-slide" => "slide/slider_add",
	"danh-sach-slide" => "slide/slider_list",
	"phan-trang-slide" => "slide/slider_pagination",
	"sua-slide/(.+)/(\d+)" => "slide/slider_edit.php?slider_slug=$1_$2",

	"them-san-pham" => "product/product_add",
	"danh-sach-san-pham" => "product/product_list",
	"phan-trang-san-pham" => "product/product_pagination",
	"sua-san-pham/(.+)/(\d+)" => "product/product_edit.php",

	"tuy-chinh-ckeditor" => "upload_product",

	"danh-sach-thuong-hieu-anh-bia" => "brand/brand_list",
	"them-thuong-hieu-san-pham" => "brand/brand_add",
	"thay-doi-trang-thai" => "change/change_status",
	"kiem-tra-ton-tai" => "change/check_exist",

	"thong-tin-website" => "info_contact/info_add",

	"dinh-dang-thu-gui" => "login/letter-confirm",
	"gui-mail-xac-nhan" => "login/notify-sending-email",
	"mail-xac-nhan-thanh-cong" => "login/notify-success",
	"dieu-huong-den-google" => "login/redirect-google",
];

// Xuất mảng mà key có đuôi html và không có đuôi html
if (!empty($routes) && is_array($routes)) {
	function tranfer_url($n)
	{
		return "Admin/($n|$n.html)$";
	}

	function tranfer_url_value($n)
	{
		return "Admin/view/$n";
	}

	$key = array_map('tranfer_url', array_keys($routes));
	$value = array_map('tranfer_url_value', array_values($routes));

	$routes = array_combine($key, $value);
}

// Admin/(dang-ky|dang-ky.html)$ => Admin/view/index

$routes_user = [
	"trang-chu" => "index",
	"xem-tin-tuc/(.+)" => "product-detail/detail.php?product_slug=$1",
	"danh-muc/(.+)" => "category/category-main.php?category_slug=$1",
	"lien-he" => "contact/contact.php",
	"dang-nhap" => "login/sign-in.php",
	"gui-mail-lien-he" => "contact/letter-contact.php",
];

if (!empty($routes) && is_array($routes)) {

	$key = array_map(function ($n) {
		return "($n|$n.html)$";
	}, array_keys($routes_user));
	$value = array_map(function ($n) {
		return "view/$n";
	}, array_values($routes_user));

	$routes_user = array_combine($key, $value);
}

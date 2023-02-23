<?php
Path::path_file_include('User_home', 'Category', 'View_put_content-middle');

//Khởi tạo đối tượng
$home = new Home();
$detail = new Detail();
$category = new category();

//Hiên thị dữ liệu
$show_home = $home->show_home();
$show_slide = $show_home['slide'];
$category_parent = $show_home['category_parent'];
$category_parent = General::getArrayFetchAssoc($category_parent); //dùng cho clabels footer
$show_banner = $show_home['banner']; //dùng cho clabels footer

$product_popular = General::getArrayFetchAssoc($show_home['product_popular']);
$recent_product = $show_home['recent_product'];
$show_category = General::getArrayFetchAssoc($show_home['category']);

$leftbar = $home->productOfCateChild(37, 3);
$middle = $home->productOfCateChild(47, 6);
$rightbar = $home->productOfCateChild(54, 3);
$footer_info = $show_home['info'];

$singleCategoryOne = $home->productOfCateChild(64, 4);

$singleCategory = [
   [
      'data' => $home->productOfCateChild(70, 3),
   ],
   [
      'data' => $home->productOfCateChild(77, 3),
   ],
   [
      'data' => $home->productOfCateChild(86, 3),
   ],
   [
      'data' => $home->productOfCateChild(95, 3),
   ]
];

$singleCategory = json_decode(json_encode($singleCategory));

$singleCategoryTwo = $home->productOfCateChild(81, 4);

//Xử lý ngày
function product_date($date)
{
   return date_format(date_create($date), 'd/m/Y h:i:s');
}

//Xử lý dữ liệu image
function product_upload($result)
{
   $image_name = pathinfo($result)['filename'];
   $image_name = Path::path_file("Upload_product_$image_name");
   return $image_name;
}

//Xử lý dữ liệu link
function linkProductDetail($value)
{
   return General::view_link("xem-tin-tuc/" . $value, true);
}
function linkCategory($value)
{
   return General::view_link("danh-muc/" . $value, true);
}

//Update lại view trong trường hợp không phải là link tin tức
if (!is_numeric(strpos($_GET['url'], "xem-tin-tuc"))) {
   $get = $detail->getSlugViewLatest();
   $get ? $detail->update_view($get['slug'], $get['view']) : false;
}

<?php
    $type = $_POST["type"];

    switch ($type){
        case "category":
            Path::path_file_include('Category');
            $cate = new category();
            $cate->update_category_status($_POST["status"],$_POST["id"]);
            break;
        case "brand":
            Path::path_file_include('Brand');
            $brand = new brand();
            $brand->update_brand_status($_POST["status"],$_POST["id"]);
            break;
        case "product":
            Path::path_file_include('Product');
            $product = new product();
            $product->update_product_status($_POST["status"],$_POST["id"]);
            break;
        case "slider":
            Path::path_file_include('Slider');
            $slider = new slider();
            $slider->update_slider_status($_POST["status"],$_POST["id"]);
            break;
        case "banner":
            Path::path_file_include('Banner');
            $banner = new banner();
            $banner->update_banner_status($_POST["status"],$_POST["id"]);
            break;
    }

?>

<?php
    // if($_POST["type"] == 'category'){
    //     Path::path_file_include('Category');
    //     $cate = new category();
    //     $cate->update_category_status($_POST["status"],$_POST["id"]);
    // }elseif($_POST["type"] == 'brand'){
    //     Path::path_file_include('Brand');
    //     $brand = new brand();
    //     $brand->update_brand_status($_POST["status"],$_POST["id"]);
    // }elseif($_POST["type"] == 'product'){
    //     Path::path_file_include('Product');
    //     $product = new product();
    //     $product->update_product_status($_POST["status"],$_POST["id"]);
    // }elseif($_POST["type"] == 'slider'){
    //     Path::path_file_include('Slider');
    //     $slider = new slider();
    //     $slider->update_slider_status($_POST["status"],$_POST["id"]);
    // }elseif($_POST["type"] == 'banner'){
    //     Path::path_file_include('Banner');
    //     $banner = new banner();
    //     $banner->update_banner_status($_POST["status"],$_POST["id"]);
    // }
?>
<?php
Path::path_file_include('Product', 'Category', 'Resize_image');
$product = new product();
$pro = $product->productTitleAdmin();
$title = $pro["title_edit"];
?>

<!-- Tải tài nguyên ban đầu -->
<?php Path::path_file_include('Inc_header_resource') ?>

<body>
    <section id="container">

        <!-- Phần đầu trong nội dung trang web -->
        <?php Path::path_file_include('Inc_header') ?>

        <!-- Thanh sidebar: menu quản lý các đường dẫn trong trang web -->
        <?php Path::path_file_include('Inc_sidebar') ?>

        <?php

        if (!General::getParam(1)) {
            General::view_link_location('danh-sach-san-pham');
        } else {

            $id = General::getParam(1);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $updateProduct = $product->update_product($_POST, $_FILES, $id);
            }
        }

        ?>
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="form-w3layouts">

                    <!-- page start-->
                    <!-- page start-->
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Sửa bài đăng sản phẩm
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <?php
                                        if (isset($updateProduct)) {
                                            echo $updateProduct;
                                        }
                                        ?>
                                        <?php
                                        $get_product_by_id = $product->getproductbyId($id);
                                        if ($get_product_by_id) {
                                            while ($result_product = $get_product_by_id->fetch_assoc()) {
                                                $image_name = pathinfo($result_product['Product_Image'])['filename'];
                                        ?>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Tên sản phẩm:</label>
                                                        <input type="text" name="product_name" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Tên sản phẩm" value="<?php echo $result_product['Product_Name'] ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Slug sản phẩm</label>
                                                        <input type="text" name="product_slug" class="form-control" id="convert_slug" placeholder="Slug sản phẩm" value="<?php echo $result_product['Product_Slug'] ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                                        <input type="file" class="form-control product_image" id="IMAGE" name="product_image" placeholder="Hình ảnh sản phẩm">
                                                        <div id="view_image" style="margin-top:8px ;">
                                                            <p style="font-style: italic; font-weight: bold;font-size: 10pt;">Hình ảnh sản
                                                                phẩm hiện tại: </p>
                                                            <img src="<?php echo Path::path_file("Upload_product_$image_name") ?>" width="200">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                                        <textarea style="resize: none" rows="3" class="form-control product_content" name="product_content" id="Ckeditor_Content"><?php echo $result_product['Product_Content'] ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Từ khóa tìm kiến</label>
                                                        <textarea style="resize: none" rows="6" class="form-control" name="meta_keywords_product" id="Meta_Keywords_Product"><?php echo $result_product['Meta_Keywords_Product'] ?></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Mô tả thẻ meta</label>
                                                        <textarea style="resize: none" rows="3" class="form-control meta_desc_product" name="meta_desc_product" id="Ckeditor_Meta_Desc"><?php echo $result_product['Meta_Desc_Product'] ?></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="">Danh mục sản phẩm</label>
                                                        <select name="cate_pro_id" class="form-control m-bot15" id="Cate_Pro">
                                                            <option value="">Chọn danh mục sản phẩm</option>

                                                            <?php
                                                            $cat = new category();
                                                            $catlist = $cat->list_category();
                                                            if ($catlist) {
                                                                while ($result = $catlist->fetch_assoc()) {
                                                                    if ($result['Cate_Pro_Parent'] != 0) {
                                                                        $selected = $result_product['Cate_Pro_ID'] == $result['Cate_Pro_ID'] ? 'selected' : '';
                                                                        echo '<option value="' . $result['Cate_Pro_ID'] . '" ' . $selected . '>' . $result['Cate_Pro_Name'] . '</option>';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <button type="submit" class="btn btn-info">Cập nhật danh mục</button>
                                                </form>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>

                                </div>
                            </section>

                        </div>
                    </div>
                    <!-- page end-->

                </div>
            </section>

            <?php Path::path_file_include('Inc_footer') ?>

        </section>
    </section>
    <!-- Tập hợp file js -->
    <?php Path::path_file_include('Inc_script_resource') ?>

    <!-- Kết nối đến script slug -->
    <?php Path::path_file_include('Inc_transfer_slug') ?>

    <!-- Kết nối đến ckeditor -->
    <?php Path::path_file_include('Inc_ckeditor_replace') ?>

    <!-- Upload Image -->
    <?php Path::path_file_include('Inc_script_upload_file') ?>

    <!-- css thuộc tính thông báo lỗi trên trong panel -->
    <!-- Thêm button close vào thông báo -->
    <?php echo Path::path_file_include('Inc_style_notification_panel') ?>

    <!-- Định dạng tiền tệ -->
    <script src="js/simple.money.format.js"></script>
    <script>
        $('.format_price').simpleMoneyFormat();
    </script>

</body>

</html>
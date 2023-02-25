<?php
    //code php phải sau Inc_header_resource để có thể khởi tạo được object
    Path::path_file_include('Product','Category','Resize_image');
    $product = new product();
    $pro = $product->productTitleAdmin();
    $title = $pro["title_add"];
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
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button_submit'])) {
                
                $insertProduct = $product->insert_product($_POST,$_FILES);
                
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
                                    Thêm sản phẩm
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <?php
                                            if(isset($insertProduct)){
                                                echo $insertProduct;
                                            }
                                        ?>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tên sản phẩm:</label>
                                                <input type="text" name="product_name" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Tên sản phẩm">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Slug sản phẩm</label>
                                                <input type="text" name="product_slug" class="form-control" id="convert_slug" placeholder="Slug sản phẩm">
                                            </div>
                            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                                <input type="file" name="product_image" class="form-control"
                                                id="IMAGE" placeholder="Hình ảnh sản phẩm">
                                            </div>
                                            <div id="view_image" style="margin-top:8px ;">
                            
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                                <textarea style="resize: none" rows="3" class="form-control" name="product_content" id="Ckeditor_Content"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Từ khóa tìm kiến</label>
                                                <textarea style="resize: none" rows="6" class="form-control" name="meta_keywords_product" id="Meta_Keywords_Product"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Mô tả thẻ meta</label>
                                                <textarea style="resize: none" rows="6" class="form-control" name="meta_desc_product" id="Ckeditor_Meta_Desc"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Danh mục sản phẩm</label>
                                                <select name="cate_pro_id" class="form-control m-bot15" id="Cate_Pro">
                                                    <option value="0">Chọn danh mục sản phẩm</option>
                                                    <?php
                                                        $cat = new category();
                                                        $catlist = $cat->category_parent();
                                                        if($catlist){
                                                            while($result = $catlist->fetch_assoc()){
                                                                echo '<optgroup value="'.$result['Cate_Pro_ID'].'" label="'.$result['Cate_Pro_Name'].'">';
                                                                $parent_id = $result['Cate_Pro_ID'];
                                                                $child = $cat->category_child_by_parent($parent_id);
                                                                if($child){
                                                                    while($result_child = $child->fetch_assoc()){
                                                                    echo '<option value="'.$result_child['Cate_Pro_ID'].'">'.$result_child['Cate_Pro_Name'].'</option>';
                                                                    }
                                                                }
                                                            }
                                                            echo '</optgroup>';
                                                        }
                                            
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Hiển thị</label>
                                                <select name="product_status" class="form-control m-bot15">
                                                    <option value="0">Ẩn</option>
                                                    <option value="1" selected>Hiển thị</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-info" name="button_submit">Thêm sản phẩm</button>
                                        </form>
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

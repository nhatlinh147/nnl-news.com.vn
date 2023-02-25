<?php
    //code php phải sau Inc_header_resource để có thể khởi tạo được object
    Path::path_file_include('Slider','Resize_image');
    $slide = new slider();
    $tit_slider = $slide->slideTitleAdmin();
    $GLOBALS['title'] = $tit_slider["title_add"];
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
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
               $insertSlider = $slide->insert_slider($_POST,$_FILES);     
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
                                    Thêm slide
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <?php
                                            if(isset($insertSlider)){
                                                echo $insertSlider;
                                            }
                                        ?>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tiêu đề slide: </label>
                                                <input type="text" name="slide_title" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Tiêu đề slide">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Slug slide: </label>
                                                <input type="text" name="slide_slug" class="form-control" id="convert_slug" placeholder="Slug slide">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Hình ảnh slide: </label>
                                                <input type="file" name="slide_image" class="form-control"
                                                id="IMAGE" placeholder="Hình ảnh slide">
                                            </div>
                                            <div id="view_image" style="margin-top:8px ;">
                            
                                            </div>
                                             <div class="form-group">
                                                <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                                <textarea style="resize: none" rows="3" class="form-control" name="slide_desc" id="slide_desc"></textarea>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="">Hiển thị</label>
                                                <select name="slide_status" class="form-control m-bot15">
                                                    <option value="0">Ẩn</option>
                                                    <option value="1">Hiển thị</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-info">Thêm danh mục</button>
                                        </form>
                                    </div>

                                </div>
                            </section>

                        </div>
                    </div>
                    <!-- page end-->
                    <!-- page end-->

                </div>
            </section>
            
           <?php Path::path_file_include('Inc_footer') ?>

        </section>
    </section>
        <!-- css thuộc tính thông báo lỗi trên trong panel -->
        <!-- Thêm button close vào thông báo -->
        <?php echo Path::path_file_include('Inc_style_notification_panel') ?>
        
        <!-- Tập hợp file js -->
        <?php Path::path_file_include('Inc_script_resource') ?>

        <!-- Kết nối đến script slug -->
        <?php Path::path_file_include('Inc_transfer_slug') ?>

        <!-- Upload Image -->
        <?php Path::path_file_include('Inc_script_upload_file') ?>

        <!-- Customize Script -->
        <?php Path::path_file_include('View_category_script_add') ?>
    </body>
</html>

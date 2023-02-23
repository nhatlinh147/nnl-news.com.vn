<?php
    //code php phải sau Inc_header_resource để có thể khởi tạo được object
    Path::path_file_include('Category');
    $cat = new category();
    $cate = $cat->cateproTitleAdmin();
    $GLOBALS['title'] = $cate["title_add"];
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

                $insertCat = $cat->insert_category($_POST);
                
            }
            $show_cate = $cat->category_parent();
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
                                    Thêm danh mục sản phẩm
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <?php
                                            if(isset($insertCat)){
                                                echo $insertCat;
                                            }
                                        ?>
                                        <form action="<?php echo General::view_link("them-danh-muc-san-pham.html"); ?>" method="post" id = "Form_Category_Add">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tên danh mục </label>
                                                <input type="text" name="cate_pro_name" class="form-control cate_pro_name" onkeyup="ChangeToSlug()" id="slug" placeholder="Tên danh mục">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Slug danh mục</label>
                                                <input type="text" name="cate_pro_slug" class="form-control cate_pro_slug" id="convert_slug" placeholder="Tên danh mục">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Từ khóa danh mục</label>
                                                <textarea style="resize: none" rows="6" class="form-control" name="meta_keywords_catepro" id="Meta_Keywords_CatePro"></textarea>
                                            </div>
                                            <?php
                                                if($show_cate){
                                            ?>
                                            <div class="form-group">
                                                <label for="">Danh mục cha (Không bắt buộc)</label>
                                                <select name="cate_pro_parent" class="form-control m-bot15">
                                                    <option value="0">Lựa chọn danh mục cha</option>
                                                <?php
                                                    $i = 0;
                                                    while($result = $show_cate->fetch_assoc()){
                                                    $i++;
                                                ?>
                                                    <option value="<?php echo $result['Cate_Pro_ID'] ?>"><?php echo $result['Cate_Pro_Name'] ?></option>
                                                 <?php
                                                    }
                                                ?>
                                                </select>
                                            </div>

                                            <?php
                                                }else{
                                                    echo '';
                                                }
                                            ?>
                                           
                                            <div class="form-group">
                                                <label for="">Hiển thị</label>
                                                <select name="cate_pro_status" class="form-control m-bot15">
                                                    <option value="0">Ẩn</option>
                                                    <option value="1" selected>Hiển thị</option>
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

        <!-- Customize Script -->
        <?php Path::path_file_include('View_category_script_add') ?>

    </body>
</html>

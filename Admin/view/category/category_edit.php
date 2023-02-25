<?php
    //code php phải sau Inc_header_resource để có thể khởi tạo được object
    Path::path_file_include('Category');
    
    $cat = new category();
    $cate = $cat->cateproTitleAdmin();
    $title = $cate["title_edit"];
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

            if(!General::getParam(1)){
               echo "<script>window.location ='danh-sach-danh-muc-san-pham.php'</script>";
            }else{
                $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                $id = General::getParam(1);
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $_POST['cate_pro_id'] = $id;
                    $updateCat = $cat->update_category($_POST);
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
                                    Basic Forms
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <?php
                                            if(isset($updateCat)){
                                                echo $updateCat;
                                                General::view('danh-sach-danh-muc-san-pham.html');
                                            }
                                        ?>
                                        <?php
                                            $get_cate_name = $cat->getcatbyId($id);
                                            if($get_cate_name){
                                                while($result = $get_cate_name->fetch_assoc()){
                                               
                                        ?>
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tên danh mục </label>
                                                <input type="text" name="cate_pro_name" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Tên danh mục" value="<?php echo $result['Cate_Pro_Name'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Slug danh mục</label>
                                                <input type="text" name="cate_pro_slug" class="form-control" id="convert_slug" placeholder="Tên danh mục" value="<?php echo $result['Cate_Pro_Slug'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Từ khóa danh mục</label>
                                                <textarea style="resize: none" rows="6" class="form-control" name="meta_keywords_catepro" id="Meta_Keywords_CatePro"><?php echo $result['Meta_Keywords_CatePro'] ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Danh mục sản phẩm cha</label>
                                                <select name="cate_pro_parent" class="form-control m-bot15" id="Cate_Pro">
                                                    <option value="0">Lựa chọn danh mục sản phẩm cha</option>

                                           <?php
                                            $catlistparent = $cat->category_parent();
                                                if($result['Cate_Pro_Parent'] != 0){
                                                    if($catlistparent){
                                                        while($parent = $catlistparent->fetch_assoc()){
                                                            $selected = $result["Cate_Pro_Parent"] == $parent["Cate_Pro_ID"] ? 'selected': ''; 
                                                            echo
                                                            '<option '. $selected.' value="'.$parent['Cate_Pro_ID'].'">'.$parent['Cate_Pro_Name'].'</option>';
                                                        }
                                                    }
                                                }else{
                                                    while($parent = $catlistparent->fetch_assoc()){
                                                        if($result['Cate_Pro_Name'] != $parent['Cate_Pro_Name']){
                                                            echo '<option value="'.$parent['Cate_Pro_ID'].'">'.$parent['Cate_Pro_Name'].'</option>';
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
        <!-- css thuộc tính thông báo lỗi trên trong panel -->
        <?php echo Path::path_file_include('Inc_style_notification_panel') ?>
        
        <!-- Tập hợp file js -->
        <?php Path::path_file_include('Inc_script_resource') ?>

        <!-- Kết nối đến script slug -->
        <?php Path::path_file_include('Inc_transfer_slug') ?>

        <!-- Customize Script -->
        <?php Path::path_file_include('View_category_script_add') ?>
    </body>
</html>

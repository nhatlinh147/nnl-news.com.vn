<?php include '../classes/brand.php' ?>
<?php
    $brand = new brand();
    $brand_pro = $brand->brandproTitleAdmin();
    $title = $brand_pro["title_edit"];
?>
<?php include 'inc/header_resource.php';?>

<body>
    <section id="container">

        <?php include 'inc/header.php';?>

        <?php include 'inc/sidebar.php';?>

        <?php

            if(!isset($_GET['brand_slug']) || $_GET['brand_slug']==NULL){
               echo "<script>window.location ='brand_list.php'</script>";
            }else{
                $new_arr = explode("_", $_GET['brand_slug']);
                $id = $new_arr[count($new_arr)-1];

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    $brandName = $_POST['brand_product_name'];
                    $brandSlug = $_POST['brand_product_slug'];
                    $metaKeywordsBrandpro = $_POST['meta_keywords_brandpro'];
     
                    $updateBrand = $brand->update_brand($brandName,$brandSlug,$metaKeywordsBrandpro,$id);
                    
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
                                            if(isset($updateBrand)){
                                                echo $updateBrand;
                                            }
                                        ?>
                                        <?php
                                            $get_brand_name = $brand->getbrandbyId($id);
                                            if($get_brand_name){
                                                while($result = $get_brand_name->fetch_assoc()){
                                               
                                        ?>
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">T??n danh m???c </label>
                                                <input type="text" name="brand_product_name" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="T??n th????ng hi???u" value="<?php echo $result['Brand_Pro_Name'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Slug danh m???c</label>
                                                <input type="text" name="brand_product_slug" class="form-control" id="convert_slug" placeholder="Slug th????ng hi???u" value="<?php echo $result['Brand_Pro_Slug'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">T??? kh??a danh m???c</label>
                                                <textarea style="resize: none" rows="6" class="form-control" name="meta_keywords_brandpro" id="Meta_Keywords_BrandPro"><?php echo $result['Meta_Keywords_BrandPro'] ?></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-info">C???p nh???t danh m???c</button>
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
                    <!-- page end-->

                </div>
            </section>
            
            <?php include 'inc/footer.php' ?>

        </section>
    </section>
        <?php include 'inc/transfer_slug.php';?>

        <!-- css thu???c t??nh th??ng b??o l???i tr??n trong panel -->
        <?php include 'inc/style_notification_panel.php' ?>

        <script src="js/bootstrap.js"></script>
        <script src="js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="js/scripts.js"></script>
        <script src="js/jquery.slimscroll.js"></script>
        <script src="js/jquery.nicescroll.js"></script>
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
        <script src="js/jquery.scrollTo.js"></script>
    </body>
</html>

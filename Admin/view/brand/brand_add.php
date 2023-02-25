<?php include '../classes/brand.php' ?>
<?php
    $brand = new brand();
    $brand_pro = $brand->brandproTitleAdmin();
    $title = $brand_pro["title_add"];
?>

<?php include 'inc/header_resource.php';?>

<body>
    <section id="container">

        <?php include 'inc/header.php';?>

        <?php include 'inc/sidebar.php';?>

        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $brandName = $_POST['brand_product_name'];
                $brandSlug = $_POST['brand_product_slug'];
                $metaKeywordsBrandpro = $_POST['meta_keywords_brandpro'];
                $brandStatus = $_POST['brand_product_status'];

                // Truyền biến vào controller insert_brand
                $insertBrand = $brand->insert_brand($brandName,$brandSlug,$brandStatus,$metaKeywordsBrandpro);
                
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
                                    Thêm thương hiệu sản phẩm
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <?php
                                            if(isset($insertBrand)){
                                                echo $insertBrand;
                                            }
                                        ?>
                                        <form action="brand_add.php" method="post">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tên thương hiệu </label>
                                                <input type="text" name="brand_product_name" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Tên thương hiệu">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Slug thương hiệu</label>
                                                <input type="text" name="brand_product_slug" class="form-control" id="convert_slug" placeholder="Slug thương hiệu">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Từ khóa thương hiệu</label>
                                                <textarea style="resize: none" rows="6" class="form-control" name="meta_keywords_brandpro" id="Meta_Keywords_BrandPro"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Hiển thị</label>
                                                <select name="brand_product_status" class="form-control input-sm m-bot15">
                                                    <option value="0">Ẩn</option>
                                                    <option value="1">Hiển thị</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-info">Thêm thương hiệu</button>
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
            
            <?php include 'inc/footer.php' ?>

        </section>
    </section>
        <?php include 'inc/transfer_slug.php';?>
        
        <script>
            $('li.sub-menu a').eq(3).addClass('active');
            if($('li.sub-menu a').length){
                $('ul.sub li a').eq(2).addClass('active');
            }
        </script>

        <!-- css thuộc tính thông báo lỗi trên trong panel -->
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

<?php include '../classes/brand.php' ?>
<?php
    $brand = new brand();
    $brand_pro = $brand->brandproTitleAdmin();
    $title = $brand_pro["title_list"];
?>

<?php include 'inc/header_resource.php';?>

<body>
    <section id="container">

        <?php include 'inc/header.php';?>

        <?php include 'inc/sidebar.php';?>

        <?php
            if(isset($_GET['delete_slug'])){
                $new_arr = explode("_", $_GET['delete_slug']);
                $id = $new_arr[count($new_arr)-1];
                $delete_brand = $brand->delete_brand($id);
            }
        ?>
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="table-agile-info">
                 <div class="panel panel-default">
                    <?php
                        if(isset($delete_brand)){
                            echo $delete_brand;
                        }
                    ?>
                     <div id="notify_error_success"></div>
                    <div class="panel-heading">Quản lý thương hiệu sản phẩm</div>

                    <div class="row w3-res-tb">
                        <div class="col-sm-5 m-b-xs">
                            <select class="input-sm form-control w-sm inline v-middle">
                                <option value="0">Bulk action</option>
                                <option value="1">Delete selected</option>
                                <option value="2">Bulk edit</option>
                                <option value="3">Export</option>
                            </select>
                            <button class="btn btn-sm btn-default">Apply</button>
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="input-sm form-control" placeholder="Search">
                                <span class="input-group-btn">
                                    <button class="btn btn-sm btn-default" type="button">Go!</button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" id="pagination_data">
                      
                    </div>
                  </div>
                </div>
            </section>
            
            <?php include 'inc/footer.php' ?>

        </section>
    </section>
        <script>
            $('li.sub-menu a').eq(3).addClass('active');
            if($('li.sub-menu a').length){
                 $('ul.sub li a').eq(3).addClass('active');
            }
        </script>
        <script>
            $(document).ready(function(){  
                load_data();  
                    function load_data(page)  
                    {  
                        $.ajax({  
                            url:"brand_pagination.php",  
                            method:"POST",  
                            data:{page:page},  
                            success:function(data){  
                                $('#pagination_data').html(data);
                                $('li#'+page).addClass('active');
                                if($('li.active').length < 1){
                                    $('li#1').addClass('active');
                                }
                            }  
                        })  
                    }  
            $(document).on('click', '.pagination_link', function(){  
                    var page = $(this).attr("id");
                    load_data(page);
                });
            });  
        </script>

        <?php include 'inc/update_status_script.php' ?>
        
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

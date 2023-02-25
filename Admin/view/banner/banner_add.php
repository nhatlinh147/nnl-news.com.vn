<?php
Path::path_file_include('Banner', 'Resize_image');
$banner = new banner();
$data_banner = $banner->bannerTitleAdmin();
$title = $data_banner["title_add"];
?>

<?php Path::path_file_include('Inc_header_resource') ?>

<body>
    <section id="container">

        <?php Path::path_file_include('Inc_header') ?>

        <?php Path::path_file_include('Inc_sidebar') ?>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $insertBanner = $banner->insert_banner($_POST, $_FILES);
        }
        ?>

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="form-w3layouts">

                    <!-- page start-->
                    <div class="row">
                        <div class="col-lg-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    Thêm banner
                                </header>
                                <div class="panel-body">
                                    <div class="position-center">
                                        <?php
                                        if (isset($insertBanner)) {
                                            echo $insertBanner;
                                        }
                                        ?>
                                        <form action="<?php echo General::view_link('them-anh-bia.html') ?>" method="post" enctype="multipart/form-data" id="Form_Banner_Add">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Tiêu đề banner: </label>
                                                <input type="text" name="banner_title" class="form-control banner_title" onkeyup="ChangeToSlug()" id="slug" placeholder="Tên thương hiệu">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Slug banner: </label>
                                                <input type="text" name="banner_slug" class="form-control" id="convert_slug" placeholder="Slug banner">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Thời hạn banner: </label>
                                                <input type="text" name="banner_exprired" id="DATE_END" class="form-control" placeholder="Thời hạn banner">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Hình ảnh banner: </label>
                                                <input type="file" name="banner_image" class="form-control" id="IMAGE" placeholder="Hình ảnh banner">
                                            </div>
                                            <div id="view_image" style="margin-top:8px ;">

                                            </div>
                                            <div class="form-group">
                                                <label for="">Ẩn/Hiển thị</label>
                                                <select name="banner_status" class="form-control input-sm m-bot15 banner_status">
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

    <!-- Kết nối đến script datepicker -->
    <?php Path::path_file_include('Inc_script_jquery_ui') ?>

    <!-- Upload Image -->
    <?php Path::path_file_include('Inc_script_upload_file') ?>

    <!-- Customize Script -->
    <?php Path::path_file_include('View_banner_script_add') ?>
</body>

</html>
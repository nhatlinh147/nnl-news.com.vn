<?php
Path::path_file_include('Banner');
$banner = new banner();
$tit_banner = $banner->bannerTitleAdmin();
$title = $tit_banner["title_list"];
?>

<?php Path::path_file_include('Inc_header_resource') ?>

<body>
    <section id="container">

        <?php Path::path_file_include('Inc_header') ?>

        <?php Path::path_file_include('Inc_sidebar') ?>

        <?php
        //Đề phòng trường hợp delete xác định paginate hiện tại
        $page = empty($_GET['page']) ? 1 : $_GET['page'];
        $number_page = empty($_GET['number_page']) ? 10 : $_GET['number_page'];

        $result = $banner->list_banner();
        $total_records = $result ? $result->num_rows : 0;

        $page = General::get_check_page($page, $total_records, $number_page);

        if (isset($_GET['delete_slug'])) {
            $new_arr = explode("_", $_GET['delete_slug']);
            $id = $new_arr[count($new_arr) - 1];
            $del_banner = $banner->delete_banner($id, $page, $number_page);
        }
        ?>
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="table-agile-info">
                    <div class="panel panel-default">
                        <?php
                        ob_end_flush();
                        if (isset($del_banner)) {
                            echo $del_banner;
                        }

                        ?>
                        <div id="notify_error_success"></div>
                        <div class="panel-heading">Quản lý thương hiệu sản phẩm</div>

                        <div class="row w3-res-tb">
                            <div class="col-sm-5 m-b-xs">
                                <select class="input-sm form-control w-sm inline v-middle" id="pagi_number_page">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <label>Tìm kiếm</label>
                                    <input type="text" class="input-sm form-control" id="Search_Admin" placeholder="Search">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive" id="pagination_data">

                        </div>

                    </div>
                </div>
            </section>

            <?php Path::path_file_include('Inc_footer'); ?>

        </section>
    </section>
    <!-- css thuộc tính thông báo lỗi trên trong panel -->
    <?php echo Path::path_file_include('Inc_style_notification_panel') ?>

    <!-- Cập nhật trạng thái -->
    <?php Path::path_file_include('Inc_update_status_script') ?>

    <!-- Tập hợp file js -->
    <?php Path::path_file_include('Inc_script_resource') ?>

    <!-- Customize Script -->
    <?php Path::path_file_include('View_banner_script_list') ?>

</body>

</html>
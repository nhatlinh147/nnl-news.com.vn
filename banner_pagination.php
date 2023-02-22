<?php
Path::path_file_include('Banner');
?>
<?php
$record_per_page = (int)$_POST["number_page"];
$banner = new banner();
if (isset($_POST["page"])) {
    $page = $_POST["page"];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $record_per_page;
?>

<table class="table table-striped b-t b-light" ui-jq="footable" ui-options='{
"paging": {
"enabled": true
},
"filtering": {
"enabled": true
},
"sorting": {
"enabled": true
}}'>
    <thead>
        <tr>
            <th data-breakpoints="xs">ID</th>
            <th>Tiêu đề</th>
            <th>Hình ảnh</th>
            <th>Ẩn/Hiển thị</th>
            <th>Sửa/Xóa</th>
            <!-- <th data-breakpoints="xs">Job Title</th>

<th data-breakpoints="xs sm md" data-title="DOB">Date of Birth</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        $show_banner = $_POST["search"] == '' ? $banner->show_banner($start_from, $record_per_page) : $banner->search_banner($_POST["search"], $start_from, $record_per_page);;
        if ($show_banner) {
            $i = 0;
            while ($result = $show_banner->fetch_assoc()) {
                $i++;
        ?>
                <tr class="odd gradeX">
                    <td>
                        <?php echo $i ?>
                    </td>
                    <td>
                        <?php echo $result['Banner_Title'] ?>
                    </td>
                    <td>
                        <img src="../Admin/upload/banner/<?php echo $result['Banner_Image'] ?>" width="90" height="90">
                    </td>
                    <td class="content_status_<?php echo $result["Banner_ID"] ?>">
                        <?php $str = $result['Banner_Status'] == 1 ? '<i data="' . $result["Banner_ID"] . '" class="fa fa-thumbs-o-up fa-2x text-success status_checks" data_type="banner"></i>' : '<i data="' . $result["Banner_ID"] . '" class="fa fa-thumbs-o-down fa-2x text-danger status_checks" data_type="banner"></i>';
                        echo $str; ?>
                    </td>
                    <td><a onclick="return confirm('Are you want to delete?')" href="?delete_slug=<?php echo $result['Banner_Slug'] . '_' . $result['Banner_ID'] ?>&page=<?php echo $page ?>&number_page=<?php echo $record_per_page; ?>">Delete</a>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo '<td colspan="6" class="text-center" style="text-transform:uppercase">Không có banner</td>';
        }
        ?>
    </tbody>
</table>
<footer class="panel-footer">
    <div class="row">
        <?php
        if ($banner->list_search_banner($_POST["search"])) {
        ?>

            <!-- Nơi hiển thị kết quả trên mỗi phân trang -->
            <div class="col-sm-5 text-center showing_item">
                <?php

                $total_records = $_POST["search"] ? mysqli_num_rows($banner->list_search_banner($_POST["search"])) : mysqli_num_rows($banner->list_banner());

                $total_pages = ceil($total_records / $record_per_page);

                ?>
            </div>

            <!-- Nơi hiển thị số lượng phân trang -->
            <div class="col-sm-7 text-right text-center-xs">
                <?php Path::path_file_include('Inc_paginate_data') ?>
            </div>
        <?php
        }
        ?>
    </div>
</footer>
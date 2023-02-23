<?php
    Path::path_file_include('Slider');
?>
<?php
    $record_per_page = 4;
    $slider = new slider();
    if(isset($_POST["page"]))  
    {  
      $page = $_POST["page"];  
    }  
    else  
    {  
      $page = 1;  
    }
    $start_from = ($page - 1)*$record_per_page;  
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
            <th>Slug</th>
            <th>Hình ảnh</th>
            <th>Ẩn/Hiển thị</th>
            <th>Sửa/Xóa</th>
            <!-- <th data-breakpoints="xs">Job Title</th>

<th data-breakpoints="xs sm md" data-title="DOB">Date of Birth</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
            $show_slide = $_POST["search"] == '' ? $slider->show_slider($start_from,$record_per_page) : $slider->search_slider($_POST["search"],$start_from,$record_per_page);

            if($show_slide){
                $i = 0;
                while($result = $show_slide->fetch_assoc()){
                $i++;
        ?>
        <tr class="odd gradeX">
            <td>
                <?php echo $i ?>
            </td>
            <td>
                <?php echo $result['Slide_Title'] ?>
            </td>
            <td>
                <?php echo $result['Slide_Slug'] ?>
            </td>
            <td>
                <img src="../Admin/upload/slide/<?php echo $result['Slide_Image'] ?>" width="90" height="90">
            </td>
            <td class="content_status_<?php echo $result["Slide_ID"]?>">
                <?php $str=$result['Slide_Status']==1 ? '<i data="'.$result["Slide_ID"].'" class="fa fa-thumbs-o-up fa-2x text-success status_checks" data_type="slider"></i>' : '<i data="'.$result["Slide_ID"].'" class="fa fa-thumbs-o-down fa-2x text-danger status_checks" data_type="slider"></i>'; echo $str; ?>
            </td>
            <td><a href="sua-slide/<?php echo $result['Slide_Slug'].'/'.$result['Slide_ID'] ?>">Edit</a> || <a onclick="return confirm('Are you want to delete?')" href="?delete_slug=<?php echo $result['Slide_Slug'].'_'.$result['Slide_ID'] ?>">Delete</a>
            </td>
        </tr>
        <?php
                }
            }else{
                echo '<td colspan="6" class="text-center" style="text-transform:uppercase">Không có slide</td>';
            }
        ?>
    </tbody>
</table>
<footer class="panel-footer">
    <div class="row">
        <?php
            if($slider->list_search_slider($_POST["search"])){
        ?>
        
        <!-- Nơi hiển thị kết quả trên mỗi phân trang -->
        <div class="col-sm-5 text-center showing_item">
            <?php
            
                $total_records= $_POST["search"] ? mysqli_num_rows($slider->list_search_slider($_POST["search"])) : mysqli_num_rows($slider->list_slider());

                $total_pages=ceil($total_records/$record_per_page);

                echo "<small class='text-muted inline m-t-sm m-b-sm'>showing " . (int)($start_from + 1) ."-$record_per_page of  $total_records items</small>";
            ?>
        </div>

        <div class="col-sm-7 text-right text-center-xs">
            <?php Path::path_file_include('Inc_paginate_data') ?>
        </div>
        <?php
            }
        ?>
    </div>
</footer>
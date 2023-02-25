<?php
    Path::path_file_include('Category');
?>
<?php
    $record_per_page = (int)$_POST["number_page"];
    $cat = new category();
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
            <th>Tên danh mục</th>
            <th>Slug danh mục</th>
            <th>Từ khóa hiển thị</th>
            <th>Thuộc danh mục</th>
            <th>Ẩn/Hiển thị</th>
            <th>Sửa/Xóa</th>
            <!-- <th data-breakpoints="xs">Job Title</th>

<th data-breakpoints="xs sm md" data-title="DOB">Date of Birth</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
            $show_cate = $_POST["search"] == '' ? $cat->show_category($start_from,$record_per_page) : $cat->search_category($_POST["search"],$start_from,$record_per_page);
            if($show_cate){
                $i = 0;
                while($result = $show_cate->fetch_assoc()){
                $i++;
        ?>
        <tr class="odd gradeX">
            <td>
                <?php echo $i + $start_from ?>
            </td>
            <td>
                <?php echo $result['Cate_Pro_Name'] ?>
            </td>
            <td>
                <?php echo $result['Cate_Pro_Slug'] ?>
            </td>
            <td>
                <?php echo $result['Meta_Keywords_CatePro'] ?>
            </td>
            <?php 
                if($result['Cate_Pro_Parent'] == 0){
                    echo "<td style='color:green'>Danh mục cha</td>";
                }else{
                    $parent = $cat->getcatbyId($result['Cate_Pro_Parent'])->fetch_assoc();
                    echo "<td style='color:blue'>".$parent['Cate_Pro_Name']."</td>";
                }
            ?>
            <td class="content_status_<?php echo $result["Cate_Pro_ID"]?>">
                <?php $str=$result['Cate_Pro_Status']==1 ? '<i data="'.$result["Cate_Pro_ID"].'" class="fa fa-thumbs-o-up fa-2x text-success status_checks" data_type="category"></i>' : '<i data="'.$result["Cate_Pro_ID"].'" class="fa fa-thumbs-o-down fa-2x text-danger status_checks" data_type="category"></i>'; echo $str; ?>
            </td>
            <td><a href="sua-danh-muc-san-pham/<?php echo $result['Cate_Pro_Slug'].'/'.$result['Cate_Pro_ID'] ?>">Edit</a> || <a onclick="return confirm('Are you want to delete?')" href="?delete_slug=<?php echo $result['Cate_Pro_Slug'].'_'.$result['Cate_Pro_ID'] ?>&page=<?php echo $page ?>&number_page=<?php echo $record_per_page; ?>">Delete</a>
            </td>
        </tr>
        <?php
                }
            }else{
                echo '<td colspan="6" class="text-center" style="text-transform:uppercase">Không có danh mục sản phẩm</td>';
            }
        ?>
    </tbody>
</table>
<footer class="panel-footer">
    <div class="row">
        <?php
            // Xét tới điều kiện xuất hiện thanh paginate
            if($cat->list_search_category($_POST["search"])){
        ?>

        <!-- Nơi hiển thị kết quả trên mỗi phân trang -->
        <div class="col-sm-5 text-center showing_item">
            <?php
                $total_records= $_POST["search"] ? mysqli_num_rows($cat->list_search_category($_POST["search"])) : mysqli_num_rows($cat->list_category());
                $total_pages=ceil($total_records/$record_per_page);

                echo "<small class='text-muted inline m-t-sm m-b-sm'>showing " . (int)($start_from + 1) ."-$record_per_page of  $total_records items</small>";

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
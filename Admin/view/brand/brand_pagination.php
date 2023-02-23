<?php include '../classes/brand.php' ?>
<?php
    $record_per_page = 4;
    $brand = new brand();
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
            <th>Tên thương hiệu</th>
            <th>Slug thương hiệu</th>
            <th>Từ khóa hiển thị</th>
            <th>Ẩn/Hiển thị</th>
            <th>Sửa/Xóa</th>
            <!-- <th data-breakpoints="xs">Job Title</th>

<th data-breakpoints="xs sm md" data-title="DOB">Date of Birth</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
            $show_brand = $brand->show_brand($start_from,$record_per_page);
            if($show_brand){
                $i = 0;
                while($result = $show_brand->fetch_assoc()){
                $i++;
        ?>
        <tr class="odd gradeX">
            <td>
                <?php echo $i ?>
            </td>
            <td>
                <?php echo $result['Brand_Pro_Name'] ?>
            </td>
            <td>
                <?php echo $result['Brand_Pro_Slug'] ?>
            </td>
            <td>
                <?php echo $result['Meta_Keywords_BrandPro'] ?>
            </td>
            <td class="content_status_<?php echo $result["Brand_Pro_ID"]?>">
                <?php $str=$result['Brand_Pro_Status']==1 ? '<i data="'.$result["Brand_Pro_ID"].'" class="fa fa-thumbs-o-up fa-2x text-success status_checks" data_type="brand"></i>' : '<i data="'.$result["Brand_Pro_ID"].'" class="fa fa-thumbs-o-down fa-2x text-danger status_checks" data_type="brand"></i>'; echo $str; ?>
            </td>
            <td><a href="brand_edit.php?brand_slug=<?php echo $result['Brand_Pro_Slug'].'_'.$result['Brand_Pro_ID'] ?>">Edit</a> || <a onclick = "return confirm('Are you want to delete?')" href="?delete_slug=<?php echo $result['Brand_Pro_Slug'].'_'.$result['Brand_Pro_ID'] ?>">Delete</a>
            </td>
        </tr>
        <?php
                }
            }else{
                echo '<td colspan="6" class="text-center" style="text-transform:uppercase">Không có thương hiệu sản phẩm</td>';
            }
        ?>
    </tbody>
</table>
<footer class="panel-footer">
    <div class="row">

        <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
                <li><a href=""><i class="fa fa-chevron-left"></i></a>
                </li>
                <?php
                    $total_records= mysqli_num_rows($brand->list_brand());
                    $total_pages=ceil($total_records/$record_per_page);
                    $output='' ;
                    for($i=1; $i<=$total_pages; $i++) {
                        $output .='<li class="pagination_link" style="cursor:pointer" id="'.$i.'"><a>'.$i. '</a></li>';
                         // $output .= "<span class='pagination_link' style='cursor:pointer; padding:6px; border:1px solid #ccc;' id='".$i."'>".$i."</span>";  
                    }
                    echo $output;
                ?>
                <li><a href=""><i class="fa fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
    </div>
</footer>
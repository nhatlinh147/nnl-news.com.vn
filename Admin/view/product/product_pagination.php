<?php
    Path::path_file_include('Product');
?>

<?php
    $record_per_page = (int)$_POST["number_page"];
    $product = new product();
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
<table class="table" ui-jq="footable" ui-options='{
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
    <th>Tên sản phẩm</th>
    <th>Slug sản phẩm</th>
    <th>Danh mục</th>
    <th>Hình ảnh sản phẩm</th>
    <th>Ẩn/Hiển</th>
    <th>Sửa/Xóa</th>
    <!-- <th data-breakpoints="xs">Job Title</th>
   
    <th data-breakpoints="xs sm md" data-title="DOB">Date of Birth</th> -->
  </tr>
</thead>
<tbody>
    <?php
        $pdlist = $_POST["search"] == '' ? $product->show_product($start_from,$record_per_page) : $product->search_product($_POST["search"],$start_from,$record_per_page);
        
        if($pdlist){
            $i = 0;
            while($result = $pdlist->fetch_assoc()){
                $i++;
    ?>
            <tr class="odd gradeX">
                <td><?php echo $i + $start_from; ?></td>
                <td><?php echo $result['Product_Name'] ?></td>
                <td><?php echo $result['Product_Slug'] ?></td>
                <td><?php echo $result['Cate_Pro_Name'] ?></td>
                <td><img src="../Admin/upload/product/<?php echo $result['Product_Image'] ?>" width="90" height="90"></td>

                <td class="content_status_<?php echo $result["Product_ID"]?>">
                <?php $str=$result['Product_Status']==1 ? '<i data="'.$result["Product_ID"].'" class="fa fa-thumbs-o-up fa-2x text-success status_checks" data_type="product"></i>' : '<i data="'.$result["Product_ID"].'" class="fa fa-thumbs-o-down fa-2x text-danger status_checks" data_type="product"></i>'; echo $str; ?>
                </td>

                <td><a href="<?php echo "sua-san-pham/$result[Product_Slug]/$result[Product_ID]" ?>">Edit</a> || <a onclick = "return confirm('Are you want to delete?')" href="<?php echo "?delete_slug=$result[Product_Slug]_$result[Product_ID]&page=$page&number_page=$record_per_page" ?>">Delete</a></td>
            </tr>
    <?php
        }
            }else{
                echo '<td colspan="10" class="text-center" style="text-transform:uppercase">Không có sản phẩm</td>';
            }
    ?>
</tbody>
<tfoot>
    
</tfoot>
</table>
<footer class="panel-footer">
    <div class="row">
        <?php
            // Xét tới điều kiện xuất hiện thanh paginate
            if($product->list_search_product($_POST["search"])){
        ?>

       <!-- Nơi hiển thị kết quả trên mỗi phân trang -->
        <div class="col-sm-5 text-center showing_item">
            
            <?php
                $total_records= $_POST["search"] ? mysqli_num_rows($product->list_search_product($_POST["search"])) : mysqli_num_rows($product->list_product());

                 $total_pages = ceil($total_records/$record_per_page);

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
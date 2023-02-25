<?php
Path::path_file_include('Product', 'Middleware');
$product = new product();
$pro = $product->productTitleAdmin();
$title = $pro["title_list"];

?>

<!-- Tải tài nguyên ban đầu -->
<?php Path::path_file_include('Inc_header_resource') ?>

<body>
   <section id="container">

      <!-- Phần đầu trong nội dung trang web -->
      <?php Path::path_file_include('Inc_header') ?>

      <!-- Thanh sidebar: menu quản lý các đường dẫn trong trang web -->
      <?php Path::path_file_include('Inc_sidebar') ?>

      <?php
        $page = empty($_GET['page']) ? 1 : $_GET['page'];
        $number_page = empty($_GET['number_page']) ? 10 : $_GET['number_page'];

        $result = $product->list_product();
        $total_records = $result ? $result->num_rows : 0;
        $page = General::get_check_page($page, $total_records, $number_page);

        if (isset($_GET['delete_slug'])) {
            //Kiểm tra có url delete_slug hợp lệ không
            $middleware = new M_Product();
            $middleware = $middleware->check_delete_product($_GET['delete_slug']);

            $new_arr = explode("_", $_GET['delete_slug']);
            $id = $new_arr[count($new_arr) - 1];
            $delete_pro = $product->delete_product($id, $page, $number_page);

            // Đề phòng trường hợp xóa xong người dùng lại load lại url delete_slug
            General::view_link_location('danh-sach-san-pham');
        }
        ?>

      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
            <div class="table-agile-info">
               <div class="panel panel-default">
                  <?php
                        if (isset($delete_pro)) {
                            echo $delete_pro;
                        }
                        ?>
                  <div id="notify_error_success"></div>
                  <div class="panel-heading">Quản lý sản phẩm</div>
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
                        <label>Sắp xêp theo : </label>
                        <select class="input-sm form-control w-sm inline v-middle" id="Sort_By">
                           <option value="lastest">Mới nhất</option>
                           <option value="name">Tên</option>
                           <option value="category">15</option>
                        </select>
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
                  <ul class="pagination staff_details_Pagination ">

               </div>
            </div>
         </section>

         <?php Path::path_file_include('Inc_footer') ?>

      </section>
   </section>
   <!-- css thuộc tính thông báo lỗi trên trong panel -->
   <?php echo Path::path_file_include('Inc_style_notification_panel') ?>

   <!-- Kết nối đến ckeditor -->
   <?php Path::path_file_include('Inc_ckeditor_replace') ?>

   <!-- Cập nhật trạng thái -->
   <?php Path::path_file_include('Inc_update_status_script') ?>

   <!-- Tập hợp file js -->
   <?php Path::path_file_include('Inc_script_resource') ?>

   <?php Path::path_file_include('View_product_script_list') ?>

</body>

</html>
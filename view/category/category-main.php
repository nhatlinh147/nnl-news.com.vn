<?php
Path::path_file_include('User_detail', 'Autoload', 'Middleware');
include Path::path_file_local('Global');

// lấy dữ liệu category qua slug
$get_cat = $category->get_category_by_slug(General::getParam(1));

if (!empty($get_cat)) {
   while ($result = $get_cat->fetch_assoc()) {
      $get_id = $result["Cate_Pro_ID"];
      $get_name = $result["Cate_Pro_Name"];
      $get_slug = $result["Cate_Pro_Slug"];
   }

   //khi danh muc là danh mục con
   $result_parent = $category->category_parent_by_child($get_id);
   if ($result_parent) {
      while ($result = $result_parent->fetch_assoc()) {
         $result_name = $result['Cate_Pro_Name'];
         $result_slug = $result['Cate_Pro_Slug'];
      }
   }

   $get_pro_cat = $home->productOfCateChild($get_id);
   $get_child = $category->category_child_by_parent($get_id) ?? false;
} else {
   General::view_link_location("user-error-404.html", true);
}

//Số liệu cần sử dụng cho paginate
$record_per_page = 10; // mỗi trang là bao nhiêu sản phẩm
$page = empty($_GET['trang']) ? 1 : $_GET['trang']; //Trang hiện tại
$start_from = ($page - 1) * $record_per_page; //Trang bắt đầu
$total_records = count($get_pro_cat); // Tổng dữ liệu
$total_pages = ceil($total_records / $record_per_page); // Tổng số trang

?>

<!-- START Tải tài nguyên ban đầu -->
<?php Path::path_file_include('Header_resource') ?>
<!-- END -->

<body>

   <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
   <div class="container">
      <!-- START Header top -->
      <?php Path::path_file_include('Header') ?>
      <!-- END -->

      <!-- START Navbar-nav -->
      <?php Path::path_file_include('Navbar-nav') ?>
      <!-- END -->
      <style>
      div.category_child ul {
         text-align: center;
      }

      div.category_child ul li {
         background-color: #ffa500;
         margin: 10px 0px;
         display: inline-flex;
         padding: 5px 10px;
         color: white;
      }

      div.category_child ul li:hover,
      div.category_child ul li:active {
         font-weight: bold;
         background-color: #798992;
      }

      div.category_child ul li a {
         color: white;
      }
      </style>
      <section id="mainContent">
         <div class="content_bottom">
            <div class="col-lg-8 col-md-8">
               <div class="content_bottom_left">
                  <div class="single_category wow fadeInDown">
                     <div class="archive_style_1 row">

                        <?php if (!empty($get_child)) { ?>
                        <div style="margin-top:15px;" class="category_child">
                           <ul>

                              <?php while ($result = $get_child->fetch_assoc()) { ?>
                              <li><a
                                    href="<?php echo linkCategory($result['Cate_Pro_Slug']) ?>"><?php echo $result['Cate_Pro_Name'] ?></a>
                              </li>
                              <?php } ?>

                           </ul>
                        </div>

                        <?php } else { ?>
                        <div style="margin-top:15px;">
                           <ol class="breadcrumb">
                              <li><a href="<?php echo General::view_link("trang-chu", true)  ?>">Home</a>
                              </li>
                              <?php if(!empty($result_slug)){ ?>
                              <li><a href="<?php echo linkCategory($result_slug) ?>"><?php echo $result_name ?></a>
                              </li>
                              <?php } ?>
                              <li><a href="<?php echo linkCategory($get_slug) ?>"><?php echo $get_name ?></a>
                              </li>


                           </ol>
                        </div>
                        <?php } ?>

                        <h2 style="margin-bottom: 20px;"> <span class="bold_line"><span></span></span> <span
                              class="solid_line"></span> <span class="title_text">Latest Updates</span> </h2>

                        <?php Path::path_file_include('Category_category-content') ?>

                     </div>
                  </div>
               </div>

               <?php Path::path_file_include('Category_paginate') ?>

            </div>
            <!-- START Sidebar right -->
            <?php Path::path_file_include('Sidebar_right') ?>
            <!-- END -->
         </div>
      </section>
   </div>

   <!-- START Footer -->
   <?php Path::path_file_include('Footer') ?>
   <!-- END -->

   <!-- START Tập hợp file js -->
   <?php Path::path_file_include('Script_resource') ?>
   <!-- END -->
</body>

</html>
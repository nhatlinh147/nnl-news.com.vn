<?php
Path::path_file_include('User_detail', 'Autoload');
include Path::path_file_local('Global');
$string = "aaaaaaaaaa";
print_r($string);
?>

<?php Path::path_file_include('Header_resource') ?>

<body>
   <!-- <div id="preloader">
      <div id="status">&nbsp;</div>
   </div> -->
   <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
   <div class="container">

      <!-- START Header top -->
      <?php Path::path_file_include('Header') ?>
      <!-- END -->

      <!-- START Navbar-nav -->
      <?php Path::path_file_include('Navbar-nav') ?>
      <!-- END -->

      <section id="mainContent">
         <div class="content_top">
            <div class="row">
               <div class="col-lg-6 col-md-6 col-sm6">
                  <div class="latest_slider">
                     <div class="slick_slider">

                        <?php
                        while ($result = $show_slide->fetch_assoc()) {
                           $image_name = pathinfo($result['Slide_Image'])['filename'];
                        ?>

                        <div class="single_iteam"><img src="<?php echo Path::path_file("Upload_slide_$image_name") ?>"
                              alt="">
                           <h2><a class="slider_tittle"
                                 href="#<?php echo $result['Slide_Slug'] ?>"><?php echo $result['Slide_Title'] ?></a>
                           </h2>
                           <h4><?php echo $result['Slide_Desc'] ?></h4>
                        </div>

                        <?php
                        }
                        ?>

                     </div>
                  </div>
               </div>
               <div class="col-lg-6 col-md-6 col-sm6">
                  <div class="content_top_right">
                     <ul class="featured_nav wow fadeInDown">
                        <?php
                        foreach ($product_popular as $result) {
                           $image_name = product_upload($result['Product_Image']);
                           $link = linkProductDetail($result['Product_Slug']);
                           echo '
                           <li>
                              <img src="' . $image_name . '" alt="' . $result['Product_Name'] . '">
                                 <div class="title_caption">
                                    <a href="' . $link . '">' .   General::limitContent($result['Product_Name'], 10) . '</a>
                                 </div>
                           </li>';
                        }

                        ?>

                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="content_middle">
            <div class="col-lg-3 col-md-3 col-sm-3">
               <div class="content_middle_leftbar">
                  <div class="single_category wow fadeInDown">
                     <h2> <span class="bold_line"><span></span></span> <span class="solid_line"></span> <a href="#"
                           class="title_text"><?php echo $leftbar[0]["Cate_Pro_Name"]; ?></a> </h2>

                     <ul class="catg1_nav">
                        <?php
                        foreach ($leftbar as $value_lb) {
                           $image_name = product_upload($value_lb['Product_Image']);
                           $link = linkProductDetail($value_lb['Product_Slug']);

                           echo ' <li><div class="catgimg_container"> <a href="' . $link . '" class="catg1_img"><img alt="" src="' . $image_name . '"></a></div>
                           <h3 class="post_titile"><a href="' . $link . '">' . $value_lb['Product_Name'] . '</a>
                           </h3> </li>';
                        }
                        ?>

                     </ul>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
               <div class="content_middle_middle">
                  <div class="slick_slider2">
                     <?php

                     foreach ($middle as $value_middle) {
                        $image_name = product_upload($value_middle['Product_Image']);
                        echo '
                        <div class="single_featured_slide">
                           <a href="#' . $value_middle['Product_Slug'] . '">
                              <img src="' . $image_name . '" alt="' . $value_middle['Product_Name'] . '">
                           </a>
                           <h2>
                              <a href="#' . $value_middle['Product_Slug'] . '">' . $value_middle['Product_Name'] . '</a>
                           </h2>
                           <p>' . $value_middle['Meta_Desc_Product'] . '</p>
                        </div>';
                     }
                     ?>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
               <div class="content_middle_rightbar">
                  <div class="single_category wow fadeInDown">

                     <h2> <span class="bold_line"><span></span></span> <span class="solid_line"></span> <a href="#"
                           class="title_text"><?php echo $rightbar[0]["Cate_Pro_Name"]; ?></a> </h2>
                     <ul class="catg1_nav">
                        <?php
                        foreach ($rightbar as $value_rb) {
                           $image_name = product_upload($value_rb['Product_Image']);
                           $link = linkProductDetail($value_rb['Product_Slug']);
                           echo '
                           <li>
                              <div class="catgimg_container">
                                 <a href="' .  $link . '" class="catg1_img">
                                    <img alt="" src="' . $image_name . '">
                                 </a>
                              </div>
                              <h3 class="post_titile"><a href="' .  $link . '">' . $value_rb['Product_Name'] . '</a></h3>
                           </li>';
                        }
                        ?>

                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="content_bottom">
            <div class="col-lg-8 col-md-8">
               <div class="content_bottom_left">
                  <div class="single_category wow fadeInDown">
                     <h2> <span class="bold_line"><span></span></span> <span class="solid_line"></span><a
                           class="title_text" href="#"><?php echo $singleCategoryOne[0]["Cate_Pro_Name"] ?></a> </h2>
                     <div class="business_category_left wow fadeInDown">
                        <ul class="fashion_catgnav">
                           <li>

                              <?php
                              $product = array_shift($singleCategoryOne);
                              $image_name = product_upload($product['Product_Image']);
                              $link = linkProductDetail($product['Product_Slug']);
                              ?>

                              <div class="catgimg2_container"> <a href="<?php echo $link ?>"><img
                                       alt="<?php echo $product["Product_Name"] ?>" src="<?php echo $image_name ?>"></a>
                              </div>
                              <h2 class="catg_titile"><a
                                    href="<?php echo $link ?>"><?php echo $product["Product_Name"] ?></a>
                              </h2>
                              <div class="comments_box"> <span
                                    class="meta_date"><?php echo product_date($product['created_at']); ?></span> <span
                                    class="meta_comment"><a href="#">No Comments</a></span> <span class="meta_more"><a
                                       href="#">Read More...</a></span> </div>
                              <p><?php echo General::limitContent($product["Meta_Desc_Product"], 20)  ?></p>

                           </li>
                        </ul>
                     </div>
                     <div class="business_category_right wow fadeInDown">
                        <ul class="small_catg">

                           <?php
                           foreach ($singleCategoryOne as $product) {
                              $image_name = product_upload($product['Product_Image']);
                              $link = linkProductDetail($product['Product_Slug']);
                           ?>
                           <li>
                              <div class="media wow fadeInDown"> <a class="media-left" href="<?php echo $link ?>"><img
                                       src="<?php echo $image_name; ?>" alt=""></a>
                                 <div class="media-body">
                                    <h4 class="media-heading"><a
                                          href="<?php echo $link ?>"><?php echo $product['Product_Name'] ?>
                                       </a></h4>
                                    <div class="comments_box"> <span
                                          class="meta_date"><?php echo product_date($product['created_at']) ?></span>
                                       <span class="meta_comment"><a href="#">No Comments</a></span>
                                    </div>
                                 </div>
                              </div>
                           </li>
                           <?php
                           }
                           ?>

                        </ul>
                     </div>
                  </div>

                  <div class="games_fashion_area row">
                     <?php
                     $check = 0;
                     foreach ($singleCategory as $category) {
                        $check++;
                        $category_value = json_decode(json_encode($category->data), true);
                        $product = array_shift($category_value);
                        $image_name = product_upload($product['Product_Image']);
                        $link = linkProductDetail($product['Product_Slug']);
                     ?>
                     <div class="col-md-6" style="<?php echo $check % 2 != 0 ? 'float:none;' : '' ?> padding-right:0px">
                        <!-- <div class="col-md-6" style="<?php echo $check % 2 != 0 ? 'float:none;' : '' ?>"> -->
                        <div class="single_category">
                           <h2> <span class="bold_line"><span></span></span> <span class="solid_line"></span>
                              <a class="title_text" href="#"><?php echo $product['Cate_Pro_Name']  ?></a>
                           </h2>
                           <ul class="fashion_catgnav wow fadeInDown">
                              <li>
                                 <div class="catgimg2_container"> <a href="<?php echo $link  ?>"><img alt=""
                                          src="<?php echo $image_name ?>"></a> </div>
                                 <h2 class="catg_titile"><a
                                       href="<?php echo $link  ?>"><?php echo $product['Product_Name']  ?></a>
                                 </h2>
                                 <div class="comments_box"> <span
                                       class="meta_date"><?php echo $product['created_at']  ?></span> <span
                                       class="meta_comment"><a href="#">No Comments</a></span> <span
                                       class="meta_more"><a href="#">Read More...</a></span> </div>
                                 <p><?php echo General::limitContent($product['Meta_Desc_Product'], 20)  ?></p>
                              </li>
                           </ul>
                           <ul class="small_catg wow fadeInDown">
                              <?php
                                 foreach ($category_value as $product) {
                                    $image_name = product_upload($product['Product_Image']);
                                    $link = linkProductDetail($product['Product_Slug']);
                                 ?>

                              <li>
                                 <div class="media"> <a class="media-left" href="<?php $link ?>"><img
                                          src="<?php echo $image_name; ?>" alt=""></a>
                                    <div class="media-body">
                                       <h4 class="media-heading"><a
                                             href="<?php echo $link ?>"><?php echo $product['Product_Name'] ?>
                                          </a></h4>
                                       <div class="comments_box"> <span
                                             class="meta_date"><?php echo product_date($product['created_at']) ?></span>
                                          <span class="meta_comment"><a href="#">No Comments</a></span>
                                       </div>
                                    </div>
                                 </div>
                              </li>
                              <?php
                                 }
                                 ?>

                           </ul>
                        </div>
                     </div>
                     <?php } ?>
                  </div>

                  <div class="technology_catrarea">
                     <?php
                     $product = array_shift($singleCategoryTwo);
                     $image_name = product_upload($product['Product_Image']);
                     $link = linkProductDetail($product['Product_Slug']);
                     ?>
                     <div class="single_category">
                        <h2> <span class="bold_line"><span></span></span> <span class="solid_line"></span> <a
                              class="title_text" href="#"><?php echo $product['Cate_Pro_Name'] ?></a> </h2>
                        <div class="business_category_left">
                           <ul class="fashion_catgnav wow fadeInDown">

                              <li>
                                 <div class="catgimg2_container"> <a href="<?php echo $link ?>"><img
                                          alt="<?php echo $product["Product_Name"] ?>"
                                          src="<?php echo $image_name ?>"></a>
                                 </div>
                                 <h2 class="catg_titile"><a
                                       href="<?php echo $link  ?>"><?php echo $product["Product_Name"] ?></a>
                                 </h2>
                                 <div class="comments_box"> <span
                                       class="meta_date"><?php echo product_date($product['created_at']); ?></span>
                                    <span class="meta_comment"><a href="#">No Comments</a></span> <span
                                       class="meta_more"><a href="#">Read More...</a></span>
                                 </div>
                                 <p><?php echo General::limitContent($product["Meta_Desc_Product"], 20)  ?></p>

                              </li>

                           </ul>
                        </div>
                        <div class="business_category_right">
                           <ul class="small_catg wow fadeInDown">
                              <?php
                              foreach ($singleCategoryTwo as $product) {
                                 $image_name = product_upload($product['Product_Image']);
                                 $link = linkProductDetail($product['Product_Slug']);
                              ?>
                              <li>
                                 <div class="media wow fadeInDown"> <a class="media-left"
                                       href="<?php echo $link ?>"><img src="<?php echo $image_name; ?>" alt=""></a>
                                    <div class="media-body">
                                       <h4 class="media-heading"><a
                                             href="<?php echo $link ?>"><?php echo $product['Product_Name'] ?>
                                          </a></h4>
                                       <div class="comments_box"> <span
                                             class="meta_date"><?php echo product_date($product['created_at']) ?></span>
                                          <span class="meta_comment"><a href="#">No Comments</a></span>
                                       </div>
                                    </div>
                                 </div>
                              </li>

                              <?php
                              }
                              ?>

                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <!-- START Sidebar right -->
            <?php Path::path_file_include('Sidebar_right') ?>
            <!-- END -->

         </div>
      </section>
   </div>
   <?php Path::path_file_include('Footer') ?>

   <?php Path::path_file_include('Script_resource') ?>

</body>

</html>
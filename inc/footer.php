<footer id="footer">
   <div class="footer_top">
      <div class="container">
         <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
               <div class="single_footer_top wow fadeInLeft">
                  <h2>Hình ảnh về shop</h2>
                  <ul class="flicker_nav">
                     <?php
                     global $footer_info;
                     $result = $footer_info->fetch_assoc();
                     $get_image = $result['Info_Image'];
                     $get_image = empty($get_image) ? [] : json_decode($get_image);
                     foreach ($get_image as $image) {
                        echo '<li><a href="' . $image . '"><img src="' . $image . '" alt=""></a></li>';
                     }

                     ?>
                  </ul>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
               <div class="single_footer_top wow fadeInDown">
                  <h2>Labels</h2>
                  <ul class="labels_nav">
                     <?php
                     global $category_parent;

                     foreach ($category_parent as $value) {
                        echo '<li><a href="' . linkCategory($value['Cate_Pro_Slug']) . '">' . $value['Cate_Pro_Name'] . '</a></li>';
                     }

                     ?>

                  </ul>
               </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
               <div class="single_footer_top wow fadeInRight">
                  <h2>About Us</h2>
                  <p><?php echo $result["Info_About_Us"] ?></p>
               </div>

               <div class="single_footer_top wow fadeInRight" style="margin-bottom: 20px;">
                  <h2>Thông tin liên hệ</h2>
                  <ul style="margin: 0px 5px 20px;color: white;font-style: italic;">
                     <li>
                        <span>Tên shop : <?php echo $result["Info_Shopname"] ?></span>
                     </li>
                     <li>
                        <span>Tên chủ sở hữu : <?php echo $result["Info_Author"] ?></span>
                     </li>
                     <li>
                        <span>Địa chỉ : <?php echo $result["Info_Address"] ?></span>
                     </li>
                  </ul>
                  <?php $get_social = empty($result['Info_Social']) ? [] : json_decode($result['Info_Social']);
                  foreach ($get_social as $social) {
                     if (trim($social->value) != "")
                        echo '
                     <a href="' . $social->value . '" style="margin : 10px" target="_blank">
                        <span class="fa fa-' . $social->key . ' fa-2x"></span>
                     </a>';
                  }
                  ?>

               </div>
            </div>
         </div>
      </div>
      <div class="footer_bottom">
         <div class="container">
            <div class="row">
               <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="footer_bottom_left">
                     <p>Copyright &copy; 2045 <a href="index.html">magExpress</a></p>
                  </div>
               </div>
               <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="footer_bottom_right">
                     <p>Developed BY Wpfreeware</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
</footer>
<header id="header">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="header_top">
            <div class="header_top_left">
               <ul class="top_nav">
                  <li><a href="<?php echo General::view_link("trang-chu.html", true) ?>">Home</a></li>
                  <li><a href="<?php echo General::view_link("gioi-thieu.html", true) ?>">About</a></li>
                  <li><a href="<?php echo General::view_link("dang-nhap.html", true) ?>">Sign In</a></li>
                  <li><a href="<?php echo General::view_link("lien-he.html", true) ?>">Contact</a></li>
               </ul>
            </div>
            <div class="header_top_right">
               <form action="#" class="search_form">
                  <input type="text" placeholder="Text to Search" id="Search_Product" autocomplete="off">
                  <input type="submit" value="">
               </form>
            </div>
         </div>
         <div class="header_bottom">
            <div class="header_bottom_left"><a class="logo" href="<?php echo General::view_link("trang-chu", true) ?>">NNL<strong>News</strong>
                  <span>A
                     Pro Magazine Template</span></a></div>
            <?php global $show_banner;
            $show_banner = $show_banner->fetch_assoc();
            $image_name = pathinfo($show_banner["Banner_Image"])['filename'];
            $image_name = Path::path_file("Upload_banner_$image_name");

            echo ' <div class="header_bottom_right"><a href="#' . $show_banner["Banner_Slug"] . '"><img src="' . $image_name . '" alt="' . $show_banner['Banner_Title'] . '"></a></div>';
            ?>

         </div>
      </div>
   </div>
</header>
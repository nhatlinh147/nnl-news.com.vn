<div id="navarea">
   <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
               aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span
                  class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
         </div>
         <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav custom_nav">
               <li class=""><a href="<?php echo General::view_link("trang-chu", true) ?>">Home</a></li>

               <?php
               //Hiển thị dữ liệu danh mục cha
               global $category_parent, $show_category, $category, $result_slug;
               foreach ($category_parent as $result) {
                  $result_slug = $result_slug ?? false;
                  $active = $result["Cate_Pro_Slug"] == General::getParam(1) ||  $result["Cate_Pro_Slug"] == $result_slug ? "active" : "";
               ?>

               <li class="dropdown <?php echo $active ?>">
                  <a href="<?php echo linkCategory($result["Cate_Pro_Slug"]) ?>" class="" data-toggle="dropdown"
                     role="button" aria-expanded="false"><?php echo $result['Cate_Pro_Name'] ?></a>
                  <?php
                     //Điều kiện để xác định category nào có danh mục con
                     if ($category->category_child_by_parent($result['Cate_Pro_ID'])) {
                     ?>
                  <ul class="dropdown-menu" role="menu">
                     <?php
                           foreach ($show_category as $key => $result_child) {
                              //Điều kiện để xác định chính xác các danh mục con
                              if ($result['Cate_Pro_ID'] == $result_child['Cate_Pro_Parent']) {
                                 echo '<li><a href="' . linkCategory($result_child["Cate_Pro_Slug"]) . '">' . $result_child["Cate_Pro_Name"] . '</a></li>';
                              }
                           }
                           ?>
                  </ul>

                  <?php
                     }
                     ?>
               </li>

               <?php
               }
               ?>
            </ul>
         </div>
      </div>
   </nav>
</div>
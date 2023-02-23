<?php
//code php phải sau Inc_header_resource để có thể khởi tạo được object
Path::path_file_include('Slider', 'Resize_image');
$slider = new slider();
$tit_slide = $slider->slideTitleAdmin();
$title = $tit_slide["title_edit"];
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
      if (!General::getParam(1)) {
         echo "<script>window.location ='slider_list.php'</script>";
      } else {

         $id = General::getParam(1);

         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST['slide_id'] = $id;
            $updateSlider = $slider->update_slider($_POST, $_FILES);
         }
      }
      echo $id;
      ?>
      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
            <div class="form-w3layouts">

               <!-- page start-->
               <!-- page start-->
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Sửa slide
                        </header>
                        <div class="panel-body">
                           <div class="position-center">
                              <?php
                              if (isset($updateSlider)) {
                                 echo $updateSlider;
                              }
                              ?>
                              <?php
                              $get_slide_title = $slider->getsliderbyId($id);
                              if ($get_slide_title) {
                                 while ($result = $get_slide_title->fetch_assoc()) {
                                    //lấy tên filename để có thể lấy được đường dẫn chèn vào src
                                    $image_name = pathinfo($result['Slide_Image'])['filename'];
                              ?>
                                    <form action="" method="post" enctype="multipart/form-data">
                                       <div class="form-group">
                                          <label for="exampleInputEmail1">Tên slide: </label>
                                          <input type="text" name="slide_title" class="form-control" onkeyup="ChangeToSlug()" id="slug" placeholder="Tiêu đề slide" value="<?php echo $result['Slide_Title'] ?>">
                                       </div>
                                       <div class="form-group">
                                          <label for="exampleInputEmail1">Slug slide: </label>
                                          <input type="text" name="slide_slug" class="form-control" id="convert_slug" placeholder="Slug slide" value="<?php echo $result['Slide_Slug'] ?>">
                                       </div>
                                       <div class="form-group">
                                          <label for="exampleInputEmail1">Hình ảnh slide: </label>

                                          <input type="file" name="slide_image" class="form-control slide_image" id="IMAGE" placeholder="Hình ảnh slide" value="<?php echo $result['Slide_Image']; ?>">

                                          <div id="view_image" style="margin-top:8px ;">
                                             <p style="font-style: italic; font-weight: bold;font-size: 10pt;">Hình ảnh slide
                                                hiện tại: </p>
                                             <img src="<?php echo Path::path_file("Upload_slide_$image_name") ?>" width="200">
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label for="exampleInputPassword1">Mô tả slide</label>
                                          <textarea style="resize: none" rows="3" class="form-control" name="slide_desc" id="slide_desc"><?php echo $result['Slide_Desc'] ?></textarea>
                                       </div>

                                       <button type="submit" class="btn btn-info">Cập nhật slide</button>
                                    </form>
                              <?php
                                 }
                              }
                              ?>
                           </div>

                        </div>
                     </section>

                  </div>
               </div>
               <!-- page end-->
               <!-- page end-->

            </div>
         </section>

         <?php Path::path_file_include('Inc_footer') ?>

      </section>
   </section>
   <!-- Kết nối đến script slug -->
   <?php Path::path_file_include('Inc_transfer_slug') ?>

   <!-- css thuộc tính thông báo lỗi trên trong panel -->
   <?php echo Path::path_file_include('Inc_style_notification_panel') ?>

   <!-- Script xem ảnh tạm thời  -->
   <script>
      $(document).ready(function() {
         $('.slide_image').on('change', function() {
            var file = $(this)[0].files[0];
            if (file.type.includes('image')) {
               var fileReader = new FileReader();
               fileReader.onload = function() {
                  var str = '<img class="img-thumbnail js-file-image" style="width: 100px; height: 100px">';
                  $('#view_image').html(str);

                  var imageSrc = event.target.result;

                  $('.js-file-image').attr('src', imageSrc);
               };
               fileReader.readAsDataURL(file);
            } else {
               $('#view_image').html(
                  '<div style="color:red;font-size:11pt; margin-left: 6px"><span style="font-weight:bold">Lỗi: </span><i>File nhập vào phải là hình ảnh. Xin hãy nhập lại</i></div>'
               );
            }
         });
      });
   </script>

   <!-- Tập hợp file js -->
   <?php Path::path_file_include('Inc_script_resource') ?>

</body>

</html>
<?php Path::path_file_include('Header_resource') ?>

<body>

   <div class="log-w3">
      <div class="w3layouts-main">
         <h2 class="text-success">Xác nhận email</h2>
         <p>Shop đã gửi mail xác nhận đến địa chỉ email của bạn. Xin hãy vào hộp thư của bạn để xác nhận</p>
         <div style="margin-top: 1rem;">
            <a href="<?php echo General::view_link('dang-nhap', true) ?>" class="btn btn-primary btn-lg"><i
                  class="fa fa fa-arrow-left"></i> Quay lại</a>
         </div>
      </div>
   </div>

   <!-- Tập hợp file js -->
   <?php Path::path_file_include('Script_resource') ?>

</body>

</html>
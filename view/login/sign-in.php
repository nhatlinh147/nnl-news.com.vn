<?php
Session::checkLoginCustomer();

Path::path_file_include('User_detail', 'Autoload', 'User_signIn');
include Path::path_file_local('Global');

$login = new SignIn();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $customerEmail = $_POST['customer_email'];
   $customerPassword = md5($_POST['customer_password']);
   $check_login = $login->login_admin($customerEmail, $customerPassword);
}

?>
<!-- START Tải tài nguyên ban đầu -->
<?php Path::path_file_include('Header_resource') ?>
<!-- END -->

<body>
   <!-- <div id="preloader">
    <div id="status">&nbsp;</div>
  </div> -->
   <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
   <div class="container">
      <section id="ContactContent">
         <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
               <div class="contact_area">
                  <h1>Đăng nhập</h1>

                  <!-- START login form -->
                  <div class="omb_login">
                     <h3 class="omb_authTitle">Login or <a href="#">Sign up</a></h3>
                     <div class="row omb_row-sm-offset-3 omb_socialButtons">
                        <div class="col-xs-4 col-sm-2">
                           <a href="#" class="btn btn-lg btn-block omb_btn-facebook">
                              <i class="fa fa-facebook visible-xs"></i>
                              <span class="hidden-xs">Facebook</span>
                           </a>
                        </div>
                        <div class="col-xs-4 col-sm-2">
                           <a href="#" class="btn btn-lg btn-block omb_btn-twitter">
                              <i class="fa fa-twitter visible-xs"></i>
                              <span class="hidden-xs">Twitter</span>
                           </a>
                        </div>
                        <div class="col-xs-4 col-sm-2">
                           <a href="#" class="btn btn-lg btn-block omb_btn-google">
                              <i class="fa fa-google-plus visible-xs"></i>
                              <span class="hidden-xs">Google+</span>
                           </a>
                        </div>
                     </div>

                     <div class="row omb_row-sm-offset-3 omb_loginOr">
                        <div class="col-xs-12 col-sm-6">
                           <hr class="omb_hrOr">
                           <span class="omb_spanOr">or</span>
                        </div>
                     </div>

                     <div class="row omb_row-sm-offset-3">
                        <div class="col-xs-12 col-sm-6">
                           <div class="notify-error">
                              <?php
                              if (isset($check_login)) {
                                 echo $check_login;
                              }
                              ?>
                           </div>
                           <form class="omb_loginForm" action="<?php echo General::view_link('dang-nhap.html', true); ?>" autocomplete="off" method="POST">
                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                 <input type="text" class="form-control" name="customer_email" placeholder="Nhập email">
                              </div>
                              <span class="help-block"></span>

                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                 <input type="password" class="form-control" name="customer_password" placeholder="Nhập mật khẩu">
                              </div>
                              <span class="help-block">Password error</span>

                              <button class="btn btn-lg btn-basic btn-block" type="submit">Login</button>
                           </form>
                        </div>
                     </div>
                     <div class="row omb_row-sm-offset-3">
                        <div class="col-xs-12 col-sm-3">
                           <label class="checkbox">
                              <input type="checkbox" value="remember-me">Remember Me
                           </label>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                           <p class="omb_forgotPwd">
                              <a href="#">Forgot password?</a>
                           </p>
                        </div>
                     </div>
                  </div>
                  <!-- END -->

      </section>
   </div>

   <?php Path::path_file_include('Footer') ?>
   <?php Path::path_file_include('Script_resource') ?>

   <script src="<?php echo Path::path_file("Assets_js_jquery.validate") ?>"></script>
   <?php Path::path_file_include('Ckeditor_replace') ?>

   <script>
      General.insert_head("<?php echo Path::path_file('Assets_css_style -custom') ?>", 1);

      function CKupdate() {
         for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
            CKEDITOR.instances[instance].setData('');
         }
      }
      $("form.contact_form").validate({
         ignore: [],
         rules: {
            contact_name: {
               required: true,
               minlength: 6
            },
            contact_email: {
               required: true,
               email: true,
            },
            contact_subject: {
               required: true
            },
            contact_message: {
               required: function(textarea) {
                  CKEDITOR.instances[textarea.id].updateElement();
                  var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                  return editorcontent.length === 0;
               }
            },
         },
         messages: {
            contact_name: {
               required: "Tên người liên hệ không được để trống",
               minlength: 6
            },
            contact_email: {
               required: "Email người liên hệ không được để trống",
               email: "Email không được để trống",
            },
            contact_subject: {
               required: "Tiêu đề mail không được để trống",
            },
            contact_message: {
               required: "Nội dung mail không được để trống",
            },
         },
         errorPlacement: function(error, element) {
            // if (element.is(":radio"))
            //    error.insertAfter(element.parent("label").next());
            // else if (element.is(":checkbox"))
            //    error.insertAfter(element.next());
            // else
            error.insertBefore(element);
         },
         submitHandler: function(form) {
            let url_link =
               "<?php echo Content::put_content('User_contact', 'Contact', 'exeContact', 'gui-tin-lien-he.php', 'query') ?>";
            let data = new FormData($("form.contact_form")[0]);
            var get_content = $("div.contact_us").html();
            $.ajax({
               data: data,
               url: url_link,
               type: "POST",
               dataType: 'json',
               processData: false,
               contentType: false,
               beforeSend: function() {
                  //Tiến hành ẩn đi form và hiện nội dung thông báo
                  $('div.contact_us').hide();
                  $('div.hide_content').show();
                  $('div.hide_content').html(
                     `<h4 class="wow fadeInRightBig" style="font-style: italic;"> Đang tiến hành gửi mail ... </h4>`
                  );
               },
               success: function(data) {
                  if (!data) {
                     $('div.hide_content').html(
                        `<h1 class="wow fadeInRightBig" style="color:red;font-weight: bold;"> Gửi mail thất bại</h1>
                     <button class="btn btn-lg btn-danger" id="Submit_Button">Quay Lại</button>`
                     );
                  } else {
                     $('div.hide_content').html(
                        `<h1 class="wow fadeInRightBig" style="color:green;font-weight: bold;"> Gửi mail thành công</h1>
                     <button class="btn btn-lg btn-success" id="Submit_Button">Quay Lại</button>`
                     );
                  }

                  //Bắt sự kiện click button quay lại khi đăng ký thất bại hoặc thành công
                  $(document).on('click', 'button#Submit_Button', function() {
                     $('form.contact_form').trigger("reset");
                     CKupdate();
                     //Tiến hành hiện form và xóa đi nội dung thông báo
                     $('div.hide_content').empty();
                     $('div.contact_us').show();
                  })

               }, // END success
               error: function(data) {
                  console.log('Error:', data);
               } // END error
            }); // END ajax
         }
      })
   </script>

</body>

</html>
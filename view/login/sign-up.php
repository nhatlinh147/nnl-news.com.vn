<?php
Session::checkLoginCustomer();

Path::path_file_include('User_detail', 'Autoload', 'User_signIn', 'User_signUp');
include Path::path_file_local('Global');

$class = new SignUp();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $carbon = new Carbon\Carbon;
   $_POST['customer_date'] = $carbon->now('Asia/Ho_Chi_Minh');
   $_POST['customer_login'] = "nnl-news";
   $check_login = $class->sign_up($_POST);
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
                     <h3 class="omb_authTitle">Nếu bạn đã có tài khoản thì xin hãy <a href="<?php echo General::view_link("dang-nhap.html", true) ?>">đăng
                           nhập</a></h3>

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
                           <form class="omb_loginForm" action="" autocomplete="off" method="POST">

                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                 <input type="text" class="form-control" name="customer_user" placeholder="Nhập tên tài khoản">
                              </div>

                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-mail-forward"></i></span>
                                 <input type="text" class="form-control" name="customer_email" placeholder="Nhập email">
                              </div>

                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                 <input type="text" class="form-control" name="customer_address" placeholder="Nhập địa chỉ">
                              </div>

                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                 <input type="text" class="form-control" name="customer_phone" placeholder="Nhập số điện thoại">
                              </div>

                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                 <input type="password" class="form-control" name="customer_password" id="customer_password" placeholder="Nhập mật khẩu">
                              </div>

                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                 <input type="password" class="form-control" name="customer_confirm_password" placeholder="Nhập lại mật khẩu">
                              </div>

                              <div class="input-group">
                                 <input type="checkbox" value="remember-me" name="agree_policy"> Chính sách bảo mật
                              </div>

                              <button class="btn btn-lg btn-basic btn-block" type="submit">Đăng ký</button>
                           </form>
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
      General.insert_head("<?php echo Path::path_file('Assets_css_style-custom') ?>", 1);

      $.validator.addMethod("regex", function(value, element, regexp) {
         var re = new RegExp(regexp);
         return this.optional(element) || re.test(value);
      }, "Please check your input.");


      $("form.omb_loginForm").validate({
         ignore: [],
         rules: {
            customer_user: {
               required: true,
               regex: '^[A-Za-z]{1}[A-Za-z0-9]{5,31}$',
            },
            customer_email: {
               required: true,
               email: true,
            },
            customer_phone: {
               required: true,
               regex: "^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$"
            },
            customer_address: {
               required: true
            },
            customer_password: {
               required: true,
               regex: "^(((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])))(?=.{6,})",
            },
            customer_confirm_password: {
               required: true,
               equalTo: "#customer_password"
            },
            agree_policy: {
               required: true,
            }
         },
         messages: {
            customer_user: {
               required: "Tên tài khoản không được để trống",
               regex: "Tên tài khoản gồm chữ cái trong alphabet, chữ số. Đồng thời nhiều hơn 7 ký tự",
            },
            customer_email: {
               required: "Email không được để trống",
               email: "Email không hợp lệ"
            },
            customer_phone: {
               required: "Số điện thoại không được để trống",
               regex: "Số điện thoại phải bắt đầu bằng 0, có đủ 11 số"
            },
            customer_address: {
               required: "Địa chỉ không được để trống",
            },
            customer_password: {
               required: "Mật khẩu không được để trống",
               regex: "Mức độ mật khẩu chưa tốt"
            },
            customer_confirm_password: {
               required: "Xác nhận mật khẩu không được để trống",
               equalTo: "Xác nhận mật khẩu không khớp"
            },
            agree_policy: {
               required: "Bạn phải đồng ý với chính sách bảo mật thì mới có thể đăng ký",
            },
         },
         errorPlacement: function(error, element) {
            error.insertBefore(element.parent("div.input-group").next());
         },
      })
   </script>

</body>

</html>
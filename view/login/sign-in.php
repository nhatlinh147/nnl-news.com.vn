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
                     <h3 class="omb_authTitle">Đăng nhập hoặc
                        <a href="<?php echo General::view_link("dang-ky.html", true) ?>">Đăng ký</a> hoặc
                        <a href="<?php echo General::view_link("trang-chu.html", true) ?>">Trang chủ</a>
                     </h3>

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
                           <form class="omb_loginForm"
                              action="<?php echo General::view_link('dang-nhap.html', true); ?>" autocomplete="off"
                              method="POST">
                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                 <input type="text" class="form-control" name="customer_email" placeholder="Nhập email">
                              </div>

                              <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                 <input type="password" class="form-control" name="customer_password"
                                    placeholder="Nhập mật khẩu">
                              </div>

                              <button class="btn btn-lg btn-basic btn-block" type="submit"
                                 style="margin: 10px 0px">Login</button>
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

   <script>
   General.insert_head("<?php echo Path::path_file('Assets_css_style-custom') ?>", 1);

   $.validator.addMethod("regex", function(value, element, regexp) {
      var re = new RegExp(regexp);
      return this.optional(element) || re.test(value);
   }, "Please check your input.");

   $("form.omb_loginForm").validate({
      ignore: [],
      rules: {
         customer_email: {
            required: true,
            email: true,
         },
         // customer_password: {
         //    required: true,
         //    regex: "^(((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])))(?=.{6,})",
         // }
      },
      messages: {
         customer_email: {
            required: "Email không được để trống",
            email: "Email không hợp lệ"
         },
         // customer_password: {
         //    required: "Mật khẩu không được để trống",
         //    regex: "Mức độ mật khẩu chưa tốt"
         // }
      },
      errorPlacement: function(error, element) {
         error.insertBefore(element.parent("div.input-group").next());
      },
   })
   </script>

</body>

</html>
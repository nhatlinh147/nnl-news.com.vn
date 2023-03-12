<?php

Path::path_file_include('AdminSignUp', 'AdminSignIn');
Session::checkLogin();
$no_session = true;
$class = new AdminSignUp();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $check_login = $class->sign_up($_POST, $_FILES);
}
?>

<?php Path::path_file_include('Inc_header_resource') ?>

<body>
   <div class="reg-w3">
      <div class="w3layouts-main">
         <h2>Đăng ký tài khoản</h2>

         <div class="notify-error">
            <?php
            if (isset($check_login)) {
               echo $check_login;
            }
            ?>

         </div>

         <form action="<?php echo General::view_link('dang-ky.html'); ?>" method="post" id="Form_Registy">
            <input type="text" class="ggg account_fullname" id="account_fullname" name="account_fullname" placeholder="Nhập Họ và Tên">

            <input type="text" class="ggg account_user" id="account_user" name="account_user" placeholder="Nhập Tên tài Khoản" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">

            <input type="email" class="ggg account_email" id="account_email" name="account_email" placeholder="Nhập Email">
            <input type="text" class="ggg account_phone" id="account_phone" name="account_phone" placeholder="Nhập Số Điện Thoại">
            <input type="text" class="ggg account_address" id="account_address" name="account_address" placeholder="Nhập Địa Chỉ">
            <input type="password" class="ggg account_password" id="account_password" name="account_password" placeholder="Nhập Mật Khẩu">
            <input type="password" class="ggg account_confirm_password" id="account_confirm_password" name="account_confirm_password" placeholder="Xác Nhận Mật Khẩu">

            <h4 style="margin-top: 1rem;"><input type="checkbox" name="agree_policy" class="agree_policy" />Tôi đồng ý
               chính sách và điều khoản của công ty</h4>
            <div class="clearfix"></div>
            <input type="submit" value="submit" name="register">
         </form>
         <p>Nếu bạn đã có tài khoản . Xin hãy<a href="<?php echo General::view_link('dang-nhap.html'); ?>">đăng nhập</a>
         </p>
      </div>
   </div>

   <!--------------------------------------- START Script --------------------------------------->
   <!-- Jquery -->
   <script src="<?php echo Path::path_file('Js_jquery2.0.3.min') ?>"></script>
   <script src="<?php echo Path::path_file('Js_jquery.validate') ?>"></script>

   <script src="<?php echo Path::path_file('Js_bootstrap') ?>"></script>
   <script src="<?php echo Path::path_file('Js_jquery.dcjqaccordion.2.7') ?>"></script>
   <script src="<?php echo Path::path_file('Js_scripts') ?>"></script>
   <script src="<?php echo Path::path_file('Js_jquery.slimscroll') ?>"></script>
   <script src="<?php echo Path::path_file('Js_jquery.nicescroll') ?>"></script>
   <script src="<?php echo Path::path_file('Js_jquery.scrollTo') ?>"></script>

   <!--------------------------------------- END Script --------------------------------------->

   <!--------------------------------------- START Script Customerize --------------------------------------->
   <script>
      $.validator.addMethod("regex", function(value, element, regexp) {
         var re = new RegExp(regexp);
         return this.optional(element) || re.test(value);
      }, "Please check your input.");
   </script>
   <!-- <script>
        $.ajax({
            url: 'http://localhost/Projec%20PHP%20thu%E1%BA%A7n/Admin/kiem-tra-ton-tai.html',
            type: 'POST',
            data: {
                type: "login",
                var_name: "account_user"
            },
            success: function(response) {
                console.log(response);
            }
        });
    </script> -->
   <script type="text/javascript">
      $("#Form_Registy").validate({
         ignore: [],
         rules: {
            account_fullname: {
               required: true,
               minlength: 6
            },
            account_user: {
               required: true,
               minlength: 4,
               regex: '^[A-Za-z]{1}[A-Za-z0-9]{5,31}$',
               remote: {
                  type: "post",
                  url: "<?php echo General::view_link("kiem-tra-ton-tai.html"); ?>",
                  data: {
                     type: "login",
                     var_name: "account_user"
                  }
               }
            },
            account_email: {
               required: true,
               email: true,
               remote: {
                  type: "post",
                  url: "<?php echo General::view_link("kiem-tra-ton-tai.html"); ?>",
                  data: {
                     type: "login",
                     var_name: "account_email"
                  }
               }
            },
            account_phone: {
               required: true,
               regex: "^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$"
            },
            account_address: {
               required: true
            },
            account_password: {
               required: true,
               regex: "^(((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])))(?=.{6,})",
            },
            account_confirm_password: {
               required: true,
               equalTo: "#account_password"
            },
            agree_policy: {
               required: true,
            }
         },
         messages: {
            account_fullname: {
               required: "Họ và tên không được để trống",
               minlength: "Họ và tên cần ít nhất 6 ký tự"
            },
            account_user: {
               required: "Tên tài khoản không được để trống",
               regex: "Tên tài khoản gồm chữ cái trong alphabet, chữ số. Đồng thời nhiều hơn 7 ký tự",
               remote: "Tên tài khoản đã tồn tại. Xin nhập lại"
            },
            account_email: {
               required: "Email không được để trống",
               email: "Email không hợp lệ",
               remote: "Email đã tồn tại. Xin nhập lại"
            },
            account_phone: {
               required: "Số điện thoại không được để trống",
               regex: "Số điện thoại phải bắt đầu bằng 0, có đủ 11 số"
            },
            account_address: {
               required: "Địa chỉ không được để trống",
            },
            account_password: {
               required: "Mật khẩu không được để trống",
               regex: "Mức độ mật khẩu chưa tốt"
            },
            account_confirm_password: {
               required: "Xác nhận mật khẩu không được để trống",
               equalTo: "Xác nhận mật khẩu không khớp"
            },
            agree_policy: {
               required: "Bạn phải đồng ý với chính sách bảo mật thì mới có thể đăng ký",
            },
         },
         errorPlacement: function(error, element) {
            if (element.is(":checkbox")) {
               error.insertAfter(element.parent("h4").next());
            } else {
               error.insertAfter(element);
            }
         }
      })
   </script>
   <!--------------------------------------- END Script Customerize --------------------------------------->


</body>

</html>
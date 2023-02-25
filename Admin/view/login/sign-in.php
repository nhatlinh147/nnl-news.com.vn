<?php
// đường dẫn đến file
Session::checkLogin();
$no_session = true;

Path::path_file_include('AdminSignIn');
$login = new AdminSignIn();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $accountEmail = $_POST['account_email'];
   $accountPassword = md5($_POST['account_password']);
   $check_login = $login->login_admin($accountEmail, $accountPassword);
}

?>
<?php Path::path_file_include('Inc_header_resource') ?>

<body>
   <div class="log-w3">
      <div class="w3layouts-main">
         <h2>Đăng nhập</h2>
         <div class="notify-error">
            <?php
            if (isset($check_login)) {
               echo $check_login;
            }
            ?>

         </div>

         <pre><?php
               Path::path_file_include('Autoload');
               $base_name = "D:/xampp/htdocs/Projec PHP thuần/";
               $dotenv = Dotenv\Dotenv::createImmutable(pathinfo(Path::path_file_local(""))["dirname"]);
               $dotenv->load();

               print_r($_ENV['AUTHOR']);

               ?></pre>

         <form action="<?php echo General::view_link('dang-nhap.html'); ?>" method="post">
<<<<<<< HEAD
            <input type="email" class="ggg account_email" name="account_email" id="account_email" placeholder="E-MAIL"
               value="">
=======
            <input type="email" class="ggg account_email" name="account_email" id="account_email" placeholder="E-MAIL" value="">
>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95
            <input type="password" class="ggg" name="account_password" placeholder="PASSWORD" value="">
            <span><input type="checkbox" />Remember Me</span>
            <h6><a href="#">Forgot Password?</a></h6>
            <div class="clearfix"></div>
            <input type="submit" value="Sign In" name="login">
            <style>
<<<<<<< HEAD
            ul.Social_Icon {
               margin-bottom: 10px;
               list-style: none;
               display: flex;
            }

            ul.Social_Icon li {
               margin: 10px;
            }
=======
               ul.Social_Icon {
                  margin-bottom: 10px;
                  list-style: none;
                  display: flex;
               }

               ul.Social_Icon li {
                  margin: 10px;
               }
>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95
            </style>
            <h3 style="color:white">Hoặc đăng nhập với : </h3>
            <ul class="Social_Icon">
               <?php Path::path_file_include("View_login_redirect-google", "View_login_redirect-facebook"); ?>
            </ul>

         </form>
<<<<<<< HEAD
         <p>Bạn có tài khoản không ? Nếu không có thì tiến hành<a
               href="<?php echo General::view_link('dang-ky.html'); ?>">Tạo tài khoản</a></p>
=======
         <p>Bạn có tài khoản không ? Nếu không có thì tiến hành<a href="<?php echo General::view_link('dang-ky.html'); ?>">Tạo tài khoản</a></p>
>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95
      </div>
   </div>

   <!-- Tập hợp file js -->
   <?php Path::path_file_include('Inc_script_resource') ?>

</body>

</html>
<?php
Path::path_file_include('Middleware', 'User_signIn', 'User_signUp');
?>

<?php
$admin = new SignUp();
$token = $admin->check_token($_GET['token']);
?>

<?php Path::path_file_include('Header_resource') ?>

<body>

    <div class="log-w3">
        <div class="w3layouts-main text-center">
            <?php
            if ($token['final']) {
            ?>
                <h2>
                    <?php
                    echo $token['alert'];
                    ?>
                </h2>
                <i class="fa fa-lg fa-check-circle text-success" style="font-size: 10rem; margin: 2rem 0;"></i>
                <div style="margin-top: 1rem;">
                    <a href="<?php echo General::view_link('dang-nhap', true) ?>" class="btn btn-primary btn-lg"><i class="fa fa fa-arrow-left"></i> Tiến hành đăng nhập</a>
                </div>
            <?php
            } else {
            ?>
                <h2>
                    <?php
                    echo $token['alert'];
                    ?>
                </h2>
                <i class="fa fa-lg fa-close text-danger" style="font-size: 10rem; margin: 2rem 0;"></i>
                <div style="margin-top: 1rem;">
                    <a href="<?php echo General::view_link('dang-ky', true) ?>" class="btn btn-primary btn-lg"><i class="fa fa fa-arrow-left"></i> Tiến hành đăng ký lại</a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- Tập hợp file js -->
    <?php Path::path_file_include('Script_resource') ?>

</body>

</html>
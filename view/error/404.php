<?php
Path::path_file_include('Database', 'Format', 'General', 'User_detail', 'Autoload');
include Path::path_file_local('Global');
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
    <!-- START Header top -->
    <?php Path::path_file_include('Header') ?>
    <!-- END -->

    <!-- START Navbar-nav -->
    <?php Path::path_file_include('Navbar-nav') ?>
    <!-- END -->
    <section id="mainContent">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="error_page_content">
            <h1>404</h1>
            <h2>WTF ? </h2>
            <h3>Cứ sai địa chỉ hoài vậy</h3>
            <p class="wow fadeInLeftBig">Please, continue to our <a href="<?php echo General::view_link("trang-chu.html", true) ?>">Home page</a></p>
          </div>
        </div>
      </div>
    </section>
  </div>

  <?php Path::path_file_include('Footer') ?>

  <?php Path::path_file_include('Script_resource') ?>
</body>

</html>
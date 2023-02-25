<style>
   ul.typeahead {
      width: 30% !important;
      max-height: 300px !important;
      overflow-y: auto !important;
      overflow-x: hidden !important;
   }

   ul.typeahead.dropdown-menu>.active>a,
   ul.typeahead.dropdown-menu>.active>a:hover,
   ul.typeahead.dropdown-menu>.active>a:focus {
      background: #ffa500 !important;
   }

   ul.typeahead li {
      background: #f9d084d1;
   }

   ul.typeahead li a {
      white-space: break-spaces;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      text-overflow: ellipsis;
      height: 50px;
   }

   #scrollable-dropdown-menu .dropdown-menu {
      max-height: 150px;
      overflow-y: auto;
   }
</style>
<script src="<?php echo Path::path_file('Assets_js_jquery.min') ?>"></script>
<script src="<?php echo Path::path_file('Assets_js_bootstrap.min') ?>"></script>
<script src="<?php echo Path::path_file('Assets_js_wow.min') ?>"></script>
<script src="<?php echo Path::path_file('Assets_js_slick.min') ?>"></script>
<script src="<?php echo Path::path_file('Assets_js_bootstrap-typeahead.min') ?>"></script>
<<<<<<< HEAD

<!-- custom js -->
<script src="<?php echo Path::path_file('Assets_js_custom') ?>"></script>
<script src="<?php echo Path::path_file('Assets_js_custom_typehead') ?>"></script>
<script src="<?php echo Path::path_file("Assets_js_custom_function") ?>"></script>
<!-- END -->
=======
<!-- custom js -->
<script src="<?php echo Path::path_file('Assets_js_custom') ?>"></script>
<script src="<?php echo Path::path_file('Assets_js_custom_typehead') ?>"></script>
>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95

<script>
   var path =
      "<?php echo Content::put_content('User_home', 'Home', 'search_product', 'lay-thong-tin-san-pham.php') ?>",
      link = "<?php echo General::view_link("xem-tin-tuc/", true) ?>";
   run_typehead(path, link);
</script>
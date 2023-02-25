<?php
Path::path_file_include('User_detail', 'Product', 'Autoload');
include Path::path_file_local('Global');
$detail = new Detail();
$product = new product();

$show_detail = $detail->show_product_detail(General::getParam(1));
// điều hướng đến trang error khi có lỗi
if (!$show_detail) {
   General::view_link_location("user-error-404.html", true);
}

$next_pro = $detail->next_prev($show_detail['Product_ID'], 'next');
$next_pro = empty($next_pro) ? null : $product->getproductbyId($next_pro)->fetch_assoc();

$prev_pro = $detail->next_prev($show_detail['Product_ID'], 'prev');
$prev_pro = empty($prev_pro) ? null : $product->getproductbyId($prev_pro)->fetch_assoc();

$detail->update_view($show_detail['Product_Slug'], $show_detail['Product_View']);
echo (bool) 1;
?>

<?php Path::path_file_include('Header_resource') ?>

<body>
   <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
   <div class="container">

      <!-- START Header top -->
      <?php Path::path_file_include('Header') ?>
      <!-- END -->

      <!-- START Navbar-nav -->
      <?php Path::path_file_include('Navbar-nav') ?>
      <!-- END -->
      <section id="mainContent">
         <div class="content_bottom">
            <div class="col-lg-8 col-md-8">
               <div class="content_bottom_left">
                  <div class="single_page_area">
                     <ol class="breadcrumb">
                        <!-- Home -->
                        <li><a href="<?php echo General::view("trang-chu", true) ?>">Home</a></li>
                        <?php
                        $result = $category->category_parent_by_child($show_detail['Cate_Pro_ID']);

                        if ($result) {
                           $result = General::getArrayFetchAssoc($result)[0];
                        ?>
                        <!-- Category parent -->
                        <li><a
                              href="<?php echo linkCategory($result['Cate_Pro_Slug']) ?>"><?php echo $result['Cate_Pro_Name'] ?></a>
                        </li>

                        <?php } ?>

                        <!-- Category child -->
                        <li><a
                              href="<?php echo linkCategory($show_detail['Cate_Pro_Slug']) ?>"><?php echo $show_detail['Cate_Pro_Name'] ?></a>
                        </li>

                        <!-- Product -->
                        <li class="active"><?php echo General::limitContent($show_detail['Product_Name'], 5) ?></li>
                     </ol>
                     <h2 class="post_titile"><?php echo $show_detail['Product_Name'] ?></h2>
                     <div class="single_page_content">
                        <div class="post_commentbox">
                           <a href="#"><i class="fa fa-user"></i><?php echo $show_detail['Product_UserName'] ?></a>
                           <span><i
                                 class="fa fa-calendar"></i><?php echo product_date($show_detail['created_at']); ?></span>
                           <a href="#"><i class="fa fa-tags"></i><?php echo $show_detail['Cate_Pro_Name'] ?></a>
                           <span><i class="fa fa-eye"></i><?php echo $show_detail['Product_View']; ?></span>
                        </div>

                        <?php echo $show_detail['Product_Content'] ?>

                        <button class="btn">Default</button>
                        <button class="btn btn-primary">Primary</button>
                        <button class="btn btn-success">Success</button>
                        <button class="btn btn-info">Info</button>
                        <button class="btn btn-warning">Warning</button>
                        <button class="btn btn-danger">Danger</button>
                     </div>
                  </div>
               </div>
               <div class="post_pagination">

                  <?php if ($prev_pro) {
                     $link = General::view_link("xem-tin-tuc/" . $prev_pro['Product_Slug'], true); ?>
                  <div class="prev"> <a class="angle_left" href="<?php echo $link  ?>"><i
                           class="fa fa-angle-double-left"></i></a>
                     <div class="pagincontent"> <span>Previous Post</span> <a href="<?php echo $link  ?>"
                           style="font-size: 13px;"><?php echo General::limitContent($prev_pro['Product_Name'], 13) ?></a>
                     </div>
                  </div>
                  <?php } ?>

                  <?php if ($next_pro) {
                     $link = General::view_link("xem-tin-tuc/" . $next_pro['Product_Slug'], true); ?>
                  <div class="next">
                     <div class="pagincontent"> <span>Next Post</span> <a href="<?php echo $link ?>"
                           style="font-size: 13px;"><?php echo General::limitContent($next_pro['Product_Name'], 13) ?></a>
                     </div>
                     <a class="angle_right" href="<?php echo $link ?>"><i class="fa fa-angle-double-right"></i></a>
                  </div>
                  <?php } ?>

               </div>
               <div class="share_post"> <a class="facebook" href="#"><i class="fa fa-facebook"></i>Facebook</a> <a
                     class="twitter" href="#"><i class="fa fa-twitter"></i>Twitter</a> <a class="googleplus" href="#"><i
                        class="fa fa-google-plus"></i>Google+</a> <a class="linkedin" href="#"><i
                        class="fa fa-linkedin"></i>LinkedIn</a> <a class="stumbleupon" href="#"><i
                        class="fa fa-stumbleupon"></i>StumbleUpon</a> <a class="pinterest" href="#"><i
                        class="fa fa-pinterest"></i>Pinterest</a> </div>
               <div class="similar_post">
                  <h2>Similar Post You May Like <i class="fa fa-thumbs-o-up"></i></h2>
                  <style>
                  div.content_bottom ul.small_catg.similar_nav li a.media-left {
                     width: 100%;
                     margin-bottom: 15px;
                  }
                  </style>
                  <ul class="small_catg similar_nav wow fadeInDown animated">

                  </ul>
               </div>

               <!-- START comment -->

               <div class="similar_post">
                  <h2>Bình luận</h2>
                  <div class="d-flex flex-start w-100">
                     <img class="rounded-circle shadow-1-strong me-3"
                        src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar" width="40"
                        height="40" />
                     <div class="form-outline w-100">
                        <textarea class="form-control" id="comment_news" rows="4" style="background: #fff;"></textarea>

                     </div>
                  </div>
                  <div class="float-end mt-2 pt-1">
                     <button type="button" class="btn btn-primary btn-sm" id="Submit_Comment">Post comment</button>
                     <button type="button" class="btn btn-outline-primary btn-sm" id="Cancel_Comment">Cancel</button>
                  </div>
               </div>

               <!-- END -->

               <!-- START comment -->
               <div class="similar_post">
                  <h2>Bình luận</h2>
                  <div class="similar_post">
                     <div id="comments-container"></div>
                  </div>
               </div>
               <!-- END -->

            </div>

            <!-- START Sidebar right -->
            <?php Path::path_file_include('Sidebar_right') ?>
            <!-- END -->

         </div>
      </section>
   </div>

   <!-- START footer -->
   <?php Path::path_file_include('Footer') ?>
   <!-- END -->

   <!-- Tập hợp file js -->
   <?php Path::path_file_include('Script_resource') ?>
   <!-- END -->

   <!-- Custom js comment -->
   <script src="<?php echo Path::path_file("Assets_js_custom_comment") ?>"></script>
   <!-- END -->

   <!-- custom js -->
   <script src="<?php echo Path::path_file('Assets_js_jquery.textcomplete') ?>"></script>
   <script src="<?php echo Path::path_file('Assets_js_jquery-comments.min') ?>"></script>
   <!-- END -->

   <script>
   $('ul.similar_nav').html(
      `<?php echo $detail->getSimilarPost($show_detail['Cate_Pro_ID'], $show_detail['Product_Slug']); ?>`);
   </script>
   <script>
   General.insert_head("<?php echo Path::path_file('Assets_css_jquery-comments') ?>", 1);

   $(document).on('click', 'span.send.save.enabled', function() {

   })

   var get_data, path =
      "<?php echo Content::put_content('User_comment', 'Comment', 'getComment', 'lay-binh-luan.php') ?>";
   $.ajax({
      url: path,
      type: 'GET',
      success: function(response) {
         get_data = JSON.parse(response);
         init_comment(get_data);
         console.log(get_data);
      }
   });

   function init_comment(commentsArray) {
      var saveComment = function(data) {
         // Convert pings to human readable format
         $(Object.keys(data.pings)).each(function(index, userId) {
            var fullname = data.pings[userId];
            var pingText = '@' + fullname;
            data.content = data.content.replace(new RegExp('@' + userId, 'g'), pingText);
         });
         return data;
      }
      $('#comments-container').comments({
         profilePictureURL: 'https://viima-app.s3.amazonaws.com/media/public/defaults/user-icon.png',
         currentUserId: 1,
         roundProfilePictures: true,
         textareaRows: 1,
         enableAttachments: true,
         enableHashtags: true,
         enablePinging: true,
         scrollContainer: $(window),
         getComments: function(success, error) {
            setTimeout(function() {
               success(commentsArray);
            }, 500);
         },
         postComment: function(data, success, error) {
            setTimeout(function() {
               success(saveComment(data));
            }, 500);
         },
         putComment: function(data, success, error) {
            setTimeout(function() {
               success(saveComment(data));
            }, 500);
         },
         deleteComment: function(data, success, error) {
            setTimeout(function() {
               success();
            }, 500);
         },
         upvoteComment: function(data, success, error) {
            setTimeout(function() {
               success(data);
            }, 500);
         },
         validateAttachments: function(attachments, callback) {
            setTimeout(function() {
               callback(attachments);
            }, 500);
         },
      });
   }
   </script>
</body>

</html>
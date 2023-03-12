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
$customer_user = $_SESSION['Customer_User'] ?? false;
$customer_id = $_SESSION['Customer_ID'] ?? false;
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
               <?php if ($customer_user) { ?>
               <style>
               /* Dành cho comment */
               div.attachments div.previews {
                  display: flex;
                  flex-flow: wrap;
               }
               </style>
               <div class="similar_post">
                  <h2>Bình luận</h2>
                  <div class="similar_post">
                     <div id="comments-container"></div>
                     <input type="hidden" class="Image_Attachment" value="" />
                  </div>
               </div>
               <?php } ?>
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
   var selector_str = 'div.commenting-field div.control-row';
   const RECORD_PER_PAGE = 3;

   var __FUNCTION__ = (function() {
      var get_id = <?php echo $show_detail['Product_ID'] ?>;
      var fullname = "<?php echo $customer_user ?>";
      var selector_attach = $('div.commenting-field div.attachments');
      var attachments_arr;

      function load_ajax_image(path, fd) {
         $.ajax({
            url: path,
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response) {
               console.log(response);
            }
         });
      }

      return {
         click_insert_comment: function(path) {
            $(document).on('click', 'div.control-row span.send.save', function() {
               let selector = $(this).parent('div.control-row').prev()
               var fd = new FormData();
               fd.append('product_id', get_id);
               fd.append('content', selector.text());
               fd.append('fullname', "<?php echo $customer_user ?>");

               //Send parent
               let parent = selector.data("parent");
               if (parent != undefined) {
                  parent = parent == undefined ? false : parent;
                  fd.append('parent', parent);
               }

               //Send attachments
               if (window.file != undefined) {
                  attachments_arr = window.file.length == 0 ? window.attachments : window.file;
               } else {
                  attachments_arr = false;
               }

               let check = $(this).parent('div.control-row').find('div.attachments');

               check = check.html().trim().length;
               if (attachments_arr && check > 0) {
                  for (var index = 0; index < attachments_arr.length; index++) {
                     fd.append("attachments[]", attachments_arr[index]);
                  }
               }
               load_ajax_image(path, fd);
            })
         },
         reload_comment: function(path, update = true, record_per_page = false) {

            $.ajax({
               url: path,
               type: 'GET',
               data: {
                  product_id: get_id,
                  update: update,
                  fullname: fullname,
                  record_per_page: window.paginate != undefined ? parseInt(window.paginate *
                     RECORD_PER_PAGE) : RECORD_PER_PAGE
               },
               success: function(response) {
                  get_data = JSON.parse(response);
                  console.log(get_data);
                  init_comment(get_data);
               }
            });
         },
         update_vote: function(path) {
            $(document).on('click', 'i.fa.fa-thumbs-up', function(event) {
               let comment_id = $(this).attr('comment_id');
               let upvote_count = parseInt($(this).prev("span.upvote-count").text());
               let check_active = $(this).parent('button').hasClass('highlight-font');

               if (check_active) {
                  upvote_count = Number(upvote_count) - 1;
                  user_has_upvoted = 0;
               } else {
                  upvote_count = Number(upvote_count) + 1;
                  user_has_upvoted = 1;
               }

               $.ajax({
                  url: path,
                  type: 'GET',
                  data: {
                     comment_id: comment_id,
                     upvote_count: upvote_count,
                     user_has_upvoted: user_has_upvoted
                  }
               });
            })
         },
         click_update_comment: function(path) {
            $(document).on('click', 'div.control-row span.update.save', function() {
               let selector = $(this).parent('div.control-row').prev();
               let comment_id = selector.data("comment");
               let content = selector.text();

               var fd = new FormData();
               fd.append('comment_id', comment_id);
               fd.append('content', content);

               //Send attachments

               let attachments_arr = window.file == undefined ? false : window.file;
               let check = $(this).parent('div.control-row').find('div.attachments');
               check = check.html().trim().length;
               let check_file = $('div.commenting-field div.control-row span.upload input')[1].files;
               check_file = check_file.length;
               //Kiểm tra ảnh ở validateAttachment và màn hình hiển thị
               if (attachments_arr && check > 0 && check_file > 0) {
                  for (var index = 0; index < attachments_arr.length; index++) {
                     fd.append("attachments[]", attachments_arr[index]);
                  }
               }
               load_ajax_image(path, fd);
            })
         },

         click_delete_comment: function(path) {
            $(document).on('click', 'div.control-row span.delete', function() {
               let selector = $(this).parent('div.control-row').prev();
               let comment_id = selector.data("comment");

               var fd = new FormData();
               fd.append('comment_id', comment_id);

               load_ajax_image(path, fd);
            })
         }
      }
   })();
   //Thiết lập một số chức năng để load comment

   var __FCOMMENT__ = (function() {
      var arr_length, arr = [],
         check = 0;

      return {
         click_view_comment: function(commentsArray) {
            setTimeout(function() {

               $(document).on('click', 'div#toggle_comment a.toggle-all', function() {

                  let status = parseInt($(this).attr("data-status"));
                  let paginate = parseInt($(this).attr("data-paginate"));
                  let max_paginate = parseInt($(this).attr("data-max_paginate"));

                  if (paginate < max_paginate) {
                     paginate = paginate + 1;

                     $(this).attr("data-status", 1);
                     $(this).attr("data-paginate", paginate);
                     $(this).children('span').html("View more comment");

                  } else {
                     paginate = 1;

                     $(this).attr("data-status", 0);
                     $(this).attr("data-paginate", paginate);
                     $(this).children('span').html("Hide comment");

                  }

                  window.paginate = paginate;
                  __FUNCTION__.reload_comment(get_path, false, paginate *
                     RECORD_PER_PAGE);

               });
            }, 500);
         },
         getComments: function(commentsArray) {

            commentsArray.forEach(element => {
               $("li[data-id=" + element.id + "] i.fa.fa-thumbs-up").eq(0).attr(
                  'comment_id', element.id);
               if (element.user_has_upvoted) {
                  $("li[data-id=" + element.id + "] button.action.upvote").eq(0)
                     .addClass('highlight-font');
               }
            });

            //lấy độ dài của comment parent
            arr_length = Math.ceil(commentsArray[0].count / RECORD_PER_PAGE);

            if ($("div#toggle_comment").length == 0) {

               let paginate = window.paginate == undefined ? 1 : window.paginate;

               $("ul#comment-list").after(
                  `<div style="text-align: center;" id="toggle_comment">
                     <a class="toggle-all highlight-font-bold" href="javascript:void(0)" data-status="1" data-paginate="${paginate}" data-max_paginate="${arr_length}">
                     <span class="text"></span>
                  </a></div>`
               );

               if (paginate == arr_length) {
                  $('div#toggle_comment span.text').html("Hide comment");
               } else {
                  $('div#toggle_comment span.text').html("View more comment");
               }


            }
         }
      }
   })();

   var insert_path =
      "<?php echo Content::put_content('User_comment', 'Comment', 'insertComment', 'chen-binh-luan.php') ?>";

   var get_path =
      "<?php echo Content::put_content('User_comment', 'Comment', 'getComment', 'lay-binh-luan.php') ?>";

   var get_attachment =
      "<?php echo Content::put_content('User_comment', 'Comment', 'get_attachments_id', 'lay-dinh-kem.php') ?>";

   var get_update_voted =
      "<?php echo Content::put_content('User_comment', 'Comment', 'updateVoted', 'cap-nhat-binh-chon.php') ?>";

   var get_update_comment =
      "<?php echo Content::put_content('User_comment', 'Comment', 'update_comment', 'cap-nhat-binh-luan.php') ?>";

   var get_delete_comment =
      "<?php echo Content::put_content('User_comment', 'Comment', 'delete_comment', 'xoa-binh-luan.php') ?>";

   __FUNCTION__.reload_comment(get_path);

   __FUNCTION__.click_insert_comment(insert_path);

   __FUNCTION__.update_vote(get_update_voted);

   __FUNCTION__.click_update_comment(get_update_comment);

   __FUNCTION__.click_delete_comment(get_delete_comment);

   setTimeout(() => {
      __FCOMMENT__.click_view_comment(window.commentsArray);
   }, 5000);


   //Sự kiện click vào textarea bình luận
   $(document).on('change', selector_str + ' span.upload', function() {
      $('div.commenting-field div.attachments').empty();
   })

   //Sự kiện click vào enter
   $(document).on('keypress', function name(event) {
      if (event.keyCode == 13) {
         $('div.control-row span.save.enabled').click();
         event.preventDefault();
      }
   })

   //Sự kiện click vào edit và reply
   $(document).on('click', 'button.action:not(.upvote)', function() {
      let commen_id = $(this).parents('li.comment').data('id');
      $('li.comment').each(function() {
         if ($(this).data('id') != commen_id) {
            $('div.textarea[data-comment="' + $(this).data('id') + '"]')
               .prev('span.close')
               .click();
         }
         $('div.commenting-field.main span.close').click();
      })
   })

   //Sự kiện click vào textarea bình luận
   $(document).on('click', 'div.commenting-field.main div.textarea', function() {
      $('div.commenting-field:not(.main) span.close').click();
   })

   function init_comment(commentsArray) {

      var loop_reload = function() {
         let value_clear = $('div.control-row a.tag.attachment').length;
         count = 0;
         var x = setInterval(function() {
            __FUNCTION__.reload_comment(get_path, false);
            if (count >= value_clear) clearInterval(x);
            count++;
         }, 1000);
      }

      $('#comments-container').comments({
         profilePictureURL: 'https://viima-app.s3.amazonaws.com/media/public/defaults/user-icon.png',
         currentUserId: 1,
         roundProfilePictures: true,
         textareaRows: 1,
         enableAttachments: true,
         enableHashtags: true,
         enablePinging: true,
         editedText: 'Chỉnh sửa vào lúc',
         scrollContainer: $(window),
         getComments: function(success, error) {
            //khởi tạo giá trị cho commentsArray để truyền vào click_view_comment
            window.commentsArray = commentsArray;

            setTimeout(() => {
               success(commentsArray);
               __FCOMMENT__.getComments(commentsArray);
            }, 500);
         },
         postComment: function(data, success, error) {
            setTimeout(function() {
               success(data);
            }, 500);

            loop_reload();
         },
         putComment: function(data, success, error) {
            setTimeout(function() {
               success(data);
               window.paginate = 1;
            }, 500);

            loop_reload();
         },
         deleteComment: function(data, success, error) {
            setTimeout(function() {
               __FUNCTION__.reload_comment(get_path, false);
            }, 500);
         },
         upvoteComment: function(data, success, error) {
            setTimeout(function() {
               __FUNCTION__.reload_comment(get_path, false);
            }, 500);
         },
         timeFormatter: function(time) {
            var option = {
               year: "numeric",
               month: "2-digit",
               day: "2-digit",
               hour: "2-digit",
               minute: "2-digit",
               second: "2-digit"
            };
            return new Date(time).toLocaleDateString("vi-VN", option)
         },
         validateAttachments: function(attachments, callback) {

            const myPromise = new Promise((resolve, reject) => {
               setTimeout(function() {
                  let arr = [];

                  for (let index = 0; index < attachments.length; index++) {
                     arr.push(attachments[index].file);
                  }
                  window.file = arr;

                  console.log("attachments");
                  console.log(attachments);

                  callback(attachments);
                  resolve(attachments);
               }, 1000);

            });

            myPromise
               .then((attachments) => {
                  //Xử lý trường hợp ảnh đính kèm cũ có ảnh trùng với ảnh đính kèm mới
                  $('div.commenting-field div.attachments').empty();
                  if ($('div.commenting-field div.control-row span.upload input').length > 0) {
                     var get_image_real = $('div.commenting-field div.control-row span.upload input')[0]
                        .files;
                     var new_arr = [];

                     for (let index = 0; index < get_image_real.length; index++) {
                        new_arr.push({
                           file: get_image_real[index],
                           mime_type: get_image_real[index].type
                        });
                     }
                     callback(new_arr);
                     window.attachments = get_image_real;

                     console.log("chạy window.attachments");
                     console.log(new_arr);
                  }
                  return "Thành công";
               })
               .then(
                  (attachments) => {

                     // Hiển thị hình ảnh khi có ảnh đính kèm trong bình luận
                     var files = window.file.length == 0 ? window.attachments : window.file;

                     if (files != undefined) {
                        var filesAmount = files.length;
                        sessionStorage.setItem('image_base', '[]');
                        for (i = 0; i < filesAmount; i++) {
                           // lấy link base64 hình ảnh
                           var reader = new FileReader();
                           reader.onload = function(event) {

                              let image_base = JSON.parse(sessionStorage.getItem('image_base'));
                              image_base.push(event.target.result);
                              sessionStorage.setItem('image_base', JSON.stringify(image_base));
                           }
                           reader.readAsDataURL(files[i]);
                        }
                        setTimeout(() => {
                           // tạo ra nội dung html để hiển thị hình ảnh
                           let selector = $('div.commenting-field div.attachments a.tag');
                           let image_base = JSON.parse(sessionStorage.getItem('image_base'));
                           var str = '';
                           for (let index = 0; index < image_base.length; index++) {
                              $(selector).eq(index).attr('href', image_base[index]);

                              str += `<div style="display: inline-block;margin-top: 3em;margin-right: 0.25em;">
                                 <a class="preview" href="${image_base[index]}" target="_blank">
                                    <img src="${image_base[index]}" style="width: 100px;height: 100px;">
                                 </a>
                              </div>`;
                           }

                           let div = document.createElement('div');
                           div.setAttribute('class', "previews");
                           div.innerHTML = str;

                           $('div.commenting-field div.attachments').prepend(div);
                        }, 1000);
                     }
                  }
               );
         }
      });
   }
   </script>
</body>

</html>
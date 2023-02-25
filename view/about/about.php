<?php
Path::path_file_include('User_detail', 'Autoload');
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
      <section id="ContactContent">
         <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
               <div class="contact_area">
                  <h1>Contacts</h1>
                  <p>Vestibulum id nisl a neque malesuada hendrerit. Mauris ut porttitor nunc, ut volutpat nisl. Nam
                     ullamcorper ultricies metus vel ornare. Vivamus tincidunt erat in mi accumsan, a sollicitudin
                     risus vestibulum. Nam dignissim purus vitae nisl adipiscing ultricies. Pellentesque in porttitor
                     tellus. Integer fermentum in sem eu tempus. In eu metus vitae nibh laoreet sollicitudin et ac
                     lectus. Curabitur blandit velit elementum augue elementum scelerisque.</p>
                  <div class="contact_bottom">
                     <div class="hide_content wow fadeInRightBig" style="display:none;text-align: center;">
                     </div>
                     <div class="contact_us wow fadeInRightBig">
                        <h2>Contact Us</h2>
                        <form class="contact_form" action="javascript:void(0)">
                           <input class="form-control" name="contact_name" type="text" placeholder="Name(required)">
                           <input class="form-control" name="contact_email" type="email" placeholder="E-mail(required)">
                           <input class="form-control" name="contact_subject" type="text" placeholder="Subject">
                           <textarea class="form-control" name="contact_message" cols="30" rows="10" placeholder="Message(required)" id="Ckeditor_Content"></textarea>
                           <input type="submit" value="Send">
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>

   <?php Path::path_file_include('Footer') ?>
   <?php Path::path_file_include('Script_resource') ?>

   <script src="<?php echo Path::path_file("Assets_js_jquery.validate") ?>"></script>
   <?php Path::path_file_include('Ckeditor_replace') ?>

   <script>
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
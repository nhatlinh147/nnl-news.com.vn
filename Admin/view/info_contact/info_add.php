<?php
//code php phải sau Inc_header_resource để có thể khởi tạo được object
Path::path_file_include('Info', 'Resize_image', 'View_put_content-middle');
$info = new info();
$title_admin = $info->infoTitleAdmin();
$title = $title_admin["title_add_list"];

?>

<!-- Tải tài nguyên ban đầu -->
<?php Path::path_file_include('Inc_header_resource') ?>

<body>
   <section id="container">

      <!-- Phần đầu trong nội dung trang web -->
      <?php Path::path_file_include('Inc_header') ?>

      <!-- Thanh sidebar: menu quản lý các đường dẫn trong trang web -->
      <?php Path::path_file_include('Inc_sidebar') ?>

      <!--main content start-->
      <section id="main-content">
         <section class="wrapper">
            <div class="form-w3layouts">
               <!-- page start-->
               <!-- page start-->
               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Thêm thông tin website
                        </header>
                        <div class="panel-body">
                           <div class="position-center">

                              <?php
                              if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                 $insertInfo = $info->insert_info($_POST, $_FILES);

                                 if (isset($insertInfo)) {
                                    echo $insertInfo;
                                 }
                              }

                              ?>

                              <form action="" method="post" enctype="multipart/form-data" id="Info_Website">
                                 <fieldset <?php $disable = $info->view_info() == "null" ? "" : "disabled";
                                             echo $disable ?>>
                                    <div class="form-group">
                                       <label for="info_webname">Tên website:</label>
                                       <input type="text" name="info_webname" class="form-control" placeholder="Tên website">
                                    </div>
                                    <div class="form-group">
                                       <label for="info_shopname">Tên shop:</label>
                                       <input type="text" name="info_shopname" class="form-control" placeholder="Tên shop">
                                    </div>
                                    <div class="form-group">
                                       <label for="info_author">Tên chủ sở hữu:</label>
                                       <input type="text" name="info_author" class="form-control" placeholder="Tên chủ sở hữu">
                                    </div>

                                    <div class="form-group">
                                       <label for="info_webname">Số điện thoại : </label>
                                       <input type="text" name="info_phone" class="form-control" placeholder="Số điện thoại">
                                    </div>
                                    <div class="form-group">
                                       <label for="info_shopname">Địa chỉ : </label>
                                       <input type="text" name="info_address" class="form-control" placeholder="Tên shop">
                                    </div>
                                    <div class="form-group">
                                       <label for="info_author">Mạng xã hội: (Nếu bạn không có thì bỏ qua)</label>

                                       <?php
                                       $array = ['facebook', 'google', 'twitter', 'instagram'];
                                       foreach ($array as $value) {
                                       ?>
                                          <div class="input-group">
                                             <span class="input-group-addon btn-success"><i class="fa fa-<?php echo $value ?> fa-1x"></i></span>
                                             <input type="text" class="form-control" data-social="<?php echo $value ?>" id="info_social_selected">
                                          </div>

                                       <?php } ?>
                                       <input type="hidden" name="info_social" class="info_social" value="">
                                    </div>
                                    <div class="form-group">
                                       <label for="info_image">Hình ảnh:</label>
                                       <input type="file" name="info_image[]" class="form-control info_image" id="IMAGE" placeholder="Tên chủ sở hữu" multiple>

                                       <div id="view_image" style="margin-top:8px ;">

                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="info_about_us">Về chúng tôi : </label>
                                       <textarea class="form-control" name="info_about_us" id="info_about_us"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-info" name="button_submit" id="Button_Info_Website">Thêm
                                       sản phẩm</button>
                                 </fieldset>
                              </form>
                           </div>

                        </div>
                     </section>

                  </div>
               </div>

               <div class="row">
                  <div class="col-lg-12">
                     <section class="panel">
                        <header class="panel-heading">
                           Thông tin website
                           <span class="tools pull-right">
                              <a class="fa fa-chevron-down" href="javascript:;"></a>
                              <a class="fa fa-times" href="javascript:;"></a>
                           </span>
                        </header>
                        <div class="panel-body">

                           <div class="table-responsive">
                              <table class="table" ui-jq="footable" ui-options="">
                                 <thead>
                                    <tr>
                                       <th width="30%">Danh mục thông tin</th>
                                       <th width="70%">Thông tin</th>
                                    </tr>
                                 </thead>
                                 <tbody>

                                 </tbody>
                              </table>
                           </div>

                        </div>
                     </section>
                  </div>
               </div>

            </div>
         </section>

         <?php Path::path_file_include('Inc_footer') ?>

      </section>
   </section>
   <!-- Tập hợp file js -->
   <?php Path::path_file_include('Inc_script_resource') ?>

   <!-- css thuộc tính thông báo lỗi trên trong panel -->
   <!-- Thêm button close vào thông báo -->
   <?php echo Path::path_file_include('Inc_style_notification_panel') ?>

   <!-- js script jquery validate -->
   <script src="<?php echo Path::path_file('Js_jquery.validate') ?>"></script>

   <!-- Upload Image -->
   <?php Path::path_file_include('Inc_script_upload_file') ?>

   <script>
      $.validator.addMethod("regex", function(value, element, regexp) {
         var re = new RegExp(regexp);
         return this.optional(element) || re.test(value);
      }, "Please check your input.");

      $.validator.addMethod("accept", function(value, element, param) {
         // Split mime on commas in case we have multiple types we can accept
         var typeParam = typeof param === "string" ? param.replace(/\s/g, "") : "image/*",
            optionalValue = this.optional(element),
            i, file, regex;

         // Element is optional
         if (optionalValue) {
            return optionalValue;
         }

         if ($(element).attr("type") === "file") {

            typeParam = typeParam
               .replace(/[\-\[\]\/\{\}\(\)\+\?\.\\\^\$\|]/g, "\\$&")
               .replace(/,/g, "|")
               .replace(/\/\*/g, "/.*");

            // Check if the element has a FileList before checking each file
            if (element.files && element.files.length) {
               regex = new RegExp(".?(" + typeParam + ")$", "i");
               for (i = 0; i < element.files.length; i++) {
                  file = element.files[i];

                  // Grab the mimetype from the loaded file, verify it matches
                  if (!file.type.match(regex)) {
                     return false;
                  }
               }
            }
         }

         return true;
      }, $.validator.format("Please enter a value with a valid mimetype"));

      $.validator.addMethod("multiple_length", function(value, element, param) {
         // Check if the element has a FileList before checking each file
         if (element.files.length > parseInt(param)) {
            return false;
         }
         return true;

      }, $.validator.format("Please enter a value with a valid mimetype"));
   </script>

   <script>
      function load_view_info() {
         var info = <?php echo $info->view_info() ?>;

         if (info != null) {
            let str = '';
            info.forEach(element => {
               str += `<tr data-expanded='true' class="${element.key}"><td> ${element.text} </td><td>`;
               if (element.key == 'Info_Image') {

                  let get_array = JSON.parse(element.value);
                  get_array.forEach(element_other => {
                     str +=
                        `<img src="${element_other}" width="70px" height="70px" class="img-thumbnail" style="margin:5px">`;
                  });

               } else if (element.key == 'Info_Social') {

                  let get_array = JSON.parse(element.value);

                  console.log(get_array.length);

                  get_array.forEach(element_other => {
                     if (element_other.value.trim().length > 0 && element_other.value.includes(
                           `${element_other.key}`)) {
                        str += `<a href="${element_other.value}" style="margin: 0px 10px" target="_blank">
                        <span class="fa fa-${element_other.key} fa-2x fa-border"></span>
                        </a>`;
                     }
                  });

               } else {
                  str += element.value;
               }
               str += '</td></tr>';

            });
            $('table tbody').html(str);
            //Sau khi thêm dữ liệu thành công thì khóa form không cho điền
         } else {
            $('table tbody').html(`<tr data-expanded='true'><td colspan="2">Không có dữ liệu</td></tr>`);
         }

      }
      load_view_info(); //2030

      $(document).ready(function() {

         $('section.panel a.fa-times').on('click', function() {
            $.ajax({
               url: '<?php echo Content::put_content('Info', 'info', 'delete_info', 'xoa-thong-tin-website.php') ?>',
               type: 'GET',
               success: function(response) {
                  console.log("Thành công");
                  //Xóa đi thuộc tính disabled 
                  $('fieldset').removeAttr("disabled");
               }
            });
         })

         $('input#IMAGE').change(function() {
            var arr = [],
               files = $(this)[0].files;
            console.log(files);

            for (let index = 0; index < files.length; index++) {
               arr.push(files[index].name);
            }

            let object = arr.length == 0 ? null : arr;
            console.log(object);
            $('input.info_image').val(JSON.stringify(arr));
         });

         $("button#Button_Info_Website").click(function() {
            let new_arr = [],
               new_arr1 = [];
            $('input#info_social_selected').each(function(index, value) {
               let key = $(this).data('social');
               new_arr.push({
                  key: key,
                  value: $(this).val().trim()
               });
            });

            let object = new_arr.length == 0 ? null : new_arr;
            $('input.info_social').val(JSON.stringify(object));
         });


         $("form#Info_Website").validate({
            ignore: [],
            rules: {
               info_webname: {
                  required: true
               },
               info_shopname: {
                  required: true
               },
               info_author: {
                  required: true
               },
               info_phone: {
                  required: true,
                  regex: "^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$"
               },
               info_address: {
                  required: true
               },
               'info_image[]': {
                  required: true,
                  accept: "image/*",
                  multiple_length: 6
               },
               info_about_us: {
                  required: true,
               },
            },
            messages: {
               info_webname: {
                  required: "Tên website không được để trống"
               },
               info_shopname: {
                  required: "Tên shop không được để trống"
               },
               info_author: {
                  required: "Tên chủ sở hữu không được để trống"
               },
               info_phone: {
                  required: "Số điện thoại không được để trống",
                  regex: "Số điện thoại phải bắt đầu bằng 0, có đủ 11 số"
               },
               info_address: {
                  required: "Địa chỉ không được để trống",
               },
               'info_image[]': {
                  required: "Image không được để trống",
                  accept: "Có file không phải là hình ảnh Xin hãy chọn lại",
                  multiple_length: "Số lượng hình ảnh tối đa là 6"
               },
               info_about_us: {
                  required: "Giới thiệu không được để trống",
               },
            }
         })

      });
   </script>

</body>

</html>
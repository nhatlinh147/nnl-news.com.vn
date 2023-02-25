<script>
    $(document).ready(function(){
        $('.product_image').on('change', function() {
            var file = $(this)[0].files[0];
            if(file.type.includes('image')){
                var fileReader = new FileReader();
                fileReader.onload = function() {
                    var str = '<img class="img-thumbnail js-file-image" style="width: 100px; height: 100px">';
                    $('#view_image').html(str);

                    var imageSrc = event.target.result;

                    $('.js-file-image').attr('src', imageSrc);
                };
                fileReader.readAsDataURL(file);
            }else{
                 $('#view_image').html('<div style="color:red;font-size:11pt; margin-left: 6px"><span style="font-weight:bold">Lỗi: </span><i>File nhập vào phải là hình ảnh. Xin hãy nhập lại</i></div>');
            }
        });
    });
</script>
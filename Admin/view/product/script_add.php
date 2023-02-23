<script type="text/javascript">
  $("#Form_Category_Add").validate({
            rules: {
            cate_pro_name: {
                remote: {
                    type: "post",
                    url: "<?php echo General::view_link("kiem-tra-ton-tai.html"); ?>",
                    data: {
                        var_name: "cate_pro_name"
                    }
                }
            }
        },
        messages: {
            cate_pro_name: {
                remote: "Tiêu đề ảnh bìa đã tồn tại. Xin nhập lại"
            }
        }
    })
</script>
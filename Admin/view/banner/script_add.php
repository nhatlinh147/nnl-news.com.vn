<script>
    $("#Form_Banner_Add").validate({
            rules: {
            banner_title: {
                remote: {
                    type: "post",
                    url: "<?php echo General::view_link("kiem-tra-ton-tai.html"); ?>",
                    data: {
                        var_name: "banner_title"
                    }
                }
            }
        },
        messages: {
            banner_title: {
                remote: "Tiêu đề ảnh bìa đã tồn tại. Xin nhập lại"
            }
        }
    })
</script>
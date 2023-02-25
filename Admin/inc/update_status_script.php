<script>
    var audio = new Audio("https://www.fesliyanstudios.com/play-mp3/387");
    $(document).on('click','.status_checks',function(){

    var status = ($(this).hasClass("text-success")) ? '0' : '1';
    var current_element = $(this);
    var id = $(current_element).attr('data');
    var type = $(current_element).attr('data_type');
        $.ajax({
            type:"POST",
            url: "thay-doi-trang-thai.html",
            data: {
                id:id,
                status:status,
                type:type
            },
            success: function(data)
            {
                audio.play();
                if(data.trim().length == 0 ){
                    if(type == 'category'){
                        msg = 'danh mục sản phẩm';
                    }else if(type == 'brand'){
                         msg = 'thương hiệu sản phẩm';
                    }else if(type == 'product'){
                         msg = 'sản phẩm';
                    }else if(type == 'slider'){
                         msg = 'slide';
                    }else if(type == 'banner'){
                         msg = 'banner';
                    }
                } else {
                    msg = data;
                }

                $('#notify_error_success').css({'padding':'15px 25px','margin':'15px 0px', 'border-radius': '5px','font-weight':'bold','font-size':'11pt'});
                if(status == '0'){
                    //Thiết lập lại button sau khi click vào button status
                    $('.content_status_'+id).html(`
                        <i data="${id}" class="fa fa-thumbs-o-down fa-2x text-danger status_checks" data_type="${type}"></i>
                    `);
                    $('#notify_error_success').show();
                    $('#notify_error_success').html(`Hủy kích hoạt ${msg} thành công`);
                    $('#notify_error_success').css({'background-color':'#ff000012','color':'red'});
                }else{
                    $('.content_status_'+id).html(`
                        <i data="${id}" class="fa fa-thumbs-o-up fa-2x text-success status_checks" data_type="${type}"></i>
                    `);
                    $('#notify_error_success').show();
                    $('#notify_error_success').html(`Kích hoạt ${msg} thành công`);
                    $('#notify_error_success').css({'background-color':'#06db0629','color':'green'});
                }
            
                var remove_msg = setTimeout(function(){
                    $('#notify_error_success').fadeOut().empty();
                }, 10000);

                // Dừng lại setTimeout. Nhằm khởi động thời gian lần settimeout tiếp theo
                $('i.status_checks').on('click', function () {
                    clearTimeout(remove_msg);
                }); 
            } // END Success
        }); // END ajax

    }); // END click status_checks

</script>
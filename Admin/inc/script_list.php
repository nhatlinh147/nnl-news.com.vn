<!-- Đoạn script dùng chung chức năng hiển thị kết quả mỗi phân trang-->
<script>
    $(document).ready(function(){
        load_data();  
            function load_data(page,number_page,search)  
            {  
                //Lấy giá trị của số page cần hiển thị
                if(number_page == undefined){
                    var number_page = <?php echo $_POST['number_page'] ?>;
                }

                //Lấy giá trị page mặc định
                if(page == undefined){
                    var page = <?php echo $_POST['page'] ?>;
                }

                //Tìm kiếm theo tiêu đề 
                if(search == undefined){
                    var search = '';
                }

               var from = (page - 1)*number_page + 1;
               var to = page*number_page;

                $.ajax({  
                    url:"<?php echo $_POST['url_paginate'] ; ?>?page_ajax=" + page,  
                    method:"POST",
                    data:
                    {
                        page:page,
                        number_page:number_page,
                        search:search
                    },  
                    success:function(data){  
                        $('#pagination_data').html(data);
                        $('li#'+page).addClass('active');
                        if($('li.active').length < 1){
                            $('li#1').addClass('active');
                        }

                        if(search == ''){
                            $('.showing_item').html(`<small class="text-muted inline m-t-sm m-b-sm">showing ${from}-${to} of `+<?php echo $_POST['total_records'] ?>+` items</small>`);
                        }
                        
                    }  // END success
                })  // END ajax
            } //END function load_data 
    
        $(document).on('click', '.pagination_link', function(){  
            var page = $(this).attr("id");
            var number_page = $('#pagi_number_page').val();
            var search = $('#Search_Admin').val();
            load_data(page,number_page,search);
        });
        $(document).on('change','#pagi_number_page',function(){
            var number_page = $(this).val();
            var page = 1;
            var search = $('#Search_Admin').val();
            load_data(page,number_page,search);
        });
        $('#Search_Admin').keyup(function(){
            var search = $(this).val();
            var number_page = $('#pagi_number_page').val();
            var page = 1;
            load_data(page,number_page,search);
        });

    });
</script>
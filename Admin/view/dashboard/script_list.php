<?php
    $url_paginate = General::view_link("phan-trang-slide.html");

    $_POST['url_paginate'] = $url_paginate;
    $_POST['number_page'] = $GLOBALS['number_page'];
    $_POST['page'] = $GLOBALS['page'];
    $_POST['total_records'] = $GLOBALS['total_records'];

    Path::path_file_include('Inc_script_list');

?>


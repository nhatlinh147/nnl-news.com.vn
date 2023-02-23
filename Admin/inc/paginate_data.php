<ul class="pagination pagination-sm m-t-none m-b-none">
    <?php
    $start_from = $GLOBALS['start_from'];
    $total_records = $GLOBALS['total_records'];
    $page = $GLOBALS['page'];
    $record_per_page = $GLOBALS['record_per_page'];
    $total_pages = $GLOBALS['total_pages'];

    $pagination_limit = 6;
    $leftCenter = $pagination_limit / 2;
    $rightCenter = $leftCenter - 1;
    $limit_start = 1;
    $current_page_number = $start_from / $record_per_page;
    $current_page_number = $current_page_number + 1;

    if ($current_page_number >= $pagination_limit) {
        //Điều chỉnh vị trí bắt đầu hiển thị paginate
        if ($total_records > (($current_page_number + $rightCenter) * $record_per_page)) {
            $limit_start = $current_page_number - $leftCenter + 1;
        } else {
            $limit_start = ($current_page_number - $pagination_limit) + $leftCenter;
        }

        $pagination_limit = $limit_start + ($pagination_limit - 1);
    }

    ?>

    <!-- button previous -->
    <?php
    if ($page - 1 <= 0) {
        echo "
        <li style='cursor:not-allowed;'><a style='background-color:#eee'><i class='fa fa-chevron-left'></i><i class='fa fa-chevron-left'></i></a></li>
        <li style='cursor:not-allowed;'><a style='background-color:#eee'><i class='fa fa-chevron-left'></i></a></li>";
    } else {
        echo "
        <li class='pagination_link' style='cursor:pointer' id='" . (int)(1) . "'><a><i class='fa fa-chevron-left'></i><i class='fa fa-chevron-left'></i></a></li>
        <li class='pagination_link' style='cursor:pointer' id='" . (int)($page - 1) . "'><a><i class='fa fa-chevron-left'></i></a></li>";
    }
    ?>
    </li>
    <?php
    $output = '';
    for ($i = $limit_start; $i <= $total_pages &&  $i <= $pagination_limit; $i++) {

        $output .= '<li class="pagination_link" style="cursor:pointer" id="' . $i . '"><a>' . $i . '</a></li>';
    }
    echo $output;
    ?>

    <!-- button next -->
    <?php
    if ($page + 1 > $total_pages) {
        echo "
        <li style='cursor:not-allowed;'><a style='background-color:#eee'><i class='fa fa-chevron-right'></i></a></li>
         <li style='cursor:not-allowed;'><a style='background-color:#eee'><i class='fa fa-chevron-right'></i><i class='fa fa-chevron-right'></i></a></li>
        ";
    } else {
        echo "
        <li class='pagination_link' style='cursor:pointer' id='" . (int)($page + 1) . "'><a><i class='fa fa-chevron-right'></i></a></li>
        <li class='pagination_link' style='cursor:pointer' id='" . (int)($total_pages) . "'><a><i class='fa fa-chevron-right'></i><i class='fa fa-chevron-right'></i></a></li>
        ";
    }
    ?>
</ul>
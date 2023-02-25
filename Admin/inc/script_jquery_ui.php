<!-- Các thư viện js ui trong jquery -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(function() {
        $("#DATE_START").datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dateFormat: "dd-mm-yy",
            todayHighlight: true,
            dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
            duration: "slow"
        });
        $("#DATE_END").datepicker({
            prevText: "Tháng trước",
            nextText: "Tháng sau",
            dateFormat: "dd-mm-yy",
            todayHighlight: true,
            dayNamesMin: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ nhật"],
            duration: "slow"
        });
    });
</script>
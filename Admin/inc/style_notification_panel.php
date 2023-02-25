<style type="text/css">
    ul.notification_panel {
        margin: 10px 5px;
        padding: 15px 30px;
        border-radius: 5px;
    }

    ul.notification_panel li.error {
        color: red;
        list-style-type: disc;
        margin: 8px 0px;
        font-style: italic;
        font-weight: 520;
        font-size: 11pt;
    }

    ul.notification_panel li.success {
        color: green;
        list-style-type: none;
        margin: 4px 0px;
        font-style: italic;
        font-weight: 450;
    }

    /* Điều chỉnh con trỏ trong mục status*/
    .status_checks {
        cursor: pointer;
    }
</style>
<script type="text/javascript">
    // $('ul.notification_panel li.error').length ? $('ul.notification_panel').css('background', '#ff000012') : $('ul.notification_panel').css('background', '#06db0629');

    var selector = $('ul.notification_panel');

    selector.prepend(`<button class="pull-right">x</button>`);

    if ($('ul.notification_panel li.error').length) {
        selector.css('background', '#ff000012');
        $('ul.notification_panel button').css({
            'background': '#ff000012',
            'border': '#ff000012',
        });
    } else {
        selector.css('background', '#06db0629');
        $('ul.notification_panel button').css({
            'background': '#06db0629',
            'border': '#06db0629',
        });
    }
    if ($('.notification_panel').length > 0) {

        setTimeout(function() {
            $('.notification_panel').fadeOut().remove();
        }, 15000);

        $('ul.notification_panel button').on('click', function() {
            $('.notification_panel').fadeOut().remove();
        })
    }
</script>
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

    .status_checks{
        cursor: pointer;
    }

</style>
<script type="text/javascript">
    $('ul.notification_panel li.error').length ? $('ul.notification_panel').css('background', '#ff000012') : $('ul.notification_panel').css('background', '#06db0629');
    setTimeout(function(){
        $('.notification_panel').fadeOut().remove();
    }, 10000);

</script>
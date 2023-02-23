<script src="<?php echo Path::path_file('Js_jquery2.0.3.min') ?>"></script>
<script src="<?php echo Path::path_file('Js_jquery.validate') ?>"></script>

<script src="<?php echo Path::path_file('Js_bootstrap') ?>"></script>
<script src="<?php echo Path::path_file('Js_jquery.dcjqaccordion.2.7') ?>"></script>
<script src="<?php echo Path::path_file('Js_scripts') ?>"></script>
<script src="<?php echo Path::path_file('Js_jquery.slimscroll') ?>"></script>
<script src="<?php echo Path::path_file('Js_jquery.nicescroll') ?>"></script>
<script src="<?php echo Path::path_file('Js_jquery.scrollTo') ?>"></script>

<script>
    function format_number(n, currency) {
        if(!isNaN(parseInt(n))){
            return parseInt(n).toFixed().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + currency;
        }else{
            return "Số nhập vào không phù hợp"
        }
        
    }
    var href = window.location.href.split('.html?');
    href = href[0];

    if(!href.includes(".html")){
        href = href + ".html";
    }

    $('ul.sub li').each(function(index) {
        var selector = $(this).children('a');
        if (selector.attr("href") == href) {
            $(this).parent('ul').prev('a').addClass("active");
            selector.addClass("active");
        }
    })

   $('ul.sidebar-menu li:not(.sub-menu) a').each(function(index) {
        if ($(this).attr("href") == href) {
            $(this).addClass("active");
        }
    });

</script>
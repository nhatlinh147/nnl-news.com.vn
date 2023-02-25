<!-- Ckeditor full package -->
<script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>

<script>
    CKEDITOR.replace('Ckeditor_Desc');
    CKEDITOR.replace('Ckeditor_Content', {
        filebrowserUploadUrl: '<?php echo General::view_link("tuy-chinh-ckeditor?admin=true") ?>',
        filebrowserUploadMethod: 'form'
    });

    CKEDITOR.replace('Ckeditor_Desc_Meta');
    CKEDITOR.replace('Ckeditor_Meta_Desc', {
        filebrowserUploadUrl: '<?php echo General::view_link("tuy-chinh-ckeditor?admin=true") ?>',
        filebrowserUploadMethod: 'form'
    });
</script>
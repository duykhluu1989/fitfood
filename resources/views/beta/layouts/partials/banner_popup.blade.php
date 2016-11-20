<script type="text/javascript">
    $(document).ready(function() {

        $.magnificPopup.open({
            items: {
                src: '<?php echo $bannerSrc; ?>'
            },
            type: 'image'
        });

    });
</script>
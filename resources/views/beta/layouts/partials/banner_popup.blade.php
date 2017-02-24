<script type="text/javascript">
    $(document).ready(function() {

        @if(!empty($banner['url']))

        $.magnificPopup.open({
            items: {
                src: '<a style="position: relative;width: auto;max-width: 70%;margin: 40px auto;display: block" href="<?php echo $banner['url']; ?>" target="_blank"><img src="<?php echo $banner['image_src']; ?>" width="100%" alt="Fitfood" border="0" /></a>'
            },
            closeBtnInside: false,
            closeMarkup: '<button style="margin-right: 15%" title="Close (Esc)" type="button" class="mfp-close">&#215;</button>',
            type: 'inline'
        });

        @else

        $.magnificPopup.open({
            items: {
                src: '<?php echo $banner['image_src']; ?>'
            },
            type: 'image'
        });

        @endif

    });
</script>
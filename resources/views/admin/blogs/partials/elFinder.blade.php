<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery-ui.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/js/elfinder/css/elfinder.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/js/elfinder/css/theme.css') }}">
<script type="text/javascript" src="{{ asset('assets/js/jquery-2.2.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/elfinder/js/elfinder.min.js') }}"></script>
<script type="text/javascript">
    var FileBrowserDialogue = {
        init: function() {
            // Here goes your code for setting your custom things onLoad.
        },
        mySubmit: function (file, elf) {
            // pass selected file data to TinyMCE
            parent.tinymce.activeEditor.windowManager.getParams().oninsert(file, elf);
            // close popup window
            parent.tinymce.activeEditor.windowManager.close();
        }
    };

    $().ready(function() {
        var elf = $('#elfinder').elfinder({
            // set your elFinder options here
            url: '<?php echo url('admin/article/connector/elFinder'); ?>',  // connector URL
            getFileCallback: function(file) { // editor callback
                // Require `commandsOptions.getfile.onlyURL = false` (default)
                FileBrowserDialogue.mySubmit(file, elf); // pass selected file path to TinyMCE
            }
        }).elfinder('instance');
    });
</script>
<div id="elfinder"></div>
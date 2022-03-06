(function($) {

    // USE STRICT
    "use strict";

    var frm = document.getElementById('wbgi-import-settings-form');

    $('#saveImportSettings').on('click', function(e) {
        //frm.submit(function(e) {

        e.preventDefault();

        $('span.error-message').hide();

        var fileElt = $('input#wbgi_upload');
        var fileName = fileElt.val();
        var maxSize = 2000000;

        if (fileName.length == 0) {
            alert('Please select a file');
            return false;
        } else if (!/\.(csv)$/.test(fileName)) {
            alert('Only csv file is permitted');
            return false;
        } else {
            var file = fileElt.get(0).files[0];
            if (file.size > maxSize) {
                alert('The file is too large. The maximum size is 2mb');
                return false;
            } else {
                frm.submit();
            }
        }
        //return false;

    });

})(jQuery);
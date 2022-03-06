(function($) {

    // USE STRICT
    "use strict";

    var wbgColorPicker = ['#wbg_pagi_item_bg_color'
    ];

    $.each(wbgColorPicker, function(index, value) {
        $(value).wpColorPicker();
    });

})(jQuery);
$(window).on('scroll', function() {
    var scrollTop = $(this).scrollTop();

    $('.bulkAddEditBtnWrapper').each(function() {
        var topDistance = $(this).offset().top;

        if ( (topDistance) < scrollTop ) {
			//$( ".bulkAddEditBtnWrapper" ).addClass( "scroller" );
        }
    });
});
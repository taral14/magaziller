jQuery(function($){

    $.fn.mzSlider=function(el){

    }

$('.content-menu a').click(function(){
        $('.content-menu a').removeClass('content-menu-active');
        $(this).addClass('content-menu-active');
        $('#slide').animate({
            left:$(this).attr('left')
        });
});

}(jQuery))
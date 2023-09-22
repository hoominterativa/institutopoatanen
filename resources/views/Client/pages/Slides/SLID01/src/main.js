$(function(){
    $('.SLID01').owlCarousel({
        animateOut: 'fadeOut',
        items:1,
        margin:0,
        stagePadding:0,
        smartSpeed:450,
        autoplay: true,
        autoplayTimeout:5000,
        loop: true,
        dots:true,
        nav:false,
        dotsContainer: "#dotsSlideCustom"
    });

    // $('.SLID01').css('height', $(window).outerHeight());
    // $('.SLID01 .container-slide').css('height', $(window).outerHeight());
})

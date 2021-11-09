$(function() {
    $('.slide-carousel-fade').owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        nav: false,
        dots: true,
        items: 1,
        margin: 0,
        stagePadding: 0,
        dotsContainer: ".navigation-slide"
    });
})

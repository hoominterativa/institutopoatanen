$(".prod05__carousel").owlCarousel({
    smartSpeed: 450,
    loop: false,
    dots: true,
    nav: false,
    rewind: true,
    autoHeight: true,
    margin: 21,
    responsive: {
        0: {
            items: 1,
        },
        // breakpoint from 0 up
        520: {
            items: 2,
        },
        // breakpoint from 361 up
        768: {
            items: 3,
        },
        980: {
            items: 4,
        },
    },
});

$('.prod05-show__btnForm--showForm').on('click', function(){
    if($(this).hasClass('active')){
        $('.prod05-show__wrapForm').removeClass('prod05-show__wrapForm--showForm');
        $(this).removeClass('active')
    }else{
        $('.prod05-show__wrapForm').addClass('prod05-show__wrapForm--showForm');
        $(this).addClass('active')
    }
})

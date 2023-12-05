if($(window).outerWidth() >= '500'){
    document.addEventListener('DOMContentLoaded', function () {
        var divider = document.querySelector('.divider');
        var imageContainer = document.querySelector('.image-container');
        var image1 = document.querySelector('.image1');
        var image2 = document.querySelector('.image2');
        var isDragging = false;
    
        if (!divider || !imageContainer || !image1 || !image2) {
            return;
        }
    
        divider.addEventListener('mousedown', function (e) {
            isDragging = true;
            e.preventDefault();
        });
    
        document.addEventListener('mouseup', function () {
            isDragging = false;
        });
    
        document.addEventListener('mousemove', function (e) {
            if (isDragging) {
                var xPos = e.pageX - imageContainer.offsetLeft;
                var containerWidth = imageContainer.offsetWidth;
                var percentage = (xPos / containerWidth) * 100;
    
                percentage = Math.min(100, Math.max(0, percentage));
    
                divider.style.left = percentage + '%';
                image1.style.clipPath = `inset(0% ${100 - percentage}% 0% 0%)`;
               
                image2.style.clipPath = `inset(0% 0% 0% ${percentage}%)`;
            }
        });
    });
}


$(function(){
    $('.carousel-port03').owlCarousel({
        smartSpeed:450,
        loop: false,
        dots:false,
        nav:true,
        rewind: true,
        autoHeight: true,
        items:1,
        rewind: true,
        touchDrag: false,
        mouseDrag:false,
    });
    $('.carousel-port03').css('width', $('.port03 .container').outerWidth());

    $('.carousel-box-image').owlCarousel({
        smartSpeed:450,
        loop: false,
        dots:true,
        nav:false,
        rewind: true,
        autoHeight: true,
        items:1,
        rewind: true,
    });
    $('.carousel-box-image').css('width', $('.popa .popa__portfolio__content__item').outerWidth() - 24);
})


$(function(){
    if ($(window).outerWidth() >= 500) {
        const boxSlideElements = $('.box-slide').get();
    
        boxSlideElements.forEach(element => {
            let $this = $(element);
            let divider = $this.find('.divider');
            let imageContainer = $this.find('.image-container');
            let image1 = $this.find('.image1');
            let image2 = $this.find('.image2');
            let isDragging = false;
    
            if (!divider.length || !imageContainer.length || !image1.length || !image2.length) {
                return;
            }
    
            divider.on('mousedown', function (e) {
                isDragging = true;
                e.preventDefault();
            });
    
            $(document).on('mouseup', function () {
                isDragging = false;
            });
    
            $(document).on('mousemove', function (e) {
                if (isDragging) {
                    let xPos = e.pageX - imageContainer.offset().left;
                    let containerWidth = imageContainer.width();
                    let percentage = (xPos / containerWidth) * 100;
    
                    percentage = Math.min(100, Math.max(0, percentage));
    
                    divider.css('left', percentage + '%');
                    image1.css('clip-path', `inset(0% ${100 - percentage}% 0% 0%)`);
                    image2.css('clip-path', `inset(0% 0% 0% ${percentage}%)`);
                }
            });
        });
    }
    
    // if($(window).outerWidth() >= '500'){

    //     $('.box-slide').forEach(element => {
    //         let $this = $(this);
    //         let divider = $this.find('.divider');
    //         let imageContainer = $this.find('.image-container');
    //         let image1 = $this.find('.image1');
    //         let image2 = $this.find('.image2');
    //         let isDragging = false;
        
    //         if (!divider.length || !imageContainer.length || !image1.length || !image2.length) {
    //             return;
    //         }
        
    //         $('body').on('mousedown', divider, function (e) {
    //             isDragging = true;
    //             e.preventDefault();
    //         });
        
    //         $(document).on('mouseup', function () {
    //             isDragging = false;
    //         });
        
    //         $(document).on('mousemove', function (e) {
    //             if (isDragging) {
    //                 let xPos = e.pageX - imageContainer.offset().left;
    //                 let containerWidth = imageContainer.width();
    //                 let percentage = (xPos / containerWidth) * 100;
        
    //                 percentage = Math.min(100, Math.max(0, percentage));
        
    //                 divider.css('left', percentage + '%');
    //                 image1.css('clip-path', `inset(0% ${100 - percentage}% 0% 0%)`);
    //                 image2.css('clip-path', `inset(0% 0% 0% ${percentage}%)`);
    //             }
    //         });
    //     });
    
        


       
        
    //     // $(document).on('mousemove', function (e) {
    //     //     divider = $('.fancybox__container .posh-show .divider');
    //     //     imageContainer = $('.fancybox__container .posh-show .image-container');
    //     //     image1 = $('.fancybox__container .posh-show .image1');
    //     //     image2 = $('.fancybox__container .posh-show .image2');
    //     //     isDragging = false;

    //     //     if (isDragging) {
    //     //         let xPos = e.pageX;
        
    //     //         // Se você estiver usando o FancyBox, ajuste os seletores de acordo com a estrutura do lightbox
    //     //         let imageContainer = $('.fancybox__container .posh-show .image-container');
    //     //         let image1 = $('.fancybox__container .posh-show .image1');
    //     //         let image2 = $('.fancybox__container .posh-show .image2');
        
    //     //         if (!imageContainer.length || !image1.length || !image2.length) {
    //     //             return;
    //     //         }
        
    //     //         let containerWidth = imageContainer.width();
    //     //         let percentage = (xPos / containerWidth) * 100;
        
    //     //         percentage = Math.min(100, Math.max(0, percentage));
        
    //     //         $('.fancybox__container .posh-show .divider').css('left', percentage + '%');
    //     //         image1.css('clip-path', `inset(0% ${100 - percentage}% 0% 0%)`);
    //     //         image2.css('clip-path', `inset(0% 0% 0% ${percentage}%)`);
               
    //     //     }

    //     // });

    // }
    
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
        autoHeight: true,
        items:1,
    });
    $('.carousel-box-image').css('width', $('.popa .popa__portfolio__content__item').outerWidth() - 24);
})

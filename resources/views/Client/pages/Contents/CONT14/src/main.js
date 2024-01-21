$(".carousel-gallery-cont13").owlCarousel({
    items: 1,
    margin: 0,
    stagePadding: 0,
    smartSpeed: 450,
    autoplay: true,
    autoplayTimeout: 5000,
    loop: true,
    dots: true,
    nav: false,
});

$('.cont13__left__link').on('click', function(e){
    e.preventDefault();

    const id = $(this).attr("id"); 
    const url = $(this).attr("url"); 

    console.log(url);

    // Store a reference to 'this' for later use
    const $this = $(this);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url,
        success: function(response){
            console.log(response);
            
            $("#cont13__right__engBox").fadeOut(400, function(){
                $(this).remove();
                $(".cont13__right").append(response).fadeIn();
            });

            $('.cont13__left__link').removeClass('active');

            // Use the stored reference to 'this'
            setTimeout(() => {
                $this.addClass('active');
            }, 400);
        },
        error: function(xhr, status, error){
            console.error(error);
            console.log("Status Code:", xhr.status);
        }
    });
});
// $('.cont13__left__link').on('click', function(e){
//     e.preventDefault();

//     const id = $(this).attr("id"); 
//     const url = $(this).attr("url");

//     $.ajax({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         type: "POST",
//         url: url,
//         data: { id: id },
//         success: function(response){
//             alert(response);

//             // Fade out the existing content
//             $("#cont13__right__engBox").fadeOut(400, function(){
//                 $(this).empty();
//                 $(".cont13__right").append(response).fadeIn();
//             });

//             $('.cont13__left__link').removeClass('active');

//             setTimeout(() => {
//                 $(this).addClass('active');
//             }, 400);
//         },
//         error: function(xhr, status, error){
//             console.error(error);
//             console.log("Status Code:", xhr.status);
//         }
//     });
// });
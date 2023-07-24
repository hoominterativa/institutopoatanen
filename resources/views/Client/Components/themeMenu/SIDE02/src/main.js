$(function () {
    $("body").append('<div class="side02__override trasition"></div>');
    $("[data-plugin=sidebar]").on("click", function () {
        if ($("#SIDE02").hasClass("side02--show")) {
            $("#SIDE02").removeClass("side02--show");
            $(this).removeClass("active");
            $(".side02__override").removeClass("side02__override--show");
            $("body").removeClass("no-scroll");
        } else {
            $("#SIDE02").addClass("side02--show");
            $(this).addClass("active");
            $(".side02__override").addClass("side02__override--show");
            $("body").addClass("no-scroll");
        }
    });

    // $('#SIDE02 ul li a').on('click', function(e){
    //     e.preventDefault();
    //     setTimeout(function(){
    //         $('#side02').removeClass('side02--show');
    //         $(this).removeClass('active');
    //         $('.side02__override').removeClass('side02__override--show');
    //         $('body').removeClass('no-scroll');
    //     }, 1000)
    // })
    $(".side02__header__button-close").on("click", function () {
        $("#SIDE02").removeClass("side02--show");
        $(this).removeClass("active");
        $(".side02__override").removeClass("side02__override--show");
        $("body").removeClass("no-scroll");
    });
});

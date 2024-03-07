// $(function () {
//     $("[data-plugin=sidebar]").on("click", function () {
//             $("#SIDE02").addClass("side02--show");
//             $("body").addClass("no-scroll");
//     });

//     $('#SIDE02 ul li a[href^="#"]').on("click", function () {
//         var target = $(this.getAttribute("href"));
//         if (target.length) {
//             $("html, body").animate({
//                     scrollTop: target.offset().top,
//                 },
//                 1000
//             );
//         }

//         setTimeout(function () {
//             $("#SIDE02").removeClass("side02--show");

//             $("body").removeClass("no-scroll");
//         }, 1000);
//     });

//     $(".side02__header__button-close").on("click", function () {
//         $("#SIDE02").removeClass("side02--show");
//         $("body").removeClass("no-scroll");
//     });
// });

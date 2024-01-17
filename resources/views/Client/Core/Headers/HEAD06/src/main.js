$('.dropdown-submenu a.dropdown-item').on("click", function(e) {
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
});
var btn = $("#back-to-top");
btn.on('click', function() {
    $('html, body').animate({scrollTop:0}, 'slow');
});
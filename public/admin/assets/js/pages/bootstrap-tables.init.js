$(function() {
    var e = $('input[name=btSelectAll]'),
        f = function() {
            if ($('.btSelectItem:checked').length) {
                $('#btSubmitDelete').fadeIn('fast')
            } else {
                $('#btSubmitDelete').fadeOut('fast')
            }
        }
    e.on('click', f)
    $('body, html').on('change', '.btSelectItem', f)
}), $(window).on("load", function() {
    $('[data-toggle="table"]').show();
});

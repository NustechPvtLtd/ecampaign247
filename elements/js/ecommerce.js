$(document).ready(function() {
    $(".panel-title a", this).click(function() {

        if ($('.glyphicon', this).hasClass('glyphicon-chevron-down')) {
            $('.glyphicon', this).removeClass('glyphicon-chevron-down');
            $('.glyphicon', this).addClass('glyphicon-chevron-up');
        } else {
            $('.glyphicon', this).addClass('glyphicon-chevron-down');
        }

    });
});


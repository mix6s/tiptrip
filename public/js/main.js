$(document).ready(function() {
    $("#mobile-icon-menu").click(function() {
        $('#content-overlay').fadeIn(300);
        $('#mobile-navigation').addClass('active');
        return false;
    });

    $("#content-overlay").click(function() {
        $(this).fadeOut(300);
        $('#mobile-navigation').removeClass('active');
        return false;
    });
});

var swiper = new Swiper('.swiper-welcome .swiper-container', {
    pagination: '.swiper-welcome .swiper-pagination',
    paginationClickable: true,
    nextButton: '.swiper-welcome .swiper-button-next',
    prevButton: '.swiper-welcome .swiper-button-prev'
});

var swiper = new Swiper('.swiper-how-work .swiper-container', {
    pagination: '.swiper-how-work .swiper-pagination',
    paginationClickable: true,
    paginationBulletRender: function (index, className) {
        return '<span class="' + className + '">' + (index + 1) + '</span>';
    }
});
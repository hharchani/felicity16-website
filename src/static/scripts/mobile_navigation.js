/* global $, localeBaseUrl, showLanding, localeBaseTitle */

$(function () {
    var $window = $(window);
    var $head = $('.head');
    $window.on('mousemove', function (e) {
        var r = Math.atan2(window.innerHeight - 10 - e.clientY, window.innerWidth/2 - e.clientX ) - Math.PI / 2;
        $head.css('transform', ['rotate(', r, 'rad) translateY(-4.5em)'].join(''));
    });
});

$(function () {
    var $menuToggleButton = $('.mobile-nav-toggle');
    var $toggleIcon = $menuToggleButton.find('i');
    var $mobileMenu = $('.mobile-menu-container');
    $mobileMenu.on('click', function (e) {
        e.stopPropagation();
    });
    $menuToggleButton.on('click', function (e) {
        $mobileMenu.toggleClass('open');
        $toggleIcon.toggleClass('icon-menu icon-left-open');
        e.preventDefault();
        e.stopPropagation();
    });
    $('.mobile-menu a').on('click', function (e) {
        $mobileMenu.removeClass('open');
        $toggleIcon.removeClass('icon-left-open').addClass('icon-menu');
        if ($(this).hasClass('mobile-home-icon')) {
            showLanding();
            history.pushState(localeBaseUrl, null, localeBaseUrl);
            document.title = localeBaseTitle;
            e.preventDefault();
        }
    });
    $('body').on('click', function (e) {
        if ($menuToggleButton.is(':visible')) {
            $mobileMenu.removeClass('open');
            $toggleIcon.removeClass('icon-left-open').addClass('icon-menu');
            e.preventDefault();
        }
    });
});

$(function () {
    setTimeout(function () {
        $('.full-visible').removeClass('full-visible');
    }, 500);
});

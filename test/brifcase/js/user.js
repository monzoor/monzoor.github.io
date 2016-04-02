/*jslint browser: true*/
$(document).ready(function () {
    var stickyNav = function () {
        var winHeight = $(window).height();
        var scrollTop = $(window).scrollTop();
        if (scrollTop > 60) {
            $('.navbar').addClass('rel');
        } else {
            $('.navbar').removeClass('rel');
        }
        if (scrollTop > winHeight && $('.navbar').hasClass('rel')) {
            $('.navbar').addClass('fxd');
            $('.copy').addClass('marge_section');
        } else {
            $('.navbar').removeClass('fxd');
            $('.copy').removeClass('marge_section');
        }
    };
    stickyNav();
    $(window).scroll(function () {
        stickyNav();
    });

    $(".index li a").click(function (event) {
        event.preventDefault();
        console.log();
        $('html, body').animate({
            scrollTop: $("#" + $(this).data("nav")).offset().top
        }, 500);
    });

    $(".player").mb_YTPlayer().on("YTPUnstarted", function () {
        console.log("ready");
    });
    $('.test').change(function () {
        $('.card').toggleClass('applyflip');
        console.log("changed");
    }.bind(this));

});


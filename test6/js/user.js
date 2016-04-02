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

    $(".navbar-nav li a, .btn.ask").click(function (event) {
        event.preventDefault();
        $(".navbar-nav li a").removeClass("selected");
        $(this).addClass("selected");
        var navUrl = $(this).data("nav");
        $('html, body').animate({
            scrollTop: $(navUrl).offset().top - 40
        }, 500);
    });

    $(".btn.ask").click(function (event) {
        event.preventDefault();
        var navUrl = $(this).data("nav");
        $('html, body').animate({
            scrollTop: $(navUrl).offset().top - 40
        }, 500);
    });

    $(".player").mb_YTPlayer().on("YTPUnstarted", function () {
        console.log("ready");
    });
    if ($(window).width()>430) {

    }
    $('.switch').change(function () {
        $('.card').toggleClass('applyflip');
        console.log("changed");
    }.bind(this));


    var theForm = document.getElementById('theForm');
    new stepsForm(theForm, {
        onSubmit : function (form) {
            // hide form
            classie.addClass(theForm.querySelector('.simform-inner'), 'hide');
            /*
            form.submit()
            or
            AJAX request (maybe show loading indicator while we don't have an answer..)
            */
            // let's just simulate something...
            var messageEl = theForm.querySelector('.final-message');
            messageEl.innerHTML = 'Thank you! We\'ll be in touch.';
            classie.addClass(messageEl, 'show');
        }
    });

    $('#demo2').t(
        "<span class='header2'>LAWYERS ARE EXPENSIVE.</span><br/>LEGAL ESSENTIALS SHOULDN\'T BE. ",{
            speed: 70, // typing speed (ms)
            speed_vary: false, // delays start for (N.)Ns
            mistype: false, // mistyping: 1:N per char
            locale: 'en', // keyboard layout; 'en', 'de'
            tag: 'span',
            rtl: true,
            caret:'',  
            fin: function(e) {
              _e = e.find('.t-caret');
              setInterval(function() {
                _e.toggleClass('vis');
              }, 5e2)
            }
        });
    new WOW().init();
});


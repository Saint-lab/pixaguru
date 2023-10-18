/*--------------------- Copyright (c) 2023 [Master Javascript] ---------------*/
(function($) {
    "use strict";        

        /*------ Fix GoToTopButton ---------------*/
        var scrollTop = $("#scroll");
        $(window).on('scroll', function() {
            if ($(this).scrollTop() < 500) {
                scrollTop.removeClass("active");
            } else {
                scrollTop.addClass("active");
            }
        });
        $('#scroll').click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, 500);
            return false;
        });
        $(function() {
            $('.go-to-features').click(function() {
                $('html, body').animate({ scrollTop: $('#go-to-features').offset().top }, 'slow');
                return false;
            });
        });                
        
        // sticky header        
        var header = $(".pg-header-wrapper");
        var w = window.innerWidth;
        if (w >= 1199) {
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if (scroll >= 300 && $(this).width() > 1199) {
                    header.addClass("sticky-header animated fadeInDown");
                } else {
                    header.removeClass('sticky-header animated fadeInDown');
                }
            });
        }
        if (w <= 1199) {
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if (scroll >= 400 && $(this).width() < 1199) {
                    header.addClass("sticky-header");
                } else {
                    header.removeClass('sticky-header');
                }
            });
        }
        // Video Modal
        if ($(".youtube-popup").length > 0) {
            $(".youtube-popup").magnificPopup({
                type: "iframe",
            });
        }        
})(jQuery);
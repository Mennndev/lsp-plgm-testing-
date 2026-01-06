/******************************************
    Version: 1.1 (Updated for Bootstrap 5)
/****************************************** */

(function($) {
    "use strict";

    // 1. Smooth scrolling using jQuery easing
    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: (target.offset().top - 54)
                }, 1000, "easeInOutExpo");
                return false;
            }
        }
    });

    // 2. Closes responsive menu when a scroll trigger link is clicked (UPDATED FOR BOOTSTRAP 5)
    $('.js-scroll-trigger').click(function() {
        // Mengambil elemen navbar collapse
        var navbarCollapse = document.getElementById('navbarResponsive');

        // Cek apakah elemen ada dan apakah instance Bootstrap Collapse sudah aktif
        if (navbarCollapse) {
            var bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
            if (bsCollapse) {
                bsCollapse.hide();
            } else {
                // Jika belum ada instance, buat baru lalu hide (untuk jaga-jaga)
                new bootstrap.Collapse(navbarCollapse, { toggle: false }).hide();
            }
        }
    });

    // 3. Activate scrollspy to add active class to navbar items on scroll (UPDATED FOR BOOTSTRAP 5)
    // Bootstrap 5 menggunakan Vanilla JS untuk ScrollSpy, bukan jQuery
    window.addEventListener('load', function() {
        var scrollSpyElement = document.body;
        var scrollSpy = new bootstrap.ScrollSpy(scrollSpyElement, {
            target: '#mainNav',
            offset: 56
        });
    });

    // 4. Collapse Navbar Logic
    var navbarCollapseLogic = function() {
        if ($("#mainNav").offset().top > 100) {
            $("#mainNav").addClass("navbar-shrink");
        } else {
            $("#mainNav").removeClass("navbar-shrink");
        }
    };

    // Collapse now if page is not at top
    navbarCollapseLogic();

    // Collapse the navbar when page is scrolled
    $(window).scroll(navbarCollapseLogic);

    // 5. Hide navbar when modals trigger
    $('.portfolio-modal').on('show.bs.modal', function(e) {
        $(".navbar").addClass("d-none");
    });
    $('.portfolio-modal').on('hidden.bs.modal', function(e) {
        $(".navbar").removeClass("d-none");
    });

    // 6. Scroll to top logic
    if ($('#scroll-to-top').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#scroll-to-top').addClass('show');
                } else {
                    $('#scroll-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#scroll-to-top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }

    // 7. Banner / Slick Slider
    $(document).ready(function(){
        // Cek apakah elemen slick ada sebelum dijalankan untuk menghindari error
        if ($('.ct-slick-homepage').length) {
            $('.ct-slick-homepage').on('init', function(event, slick){
                $('.animated').addClass('activate fadeInUp');
            });

            $('.ct-slick-homepage').slick({
                autoplay: false,
                autoplaySpeed: 3000,
                pauseOnHover: false,
            });

            $('.ct-slick-homepage').on('afterChange', function(event, slick, currentSlide) {
                $('.animated').removeClass('off');
                $('.animated').addClass('activate fadeInUp');
            });

            $('.ct-slick-homepage').on('beforeChange', function(event, slick, currentSlide) {
                $('.animated').removeClass('activate fadeInUp');
                $('.animated').addClass('off');
            });
        }
    });

    // 8. Hover Effect
    $(".hover").mouseleave(
        function() {
            $(this).removeClass("hover");
        }
    );

    // 9. LOADER
    $(window).on('load', function() {
        $("#preloader").delay(500).fadeOut();
        $(".preloader").delay(600).fadeOut("slow");
    });

    // 10. Gallery Filter / Isotope
    var Container = $('.container');
    Container.imagesLoaded(function () {
        var portfolio = $('.gallery-menu');
        // Cek apakah elemen gallery list ada
        if ($('.gallery-list').length) {
            var $grid = $('.gallery-list').isotope({
                itemSelector: '.gallery-grid'
            });

            portfolio.on('click', 'button', function () {
                $(this).addClass('active').siblings().removeClass('active');
                var filterValue = $(this).attr('data-filter');
                $grid.isotope({
                    filter: filterValue
                });
            });
        }
    });

    // 11. FUN FACTS COUNTER
    function count($this) {
        var current = parseInt($this.html(), 10);
        current = current + 50; /* Where 50 is increment */
        $this.html(++current);
        if (current > $this.data('count')) {
            $this.html($this.data('count'));
        } else {
            setTimeout(function() {
                count($this)
            }, 30);
        }
    }
    $(".stat_count, .stat_count_download").each(function() {
        $(this).data('count', parseInt($(this).html(), 10));
        $(this).html('0');
        count($(this));
    });

    // 12. CONTACT FORM SUBMISSION
    jQuery(document).ready(function() {
        $('#contactform').submit(function() {
            var action = $(this).attr('action');
            $("#message").slideUp(750, function() {
                $('#message').hide();
                $('#submit')
                    .after('<img src="images/ajax-loader.gif" class="loader" />')
                    .attr('disabled', 'disabled');
                $.post(action, {
                        first_name: $('#first_name').val(),
                        last_name: $('#last_name').val(),
                        email: $('#email').val(),
                        phone: $('#phone').val(),
                        select_service: $('#select_service').val(),
                        select_price: $('#select_price').val(),
                        comments: $('#comments').val(),
                        verify: $('#verify').val()
                    },
                    function(data) {
                        document.getElementById('message').innerHTML = data;
                        $('#message').slideDown('slow');
                        $('#contactform img.loader').fadeOut('slow', function() {
                            $(this).remove()
                        });
                        $('#submit').removeAttr('disabled');
                        if (data.match('success') != null) $('#contactform').slideUp('slow');
                    }
                );
            });
            return false;
        });
    });

})(jQuery);

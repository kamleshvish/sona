(function ($) {

    var $this = $('.header-main.header-listing-fixed');
    stmMobileMenu();

    $(document).ready(function () {
        stm_listing_fixed_header();

        $('.big-wrap').lightGallery({
            selector: '.stm-cf-big',
            mode: 'lg-fade',
            download: false
        })
    });

    $(window).load(function () {
        stm_listing_fixed_header();
    });

    $(window).resize(function () {
        stm_listing_fixed_header();
    });

    $(window).scroll(function () {
        stm_listing_fixed_header();
    });

    function stm_listing_fixed_header() {
        if ($('.header-main').hasClass('header-listing-fixed')) {
            var currentScrollPos = $(window).scrollTop();
            var headerPos = $('#header').offset().top;

            if (currentScrollPos > headerPos + 400) {
                $('.header-main').addClass('stm-fixed');

            } else {
                $('.header-main').removeClass('stm-fixed');
            }
        }
    }

    function stmMobileMenu() {
        $('.mobile-menu-trigger').on('click', function(){
            $(this).toggleClass('opened');
            $('.mobile-menu-holder').slideToggle();
        })
        $(".mobile-menu-holder .header-menu li.menu-item-has-children > a")
            .after('<span class="arrow"><i class="fa fa-angle-right"></i></span>');

        $(".magazine-menu-mobile > li.menu-item-has-children > a")
            .after('<span class="arrow"><i class="fa fa-angle-right"></i></span>');

        $('.mobile-menu-holder .header-menu .arrow').on('click', function(){
            $(this).toggleClass('active');
            $(this).closest('li').toggleClass('opened');

            if(!$(this).parent().hasClass('stm_megamenu')) {
                $(this).closest('li').find('> ul.sub-menu').slideToggle(300);
            }
        })

        $(".mobile-menu-holder .header-menu > li.menu-item-has-children > a").on('click', function (e) {
            if( $(this).attr('href') == '#' ){
                e.preventDefault();
                $(this).closest('li').find(' > ul.sub-menu').slideToggle(300);
                $(this).closest('li').toggleClass('opened');
                $(this).closest('li').find('.arrow').toggleClass('active');
            }
        });

        $('body').on('click', '.magazine-menu-mobile > li.menu-item-has-children >.arrow', function (e) {
            $(this).parent().toggleClass('active');
        });
    }
})(jQuery)
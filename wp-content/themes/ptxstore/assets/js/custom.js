//Menu
jQuery(document).ready(function() {
    jQuery('.menu-box .main-menu>li.menu-item-has-children>a').append('<i class="fa fa-angle-down"></i>');
    jQuery('.menu-box .main-menu .sub-menu>li.menu-item-has-children>a').append('<i class="fa fa-angle-right"></i>');

    jQuery('.btn-show-menu').click(function() {
        jQuery(this).parents('header').find('.menu-box').css('width', '100vw');
    });
    jQuery('.menu-box .btn-hide-menu, .menu-box .bg-menu').click(function() {
        jQuery(this).parents('.menu-box').css('width', '0');
    });

    if ($(window).width() < 992) {
        jQuery('.main-menu li.menu-item-has-children>a>i').click(function(e) {
            e.preventDefault();
            jQuery(this).parent().parent().children('.sub-menu').slideToggle('fast');
        });
    }

    jQuery('.treeview-item>a').on("click", function(e) {
        e.preventDefault();
        jQuery(this).parent().children('.sub-treeview').slideToggle('fast');
    });

    // search animate
    jQuery('.search-wrapper').click(function() {
        jQuery(this).addClass("active");
        jQuery('#search').focus();
        jQuery(this).find('.label-search').addClass('active');
        jQuery('#search').addClass('active');
    })

    $("body").on('click', function(e) {
        console.log(e.target);
        if (!$(e.target).hasClass('search-input') && !$(e.target).hasClass('search-wrapper') &&
            !$(e.target).hasClass('search') && !$(e.target).hasClass('icon-search') && !$(e.target).hasClass('label-search') && !$(e.target).hasClass('search-mobile-icon')) {
            $('#search').blur();
            if (jQuery('#search').val() == ""){
                jQuery(this).find('.label-search').removeClass('active');
            }
            jQuery('#search').removeClass('active');
            jQuery(this).find('.search-wrapper').removeClass("active");
            jQuery(this).find('.line-bottom').hide();
            // jQuery(this).find('header').removeClass('active')
        }
        if ($(e.target).hasClass('header')) {
            jQuery(this).find(e.target).removeClass('active');
            jQuery(this).find('.search-wrapper').addClass('d-sm-none');
            jQuery(this).find('.search-wrapper').addClass('d-none');
        }
    })

    jQuery('#search').keyup(function(e) {
        if (jQuery(this).val() == ""){
            jQuery(this).removeClass('active');
            jQuery(this).parents('.search-wrapper').find('.search-close-icon').hide();
            jQuery(this).parents('.search-wrapper').find('.line-bottom').show();
        }else{
            jQuery(this).parents('.search-wrapper').find('.line-bottom').hide();
            jQuery(this).addClass('active');
            jQuery(this).parents('.search-wrapper').find('.search-close-icon').show();
        }
    });

    jQuery('.search-mobile-icon').click(function(){
        jQuery(this).parents('body').find('header').addClass('active');
        jQuery('#search').focus();
        jQuery(this).parents('header').find('.search-wrapper').addClass('active');
        jQuery(this).parents('header').find('.search-wrapper').removeClass('d-sm-none');
        jQuery(this).parents('header').find('.search-wrapper').removeClass('d-none');
        jQuery(this).parents('header').find('.label-search').addClass('active');
    })
});
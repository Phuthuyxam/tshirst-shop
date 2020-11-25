<?php
function pveser_theme_styles()
{
	wp_enqueue_style('owl-carousel', __THEME_HOST.'/assets/css/owl.carousel.min.css', array(), false, 'all');
	wp_enqueue_style('owl-theme', __THEME_HOST.'/assets/css/owl.theme.default.min.css', array(), false, 'all');
//    wp_enqueue_style('fancy-box', __THEME_HOST.'/assets/css/laibrary/jquery.fancybox.min.css', array(), false, 'all');
    wp_enqueue_style('fancy-box', __THEME_HOST.'/assets/css/bootstrap.min.css', array(), false, 'all');
    wp_enqueue_style('animation', __THEME_HOST.'/assets/css/animate.min.css', array(), false, 'all');
    wp_enqueue_style('icon-style', __THEME_HOST.'/assets/css/font-awesome.min.css', array(), false, 'all');
    wp_enqueue_style('main-style', __THEME_HOST.'/assets/css/style.css', array(), false, 'all');
    wp_enqueue_style('main-woo-style', __THEME_HOST.'/assets/css/woocomerce-style.css', array(), false, 'all');
	wp_enqueue_style('default-style', __THEME_HOST.'/style.css', array(), false, 'all');
}

add_action( 'wp_enqueue_scripts', 'pveser_theme_styles' );

function pveser_theme_scripts()
{
	wp_enqueue_script('zoom', __THEME_HOST.'/assets/js/jquery.elevateZoom-3.0.8.min.js', array(), false, true);
    wp_enqueue_script('owl-js', __THEME_HOST.'/assets/js/owl.carousel.min.js', array(), false, true);
	wp_enqueue_script('bootstrap-js', __THEME_HOST.'/assets/js/bootstrap.min.js', array(), false, true);
	wp_enqueue_script('custom', __THEME_HOST.'/assets/js/custom.js', array(), false, true);
    wp_enqueue_script('custom-woo', __THEME_HOST.'/assets/js/page/archivewoo.js', array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'pveser_theme_scripts' );
?>
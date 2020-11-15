<?php
function pveser_theme_styles()
{
//	wp_enqueue_style('owl-carousel', __THEME_HOST.'/assets/css/laibrary/owl.carousel.min.css', array(), false, 'all');
//	wp_enqueue_style('owl-theme', __THEME_HOST.'/assets/css/laibrary/owl.theme.default.min.css', array(), false, 'all');
//    wp_enqueue_style('fancy-box', __THEME_HOST.'/assets/css/laibrary/jquery.fancybox.min.css', array(), false, 'all');
//    wp_enqueue_style('main-style', __THEME_HOST.'/assets/css/style/style.css', array(), false, 'all');
	wp_enqueue_style('default-style', __THEME_HOST.'/style.css', array(), false, 'all');
}

add_action( 'wp_enqueue_scripts', 'pveser_theme_styles' );

function pveser_theme_scripts()
{
//	wp_enqueue_script('fancybox', __THEME_HOST.'/assets/js/laibrary/jquery.fancybox.min.js', array(), false, true);
//	wp_enqueue_script('owl-carousel', __THEME_HOST.'/assets/js/laibrary/owl.carousel.min.js', array(), false, true);
//	wp_enqueue_script('custom', __THEME_HOST.'/assets/js/custom.js', array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'pveser_theme_scripts' );
?>
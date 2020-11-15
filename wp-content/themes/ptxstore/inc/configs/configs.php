<?php
define("__THEME_HOST", get_template_directory_uri());
define("__WEB_HOST_ROOT", get_bloginfo("url"));
define("__WEB_TITLE", get_bloginfo("name"));
define("__WEB_SLOGAN", get_bloginfo("description"));
define("__THEME_PATH", get_template_directory());
define("__HOST_PLUGIN", get_template_directory_uri().'/pveser-framework/plugins');
function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support');
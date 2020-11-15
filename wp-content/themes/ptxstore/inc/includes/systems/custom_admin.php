<?php
function dashboard_widget_function( $post, $callback_args ) {
    echo '<p style="font-weight: bold; color: red;">Mọi hỗ trợ về kỹ thuật bạn vui lòng liên hệ qua:</p>';
    echo '<p>- Facebook: https://www.facebook.com/hoanganit</p>';
    echo '<p>- Skype: friendntt10</p>';
    echo '<p>- Điện thoại: 01688875179</p>';
    echo '<p>- Email: hoangan.web@gmail.com hoặc hoanganit19@gmail.com</p>';
}

// Function used in the action hook
function add_dashboard_widgets() {
    wp_add_dashboard_widget('dashboard_widget', 'Hỗ trợ kỹ thuật', 'dashboard_widget_function');
}

// Register the new dashboard widget with the 'wp_dashboard_setup' action
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );

add_action('admin_head', 'my_custom_style_admin');

function my_custom_style_admin() {
    ?>
    <link type="text/css" rel="stylesheet" href="<?php echo __THEME_HOST; ?>/pveser-framework/assets/css/admin-style.css"/>
    <?php
}

function pveser_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'pveser_login_logo_url' );

function pveser_login_logo_url_title() {
    return __WEB_TITLE.' - '.__WEB_SLOGAN;
}
add_filter( 'login_headertitle', 'pveser_login_logo_url_title' );
?>
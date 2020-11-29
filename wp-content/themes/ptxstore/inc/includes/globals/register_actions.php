<?php
function header_default()
{
    ?>
    <?php global $theme_options; ?>
    <!DOCTYPE html <?php language_attributes(); ?>>
    <html>
    <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(''); ?></title>
    <?php if (!empty($theme_options['favicon']['url'])): ?>
    <link rel="icon" href="<?php echo $theme_options['favicon']['url']; ?>" type="image/x-icon" />
    <?php endif; ?>
    <?php wp_head(); ?>
    <?php echo get_field('header_code', 'option') ?>
    <script>
        var mainUrl = '<?php echo get_bloginfo("url") ?>';
        var currency = '<?php echo get_option('woocommerce_currency') ?>';
    </script>
    </head>
    <?php
}
add_action('pveser_header', 'header_default', 10);


function footer_default()
{
    global $theme_options;
    wp_footer(); ?>
    </body>
    </html>
    <?php
}

add_action('pveser_footer', 'footer_default', 10);
?>
<?php
function rc_woocommerce_recently_viewed_products( $atts, $content = null ) {

    // Get shortcode parameters
    extract(shortcode_atts(array(
        "per_page" => '3'
    ), $atts));

    // Get WooCommerce Global
    global $woocommerce;

    // Get recently viewed product cookies data
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

    // If no data, quit
    if ( empty( $viewed_products ) )
    {
        return __( '<p class="text-center">Bạn chưa xem sản phẩm nào</p>', 'rc_wc_rvp' );
    }


    // Create the object
    ob_start();

    // Get products per page
    if( !isset( $per_page ) ? $number = 3 : $number = $per_page )

        // Create query arguments array
        $query_args = array(
            'posts_per_page' => $number,
            'no_found_rows'  => 1,
            'post_status'    => 'publish',
            'post_type'      => 'product',
            'post__in'       => $viewed_products,
            'orderby'        => 'rand'
        );

    // Add meta_query to query args
    $query_args['meta_query'] = array();

    // Check products stock status
    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();

    // Create a new query
    $r = new WP_Query($query_args);

    // If query return results
    if ( $r->have_posts() ) {

        $content = '<p class="text-center">Đã xem</p>';

        // Start the loop
        while ( $r->have_posts()) {
            $r->the_post();
            global $product;

            $content .= '
				<a href="' . get_permalink() . '">
					' . ( has_post_thumbnail() ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail',array('class'=>'img-responsive') ) : woocommerce_placeholder_img( 'shop_thumbnail' ) ) . '
				</a>';
        }

        $content .= '';

    }

    // Get clean object
    $content .= ob_get_clean();

    // Return whole content
    return $content;
}

// Register the shortcode
add_shortcode("woocommerce_recently_viewed_products", "rc_woocommerce_recently_viewed_products");

function create_shortcode_year()
{
    return date("Y");
}

add_shortcode('year', 'create_shortcode_year');

function create_shortcode_blogname()
{
    return __WEB_TITLE;
}

add_shortcode('site_name', 'create_shortcode_blogname');

function inline_related_post()
{
    global $post;
    $orig_post = $post;
    $tags = wp_get_post_tags($post->ID);
    $content = "";
    ob_start();
    if ($tags) {
        $tag_ids = array();
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        $args=array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page'=>5,
        );
        $my_query = new wp_query( $args );

        if( $my_query->have_posts() ) {
            echo '<ul class="inline-related">';
            while( $my_query->have_posts())
            {
                $my_query->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><i class="fa fa-arrow-circle-right"></i> <?php the_title(); ?></a>
                </li>
            <?php }
            echo '</ul>';
        }

    }

    $content = ob_get_contents();
    ob_end_clean();

    $post = $orig_post;
    wp_reset_query();

    return $content;
}

add_shortcode('related', 'inline_related_post');

//add_action('init', 'wpse72394_shortcode_button_init');

function wpse72394_shortcode_button_init() {

    //Abort early if the user will never see TinyMCE
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
        return;

    //Add a callback to regiser our tinymce plugin
    add_filter("mce_external_plugins", "wpse72394_register_tinymce_plugin");

    // Add a callback to add our button to the TinyMCE toolbar
    add_filter('mce_buttons', 'wpse72394_add_tinymce_button');
}


//This callback registers our plug-in
function wpse72394_register_tinymce_plugin($plugin_array) {
    $plugin_array['wpse72394_button'] = __THEME_HOST.'/shortcodes/js/shortcode.js';
    return $plugin_array;
}

//This callback adds our button to the toolbar
function wpse72394_add_tinymce_button($buttons) {
    //Add the button ID to the $button array
    $buttons[] = "wpse72394_button";
    return $buttons;
}
?>
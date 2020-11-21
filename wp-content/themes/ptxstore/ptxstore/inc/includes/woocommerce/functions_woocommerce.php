<?php
//add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );

function child_manage_woocommerce_styles()
{

    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

    //first check that woo exists to prevent fatal errors
    if ( function_exists( 'is_woocommerce' ) )
    {
        //dequeue scripts and styles
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && !is_home() && is_product_category() && is_product_tag())
        {
            wp_dequeue_style( 'woocommerce_frontend_styles' );
            wp_dequeue_style( 'woocommerce_fancybox_styles' );
            wp_dequeue_style( 'woocommerce_chosen_styles' );
            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
            wp_dequeue_script( 'wc_price_slider' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-add-to-cart' );
            wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'wc-checkout' );
            wp_dequeue_script( 'wc-add-to-cart-variation' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-cart' );
            wp_dequeue_script( 'wc-chosen' );
            wp_dequeue_script( 'woocommerce' );
            wp_dequeue_script( 'prettyPhoto' );
            wp_dequeue_script( 'prettyPhoto-init' );
            wp_dequeue_script( 'jquery-blockui' );
            wp_dequeue_script( 'jquery-placeholder' );
            wp_dequeue_script( 'fancybox' );
            wp_dequeue_script( 'jqueryui' );
        }
    }
}

add_action('woocommerce_before_main_content', 'pveser_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'pveser_theme_wrapper_end', 10);

function pveser_theme_wrapper_start() {
    echo '';
}

function pveser_theme_wrapper_end() {
    echo '';
}

//remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper');

function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_company']);
    $fields['billing']['billing_last_name'] = array(
        'label' => __('Họ và tên', 'devvn'),
        'placeholder' => _x('Nhập đầy đủ họ và tên của bạn', 'placeholder', 'devvn'),
        'required' => true,
        'class' => array('form-row-wide'),
        'clear' => true
    );
    unset($fields['billing']['billing_first_name']);

    return $fields;
}

function pveser_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => '',
        'wrap_before' => '<i class="fa fa-home" aria-hidden="true"></i> ',
        'wrap_after'  => '',
        'before'      => '<li>',
        'after'       => '</li>',
        'home'        => 'Trang chủ',
    );
}

add_filter( 'woocommerce_breadcrumb_defaults', 'my_woocommerce_breadcrumbs' );

//add_filter ( 'woocommerce_product_thumbnails_columns', 'xx_thumb_cols' );
function xx_thumb_cols() {
    return 5;
}

//add_filter( 'woocommerce_product_description_heading', 'remove_product_description_heading' );
function remove_product_description_heading() {
    return '';
}

add_filter( 'woocommerce_currencies', 'add_my_currency' );

function add_my_currency( $currencies ) {
    $currencies['VNĐ'] = __( 'Vietnam Dong', 'woocommerce' );
    return $currencies;
}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);

function add_my_currency_symbol( $currency_symbol, $currency ) {
    switch( $currency ) {
        case 'VNĐ': $currency_symbol = 'VNĐ'; break;
    }
    return $currency_symbol;
}

function isa_woocommerce_all_pa(){

    global $product;

    $attributes = $product->get_attributes();
    if ( ! $attributes ) {
        return;
    }

    $out = '';

    foreach ( $attributes as $attribute ) {

        // skip variations
        if ( $attribute['is_variation'] ) {
            continue;
        }

        if ( $attribute['is_taxonomy'] ) {

            $terms = wp_get_post_terms( $product->get_id(), $attribute['name'], 'all' );
            // get the taxonomy
            $tax = $terms[0]->taxonomy;
            // get the tax object
            $tax_object = get_taxonomy($tax);
            // get tax label
            if ( isset ($tax_object->labels->singular_name) ) {
                $tax_label = $tax_object->labels->singular_name;
            } elseif ( isset( $tax_object->label ) ) {
                $tax_label = $tax_object->label;
                // Trim label prefix since WC 3.0
                if ( 0 === strpos( $tax_label, 'Product ' ) ) {
                    $tax_label = substr( $tax_label, 8 );
                }
            }

            foreach ( $terms as $term ) {

                $out .= '<p>'.$tax_label . ': ';
                $out .= $term->name . '</p>';

            }

        } else {
            $out .= '<p>'.$attribute['name'] . ': ';
            $out .= $attribute['value'] . '</p>';
        }
    }
    echo $out;
}

function woo_related_products_limit() {
    global $product;

    $args['posts_per_page'] = 8;
    return $args;
}
//add_filter( 'woocommerce_output_related_products_args', 'woo_related_products_limit' );

function pveser_related_product($number, $title='Sản phẩm liên quan')
{
    global $post;

    $custom_taxterms = wp_get_object_terms( $post->ID, 'product_cat', array('fields' => 'ids') );

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $number, // you may edit this number
        'orderby' => 'date',
        'order'=>'DESC',
        'post__not_in' => array ( $post->ID ),
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $custom_taxterms,
                'operator' => 'IN'
            )
        )
    );

    $related_query = new WP_Query($args);
    if ($related_query->have_posts()):
        ?>
        <div class="related-posts">

            <h3 style="margin-bottom: 20px;" class="underline-title text-uppercase"><?php echo $title; ?></h3>

            <div class="row">
                <?php
                $count=0;
                while ($related_query->have_posts()):
                    $related_query->the_post();
                    $price = get_post_meta( get_the_ID(), '_regular_price', true);
                    $sale = get_post_meta( get_the_ID(), '_sale_price', true);
                    $currency = get_woocommerce_currency_symbol();
                    $count++;
                    $sale_off = '';
                    if ($sale)
                    {
                        $sale_off = round(($price - $sale)*100/$price);
                    }
                    ?>
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="product-item">
                            <?php echo ($sale_off)?'<div class="saleoff"><span>'.$sale_off.'%</span></div>':FALSE; ?>
                            <div class="label_prod">
                                <?php echo (get_post_meta(get_the_ID(), '_featured', true)=='yes')?'<span class="hot">Hot</span>':FALSE; ?>
                                <?php echo ($sale)?'<span class="sale">Sale</span>':FALSE; ?>
                            </div>
                            <p><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php if (has_post_thumbnail()) the_post_thumbnail('shop_catalog', array('class'=>'img-responsive')); ?></a></p>
                            <figcaption>
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="product-price">
                                    <?php
                                    if ($sale):
                                        ?>
                                        <span class="old"><?php echo number_format($price, 0, '', '.')." "; echo $currency; ?></span>
                                        <span><?php echo number_format($sale, 0, '', '.')." "; echo $currency; ?></span>
                                    <?php else: ?>
                                        <span><?php echo number_format($price, 0, '', '.')." "; echo $currency; ?></span>
                                    <?php endif; ?>
                                </div>
                            </figcaption>
                        </div>
                    </div>
                    <?php
                    echo ($count%4==0)?'<div class="clearfix visible-lg visible-md"></div>':FALSE;
                    echo ($count%2==0)?'<div class="clearfix visible-xs visible-sm"></div>':FALSE;
                endwhile;
                ?>

            </div></div>
        <?php
    endif;
}

//add_action('woocommerce_after_single_product_summary', 'pveser_related_product', 12);
?>
<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;
global $wooextension;
?>
<div class="ptx-cart-page">
    <div class="container custom-container" style="margin-top: 50px">
        <?php
        do_action( 'woocommerce_before_cart' ); ?>

        <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <?php do_action( 'woocommerce_before_cart_table' ); ?>

            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail">&nbsp;</th>
                        <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                        <th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
                        <th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
                        <th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                    <?php
                    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                            ?>
                            <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                                <td class="product-remove">
                                    <?php
                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                esc_html__( 'Remove this item', 'woocommerce' ),
                                                esc_attr( $product_id ),
                                                esc_attr( $_product->get_sku() )
                                            ),
                                            $cart_item_key
                                        );
                                    ?>
                                </td>

                                <td class="product-thumbnail">
                                <?php
                                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                                if ( ! $product_permalink ) {
                                    echo $thumbnail; // PHPCS: XSS ok.
                                } else {
                                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                }
                                ?>
                                </td>

                                <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                                <?php
                                if ( ! $product_permalink ) {
                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                } else {
                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                }

                                do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                // Meta data.
                                echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                                // Backorder notification.
                                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                                }
                                ?>
                                </td>

                                <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                    <?php
                                        echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                    ?>
                                </td>

                                <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                                <?php
                                if ( $_product->is_sold_individually() ) {
                                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                } else {
                                    $product_quantity = woocommerce_quantity_input(
                                        array(
                                            'input_name'   => "cart[{$cart_item_key}][qty]",
                                            'input_value'  => $cart_item['quantity'],
                                            'max_value'    => $_product->get_max_purchase_quantity(),
                                            'min_value'    => '0',
                                            'product_name' => $_product->get_name(),
                                        ),
                                        $_product,
                                        false
                                    );
                                }

                                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                ?>
                                </td>

                                <td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
                                    <?php
                                        echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                    <?php do_action( 'woocommerce_cart_contents' ); ?>

                    <tr>
                        <td colspan="6" class="actions">

                            <?php if ( wc_coupons_enabled() ) { ?>
                                <div class="coupon">
                                    <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
                                    <?php do_action( 'woocommerce_cart_coupon' ); ?>
                                </div>
                            <?php } ?>

                            <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

                            <?php do_action( 'woocommerce_cart_actions' ); ?>

                            <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                        </td>
                    </tr>

                    <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                </tbody>
            </table>
            <?php do_action( 'woocommerce_after_cart_table' ); ?>
        </form>

        <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

        <div class="cart-collaterals" style="padding: 15px">
            <?php
                $cartItem = WC()->cart->get_cart();
                if(!empty($cartItem)):
                    $cartItem = end($cartItem);
                    $productClass = get_the_terms($cartItem['product_id'], 'ptx_product_class');
                    $productClass = $productClass[0];
                    $productClassData =  [];
                    $query = new WP_Query(['post_type' => 'product' , 'post_status' => 'publish', 'posts_per_page' => -1, 'post__not_in' => array($cartItem['product_id']),'tax_query' => [ ['taxonomy' => 'ptx_product_class' , 'field' => 'term_id' , 'terms' => $productClass->term_id] ] ]);
                    if($query->have_posts()) {
                        while ($query->have_posts()){
                            $query->the_post();
                            $productClassData[] = get_the_ID();
                        }
                        wp_reset_query();
                    }
                    if(!empty($productClassData)):
                    $productUpsell = $productClassData[0];
                    $getProduct = wc_get_product($productUpsell);
            ?>
                        <div class="cart-upsell-product">
                            <div class="upsell-product-title" style="display: flex">
                                <strong style="font-size: 21px; font-weight: bold;">
                                    You May Also Like
                                </strong>
                                <div class="ptx-time-count-down" style="display: flex; align-items: center; margin-left: 0.5rem">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/alarm.png">
                                    <span id="time" style="margin-left: 5px">05:00</span> &nbsp; left to buy
                                </div>
                            </div>
                            <div class="upsell-product-main">
                                <div class="upsell-product-image">
                                    <img src="<?php echo get_the_post_thumbnail_url($productUpsell) ?>" alt="upsell prouduct">
                                </div>
                                <div class="cart-upsell-product-content">
                                    <div class="cart-upsell-product-title">
                                        <h3>
                                            <?php echo get_the_title($productUpsell) ?>
                                        </h3>
                                    </div>
                                    <div class="upsell-product-price product-price">
                                        <?php echo $getProduct->get_price_html() ?>
                                    </div>
                                    <div class="btn-add-cart" style="margin: 0px">
                                        <?php
                                        $dataProduct = ($getProduct->is_type( 'variable' )) ? $wooextension->genDataProductClass($getProduct->get_id()) : false ;
                                        ?>
                                        <button class="btn btn-primary fw-bold" data-product='<?php echo $dataProduct ?>' data-id="<?php echo $getProduct->get_id() ?>" <?php if(!($getProduct->is_type( 'variable' ))): ?> data-addcart="<?php echo wc_get_cart_url() . "?add-to-cart=". $getProduct->get_id() ?>" <?php endif; ?>>Add to cart</button>
                                    </div>
                                </div>

                            </div>
                        </div>
            <?php
                endif; endif;
                /**
                 * Cart collaterals hook.
                 *
                 * @hooked woocommerce_cross_sell_display
                 * @hooked woocommerce_cart_totals - 10
                 */
                do_action( 'woocommerce_cart_collaterals' );
            ?>
        </div>

        <?php do_action( 'woocommerce_after_cart' ); ?>

        <?php
            $loadTerms = $wooextension->cartGetTermRelation();
            if($loadTerms && !empty($loadTerms)):
        ?>
            <div class="cart-more-product">
                <?php
                    foreach ($loadTerms as $termRela):
                        $getTerm = get_term_by('id', $termRela , 'product_cat', OBJECT , 'raw');
                    ?>
                    <div class="recommend-wrapper">

                        <div class="recommend-heading">
                            <h2 class="fs-lg fw-bold">More From <a href="<?php echo get_term_link($termRela , 'product_cat') ?>"> <?php echo $getTerm->name ?> </a></h2>
                        </div>
                        <?php
                            $query = new WP_Query(['post_type' => 'product' , 'post_status' => 'publish', 'posts_per_page' => 3, 'tax_query' => [ ['taxonomy' => 'product_cat' , 'field' => 'term_id' , 'terms' => $termRela] ] ]);
                            if($query->have_posts()):
                        ?>
                        <div class="recommend-content">
                            <div class="row">
                            <?php while ($query->have_posts()) {
                                $query->the_post();
                                wc_get_template_part( 'content', 'product' );
                            } ?>
                            </div>
                        </div>
                        <?php endif; wp_reset_query(); ?>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <?php
        $recommendedProduct = $wooextension->renderRecommendeQuery();
        if($recommendedProduct->have_posts()): ?>
            <div class="recommend-wrapper">

                <div class="recommend-heading">
                    <h2 class="fs-lg fw-bold">Recommended For You</h2>
                </div>

                <div class="recommend-content">
                    <div class="row">
                        <?php while ($recommendedProduct->have_posts()) {
                            $recommendedProduct->the_post();
                            wc_get_template_part( 'content', 'product' );
                        } ?>
                    </div>
                </div>

            </div>
        <?php endif; wp_reset_query(); ?>

    </div>
    <?php wc_get_template_part( 'content', 'popup-add-cart' ); ?>
</div>
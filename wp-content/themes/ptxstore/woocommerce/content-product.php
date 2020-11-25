<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
	<?php
//	/**
//	 * Hook: woocommerce_before_shop_loop_item.
//	 *
//	 * @hooked woocommerce_template_loop_product_link_open - 10
//	 */
//	do_action( 'woocommerce_before_shop_loop_item' );
//
//	/**
//	 * Hook: woocommerce_before_shop_loop_item_title.
//	 *
//	 * @hooked woocommerce_show_product_loop_sale_flash - 10
//	 * @hooked woocommerce_template_loop_product_thumbnail - 10
//	 */
//	do_action( 'woocommerce_before_shop_loop_item_title' );
//
//	/**
//	 * Hook: woocommerce_shop_loop_item_title.
//	 *
//	 * @hooked woocommerce_template_loop_product_title - 10
//	 */
//	do_action( 'woocommerce_shop_loop_item_title' );
//
//	/**
//	 * Hook: woocommerce_after_shop_loop_item_title.
//	 *
//	 * @hooked woocommerce_template_loop_rating - 5
//	 * @hooked woocommerce_template_loop_price - 10
//	 */
//	do_action( 'woocommerce_after_shop_loop_item_title' );
//
//	/**
//	 * Hook: woocommerce_after_shop_loop_item.
//	 *
//	 * @hooked woocommerce_template_loop_product_link_close - 5
//	 * @hooked woocommerce_template_loop_add_to_cart - 10
//	 */
//	do_action( 'woocommerce_after_shop_loop_item' );
	?>

<div class="products col-lg-4 col-xl-4 col-6 col-mobile">
    <div class="item-wrapper">
        <a href="<?php echo get_permalink($product->get_id()) ?>">
            <div class="item-thumb">
                <?php
                $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );
                echo $product ? $product->get_image( $image_size ) : '';
                ?>
            </div>
            <div class="item-content">
                <div class="item-title">
                        <?php do_action( 'woocommerce_shop_loop_item_title' ); ?>
                    </h3>
                </div>
                <div class="item-attribute">
                    <div class="item-price">
                            <?php
                            if($product->is_type( 'variable' )) {
                                $variableProductId = $product->get_available_variations()[0]['variation_id'];
                                $variableProduct = new WC_Product_Variation($variableProductId);
                                $regularPrice = $variableProduct->get_regular_price();
                                $salePrice = $variableProduct->get_sale_price();
                            }else{
                                $regularPrice = $product->get_regular_price();
                                $salePrice = $product->get_sale_price();
                            }
                            if(isset($salePrice) && !empty($salePrice)):
                                ?>
                                <span class="price fs-md"><?php echo get_woocommerce_currency_symbol() . $salePrice ?></span>
                                <span class="small-price fs-xs "><?php echo get_woocommerce_currency_symbol() . $regularPrice ?></span>
                            <?php else: ?>
                                <span class="price fs-md"><?php echo get_woocommerce_currency_symbol() . $regularPrice ?></span>
                            <?php endif; ?>
                    </div>
                    <div class="item-colors">
                        <span class="fs-xs">
                            <?php
                            $color = wc_get_product_terms( $product->get_id(), 'pa_color' );
                            if(count($color) > 0) {
                                echo count($color) . " color";
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </a>
        <div class="btn-add-cart">
            <?php
                global $wooextension;
                $dataProduct = ($product->is_type( 'variable' )) ? $wooextension->genDataProductClass($product->get_id()) : false ;
            ?>
            <button class="btn btn-primary fw-bold" data-product='<?php echo $dataProduct ?>' data-id="<?php echo $product->get_id() ?>" <?php if(!($product->is_type( 'variable' ))): ?> data-addcart="<?php echo wc_get_cart_url() . "?add-to-cart=". $product->get_id() ?>" <?php endif; ?>>Add to cart</button>
        </div>
    </div>
</div>

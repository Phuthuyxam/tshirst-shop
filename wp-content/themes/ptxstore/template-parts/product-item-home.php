<?php
$product = wc_get_product( $product_id );
?>
<div class="item-wrapper">
    <a href="<?php echo get_permalink($product_id) ?>">
        <div class="item-thumb">
            <?php
                $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );
                echo $product ? $product->get_image( $image_size ) : '';
            ?>
        </div>
        <div class="item-content">
            <div class="item-title">
                <h3 class="fs-sm"><?php echo get_the_title($product_id) ?></h3>
            </div>

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

                <span style="margin-left: auto; color: #636e72;">
                    <?php
                        $color = wc_get_product_terms( $product_id, 'pa_color' );
                        if(count($color) > 0) {
                            echo count($color) . " color";
                        }
                    ?>
                </span>
            </div>

        </div>
    </a>
</div>

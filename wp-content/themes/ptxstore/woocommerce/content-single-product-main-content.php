<?php
    global $product;
    $product_attributes = $product->get_attributes();
    $class = get_the_terms(get_the_ID(), 'ptx_product_class')[0];
    $query = new WP_Query(['post_type' => 'product' , 'post_status' => 'publish', 'posts_per_page' => -1, 'post__not_in' => array( get_the_ID() ),'tax_query' => [ ['taxonomy' => 'ptx_product_class' , 'field' => 'term_id' , 'terms' => $class->term_id] ] ]);
    $productClassData = [];
    if($query->have_posts()) {
        while ($query->have_posts()){
            $query->the_post();
            $productClassData[] = get_the_ID();
        }
    }
    wp_reset_query();
    $firstVariation = false;
    if($product->product_type=='variable') {
        $variations = $product->get_available_variations();

        if(isset($variations) && !empty($variations)){
            $firstVariation = $variations[0]['attributes'];
            $firstVariation['variation_id'] = $variations[0]['variation_id'];
        }

    }
?>
<div class="col-xl-4 col-lg-4 col-12 col-mobile">
    <div class="product-detail">
        <div class="product-title">
            <span class="fs-md title">
                <?php the_title() ?>
            </span>
            <br>
            <?php

                if(isset($class) && !empty($class)):
            ?>
                    <span class="fs-md type">
                        <?php echo $class->name ?>
                    </span>
            <?php endif; ?>
        </div>
        <div class="product-price" id="ptx-single-price">
            <span class="price fs-xl fw-bold">
                <?php echo $product->get_price_html(); ?>
            </span>
        </div>

        <?php wc_get_template_part( 'content', 'single-product-slider-mobile' ); ?>

        <div class="products-list">
            <div class="product-list-title">
                <span class="fw-bold">Product:</span>
            </div>
            <div class="products-select">
                <div class="products-select-overlay"></div>
                <div class="product-name">
                    <span><?php echo get_the_title() ?> - <?php echo $product->get_display_price() . get_woocommerce_currency_symbol() ?> </span>
                </div>
                <i class="fa fa-angle-down fs-md " aria-hidden="true"></i>
            </div>
            <div class="product-options">
                <ul>
                    <li class="active">
                        <span><?php echo get_the_title() ?> - <?php echo $product->get_price() . get_woocommerce_currency_symbol() ?></span>
                        <i class="fa fa-check check-icon" aria-hidden="true"></i>
                    </li>
                    <?php
                        if(isset($productClassData) && !empty($productClassData)):
                            foreach ($productClassData as $pro):
                                $currentProduct = new WC_Product($pro);
                    ?>
                            <li>
                                <span>
                                    <a href="<?php echo get_the_permalink($pro) ?>" style="color: #333333">
                                        <?php echo get_the_title($pro) ?> - <?php echo $currentProduct->get_price() . get_woocommerce_currency_symbol() ?>
                                    </a>
                                </span>
                                <i class="fa fa-check check-icon" aria-hidden="true"></i>
                            </li>
                    <?php endforeach; endif; ?>
                </ul>
            </div>
        </div>

        <div class="product-types-list">
            <?php
            if(isset($productClassData) && !empty($productClassData)):
            ?>
            <ul>
                <?php
                foreach ($productClassData as $pro):
                ?>
                    <li class="type-image-wrapper active" data-name="Classic T-Shirt">
                        <a href="<?php echo get_the_permalink($pro) ?>">
                            <div class="type-image">
                                <img src="<?php echo get_the_post_thumbnail_url($pro) ?>" alt="<?php echo get_the_title() ?>">
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>


        <div id="section-add-cart">
            <?php
                if(isset($product_attributes['pa_size']) && !empty($product_attributes['pa_size'])):
                    $sizeAttr = $product_attributes['pa_size']->get_data();

            ?>
                    <div class="product-size-select" id="ptx-product-size-select">
                        <div class="product-size-title">
                            <span class="fw-bold label">Size: </span>
                            <span class="fw-bold placeholder">Select a Size</span>
                            <span class="size"></span>
                        </div>
                        <ul>
                            <?php
                                if($firstVariation['attribute_pa_size'] == "") {
                                    $firstTerm = get_term_by('id' , $sizeAttr['options'][0], $sizeAttr['name'], OBJECT, 'raw');
                                    $activeItem = $firstTerm->slug;
                                }else{
                                    $activeItem = $firstVariation["attribute_pa_size"];
                                }
                                foreach ($sizeAttr['options'] as $size):
                                    $term = get_term_by('id' , $size, $sizeAttr['name'], OBJECT, 'raw');
                            ?>
                                <li class="fw-bold <?php echo ( $activeItem == $term->slug ) ? 'active' : false ?>" data-size="<?php echo $term->slug ?>"><?php echo $term->name ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
            <?php endif; ?>

            <?php
            if(isset($product_attributes['pa_color']) && !empty($product_attributes['pa_color'])):
                $colorAttr = $product_attributes['pa_color']->get_data();
                $termFirst = get_term_by('id' , $colorAttr['options'][0] , $colorAttr['name'], OBJECT, 'raw');
            ?>
            <div class="product-color-select" id="ptx-product-color-select">
                <div class="product-color-title">
                    <span class="fw-bold label">Color: </span>
                    <span class="color"><?php echo $termFirst->name ?></span>
                </div>
                <ul>
                    <?php
                    if($firstVariation['attribute_pa_color'] == "") {
                        $activeItemColor = $termFirst->slug;
                    }else{
                        $activeItemColor = $firstVariation["attribute_pa_color"];
                    }
                    foreach ($colorAttr['options'] as $key => $color):
                        $term = get_term_by('id' , $color, $colorAttr['name'], OBJECT, 'raw');
                        $bgColor = get_field('color_hex', 'pa_color_'.$term->term_id);
                        ?>
                        <li class="fw-bold <?php if($term->slug == $activeItemColor) echo 'active' ?>" data-name="<?php echo $term->name ?>" data-color="<?php echo $term->slug ?>">
                            <div class="color-circle">
                                <div class="circle" style="background-color: <?php echo $bgColor ?>;"></div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php endif; ?>
            <div class="products-quantity-select" id="ptx-product-quantity-select">
                <div class="product-quantity-title">
                    <span class="fw-bold">Qty: </span>
                    <span class="fw-bold quantity">1</span>
                </div>

                <div class="products-select quantity-select">
                    <div class="products-quantity-select-overlay"></div>
                    <div class="product-name">
                        <span class="quantity" id="ptx-quantity">1</span>
                    </div>
                    <i class="fa fa-angle-down fs-md " aria-hidden="true"></i>
                </div>


                <div class="quantity-options" id="ptx-quantity-options">
                    <ul>
                        <?php foreach (range(1 , 10) as $number): ?>
                            <li class="<?php if($number == 1) echo 'active' ?>" data-value="<?php echo $number ?>"><?php echo $number ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <?php if($product->product_type=='variable'): ?>
                <div class="product-add-to-cart" id="ptx-single-product-add-cart">
                <?php
                    if(isset($product_attributes['pa_size']) && !empty($product_attributes['pa_size'])) {
                        $sizeAttr = $product_attributes['pa_size']->get_data();
                        if ($firstVariation['attribute_pa_size'] == "") {
                            $firstTerm = get_term_by('id', $sizeAttr['options'][0], $sizeAttr['name'], OBJECT, 'raw');
                            $activeItem = $firstTerm->slug;
                        } else {
                            $activeItem = $firstVariation["attribute_pa_size"];
                        }
                        ?>
                        <input type="hidden" id="ptx-single-size" value="<?php echo $activeItem ?>">
                <?php
                    }
                    if(isset($product_attributes['pa_color']) && !empty($product_attributes['pa_color'])) {
                        $colorAttr = $product_attributes['pa_color']->get_data();
                        $termFirst = get_term_by('id' , $colorAttr['options'][0] , $colorAttr['name'], OBJECT, 'raw');
                        if($firstVariation['attribute_pa_color'] == "") {
                            $firstTerm = get_term_by('id' , $colorAttr['options'][0], $colorAttr['name'], OBJECT, 'raw');
                            $activeItemColor = $firstTerm->slug;
                        }else{
                            $activeItemColor = $firstVariation["attribute_pa_color"];
                        }
                        ?>
                        <input type="hidden" id="ptx-single-color" value="<?php echo $activeItemColor ?>">
                <?php
                    }
                ?>



                <input type="hidden" id="ptx-single-variation" value="<?php echo $firstVariation['variation_id'] ?>">

                <input type="hidden" id="ptx-single-productid" value="<?php echo get_the_ID() ?>">
                <input type="hidden" id="ptx-single-quantity" value="1">
                <input type="hidden" id="ptx-single-avatar" value="<?php echo get_the_post_thumbnail_url() ?>">
                <button class="btn fw-bold" id="ptx-single-add-cart" data-product='<?php echo json_encode($product->get_available_variations()) ?>'>Add to cart</button>
            </div>
            <?php else: ?>
                <div class="product-add-to-cart">
                    <input type="hidden" name="add-to-cart" id="add-to-cart" value="<?php echo get_the_ID() ?>">
                    <input type="hidden" id="ptx-single-quantity" value="1">
                    <button class="btn fw-bold" id="ptx-simple-add-cart" data-addcart="<?php echo wc_get_cart_url() ?>">Add to cart</button>
                </div>
            <?php endif; ?>

        </div>

        <?php
            global $wooextension;
            $relaproduct = $wooextension->getRelateProduct();
            if($relaproduct->have_posts()):
        ?>
                <div class="relate-mobile d-xl-none d-lg-none d-sm-block d-xs-block relate-wrapper">

                    <div class="relate-products-wrapper">
                        <div class="heading">
                            <span class="fw-bold fs-lg">Related products</span>
                        </div>

                        <div class="content">
                            <div class="row row-mobile">
                                <?php
                                    while ($relaproduct->have_posts()){
                                        $relaproduct->the_post();
                                        wc_get_template_part( 'content', 'product' );
                                    }
                                ?>
                            </div>
                        </div>


                    </div>
                </div>
        <?php endif; wp_reset_query(); ?>

        <div class="campaign-wrapper" style="margin-top: 2rem;">
            <h5 class="fw-bold fs-lg py-3">Campaign Details</h5>
            <div class="content">
                <?php echo get_field('campaign_details', 'option') ?>
            </div>
        </div>
        <div class="campaign-wrapper">
            <h5 class="fw-bold fs-lg py-3">Product Details</h5>
            <div class="content">

                <?php the_content(); ?>

            </div>
        </div>
        <div class="campaign-wrapper">
            <h5 class="fw-bold fs-lg py-3">Shipping Info</h5>
            <div class="content">
                <?php echo get_field('shipping_info', 'option') ?>
            </div>
        </div>

        <?php
            $tags = get_the_terms( get_the_ID(), 'product_tag' );
            if(isset($tags) && !empty($tags)):
        ?>
                <div class="campaign-wrapper tags-wrapper">
                    <h5 class="fw-bold fs-lg py-3">Tags</h5>
                    <div class="content tag-content">
                        <ul>
                            <?php foreach ($tags as $tag): ?>
                                <li class="py-2 px-3">
                                    <a href="<?php echo get_term_link($tag->term_id , 'product_tag') ?>">
                                        <span class="fw-bold fs-sm"><?php echo $tag->name ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
        <?php endif; ?>

        <div class="campaign-wrapper share-campaign py-4">
            <h5>Share campaign</h5>
            <a class="btn btn-share"><i class="fa fa-facebook-square" aria-hidden="true"></i> Share</a>
        </div>
    </div>
</div>

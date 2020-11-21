<div class="products-wrapper type2" style="background-image: url(<?php echo $productData['add_banner'] ?>);">
    <div class="row">
        <div class="col-12">
            <a href="<?php echo $productData['link_banner'] ?>">
                <div class="product-banner-wrapper">
                    <img src="<?php echo $productData['add_banner'] ?>" class="d-sm-none d-lg-block d-xl-block d-none" alt="banner home top">
                    <div class="product-banner-title">
                        <div class="product-banner-text">
                            <h2 class="fs-3xl fw-extraBold"><?php echo $productData['banner_title'] ?></h2>
                            <h3 class="fs-lg"><?php echo $productData['banner_desc'] ?></h3>
                            <h4 class="fs-lg fw-bold">SHOP NOW <i class="fa fa-angle-right" aria-hidden="true"></i></h4>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12">
            <div class="list-product-wrapper">
                <div class="row">
                    <?php
                    $allProduct = [];
                    if($productData['product_type_display'] == 'product_cat'){
                        $query = new WP_Query(
                            [
                                'post_type' => 'product',
                                'post_status' => 'publish',
                                'posts_per_page' => 4,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field'    => 'term_id',
                                        'terms'    => $productData['product_type_category'][0],
                                    ),
                                ),
                            ]
                        );
                        if($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                $allProduct[] = get_the_ID();
                            }
                        }
                        wp_reset_query();
                    }

                    if( $productData['product_type_display'] == 'product') {
                        $allProduct = $productData['product_type_product'];
                    }
                    ?>
                    <?php foreach($allProduct as $pro): ?>
                        <div class="col-3 custom-col">
                            <?php
                            set_query_var( 'product_id', $pro );
                            get_template_part('template-parts/product-item' , 'home');
                            ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="d-lg-none col-3 custom-col" style="min-width: 165px;">
                        <div class="item-wrapper" style="height: calc(100% - 15px);">
                            <a href="<?php echo $productData['link_banner'] ?>" style="height: 100%; display: flex;align-items: center;justify-content: center;">
                                <h4 class="fs-lg fw-extraBold">SHOP NOW</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

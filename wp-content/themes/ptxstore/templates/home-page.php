<?php /* Template Name: Home page  */
    get_header();
    global $wooextension;
    $bannerHome = get_field('add_banner', 'option');
    $topCategory = get_field('top_cate_home', 'option');
    $productHome = get_field('product_home', 'option');
    $recommendedProduct = $wooextension->renderRecommendedProduct();
?>
<div class="main-wrapper">
    <div class="container custom-container">

        <?php if(isset($bannerHome) && !empty($bannerHome)): ?>
            <div class="banner-wrapper">
                <img src="<?php echo $bannerHome ?>" alt="Home banner " >
            </div>
        <?php endif; ?>

        <?php if(isset($recommendedProduct) && !empty($recommendedProduct)): ?>
            <div class="recommend-wrapper">

                <div class="recommend-heading">
                    <h2 class="fs-lg fw-bold">Recommended For You</h2>
                </div>

                <div class="recommend-content">
                    <div class="row">
                        <?php foreach ($recommendedProduct as $product) : ?>
                        <div class="col-xl-3 col-lg-3 col-sm-3 col-2/3">
                            <?php
                                set_query_var( 'product_id', $product );
                                get_template_part('template-parts/product-item' , 'home');
                            ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        <?php endif; ?>
        <?php if(isset($topCategory) && !empty($topCategory)): ?>
            <div class="top-categories-wrapper">
                <div class="top-categories-heading">
                    <h2 class="fs-lg fw-bold">Shop Top Categories</h2>
                </div>
                <div class="top-categories-content">
                    <div class="row">
                        <?php foreach ($topCategory as $cate):
                            $term = get_term_by('id', $cate, 'product_cat', OBJECT, 'raw');
                            $thumbnail_id = get_woocommerce_term_meta( $cate, 'thumbnail_id', true );
                            // get the image URL
                            $image = wp_get_attachment_url( $thumbnail_id );
                            if(!$image) $image = __THEME_HOST ."/assets/images/woocommerce-placeholder-150x150.png";
                            ?>
                            <div class="col-lg-2 col-xl-2 col-sm-3 col-6">
                                <a href="<?php echo get_term_link($cate , 'product_cat') ?>">
                                    <div class="cate-wrapper">
                                        <div class="cate-thumb">
                                            <img src="<?php echo $image ?>" alt="thumbnail product category" srcset="">
                                        </div>
                                        <div class="cate-title">
                                            <span><?php echo $term->name ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php
            if(isset($productHome) && !empty($productHome)) {

                foreach ($productHome as $product) {
                    if( (isset($product['product_type_category']) && !empty($product['product_type_category'])) || (isset($product['product_type_product']) && !empty($product['product_type_product']))) {

                        set_query_var('productData', $product);
                        if($product['display_layout'] == 'left') {
                            get_template_part('template-parts/layouts-home/banner' , 'left');
                        }
                        if($product['display_layout'] == 'top') {
                            get_template_part('template-parts/layouts-home/banner' , 'top');
                        }
                        if($product['display_layout'] == 'right') {
                            get_template_part('template-parts/layouts-home/banner' , 'right');
                        }
                    }
                }
            }
        ?>
    </div>
</div>
<?php get_footer(); ?>


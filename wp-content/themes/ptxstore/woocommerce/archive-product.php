<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<style>
    .products-sort-wrapper {
        width: 100%;
        margin-bottom: 50px;
    }
    .sort-wrapper {
        margin-left: auto !important;
        justify-content: normal !important;
    }
    .woocommerce-ordering {
        margin-bottom: 0px !important;
    }
    @media screen and (max-width: 768px) {
        .woocommerce-ordering select {
            width: 100px;
        }
    }

    .woocommerce-pagination {
        margin: 0 auto;
    }
    .atc-product-image img {
        width: 80px;
    }
    .atc-product-image {
        text-align: center;
    }

</style>

<!-- custom content -->

<div class="main-wrapper">
    <!--  content -->
    <div class="container custom-container cat-container">
        <div class="breadscumb-wrapper">
            <?php woocommerce_breadcrumb(); ?>
        </div>


        <div class="category-heading">

            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                <h1 class="woocommerce-products-header__title page-title fw-extraBold"><?php woocommerce_page_title(); ?></h1>
            <?php endif; ?>

            <?php do_action( 'woocommerce_archive_description' ); ?>

        </div>



        <div class="category-content">
            <div class="row row-mobile">
                <!-- sidebar -->
                <?php get_sidebar('product'); ?>


                <div class="col-xl-9 col-lg-3 col-mobile">
                    <div class="category-products-wrapper">


                        <!-- item product -->
                        <div class="category-product-list">
                            <div class="row row-mobile">

                                <?php
                                    if ( woocommerce_product_loop() ) {

                                        ?>
                                        <!-- sorting -->
                                        <div class="products-sort-wrapper d-lg-flex d-xl-flex d-sm-none d-none">
                                            <?php if(!wp_is_mobile()) do_action( 'woocommerce_before_shop_loop' ); ?>
                                        </div>

                                        <?php

                                        woocommerce_product_loop_start();

                                        if ( wc_get_loop_prop( 'total' ) ) {
                                            while ( have_posts() ) {
                                                the_post();

                                                /**
                                                 * Hook: woocommerce_shop_loop.
                                                 */
                                                do_action( 'woocommerce_shop_loop' );

                                                wc_get_template_part( 'content', 'product' );
                                            }
                                        }

                                        woocommerce_product_loop_end();

                                        /**
                                         * Hook: woocommerce_after_shop_loop.
                                         *
                                         * @hooked woocommerce_pagination - 10
                                         */
                                        do_action( 'woocommerce_after_shop_loop' );
                                    } else {
                                        /**
                                         * Hook: woocommerce_no_products_found.
                                         *
                                         * @hooked wc_no_products_found - 10
                                         */
                                        do_action( 'woocommerce_no_products_found' );
                                    }

                                    /**
                                     * Hook: woocommerce_after_main_content.
                                     *
                                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                                     */
                                    do_action( 'woocommerce_after_main_content' );
                                ?>

                            </div>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </div>




    <!-- modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="product-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="productModalLabel">Edit detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="product-wrapper">
                        <div class="row row-mobile">
                            <div class="col-xl-7 col-lg-7 col-12 col-mobile">
                                <div class="product-image">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/loading-page.gif" alt="loading page">
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-12 col-mobile">
                                <div class="product-detail">
                                    <div class="product-title">
                                        <span class="fs-md title"></span>
<!--                                        <span class="fs-md type">Classic T-Shirt</span>-->
                                    </div>
                                    <div class="product-price">
                                        <span class="price fs-xl fw-bold">$29.95 </span><span class="small-price fs-lg">$34.95</span>
                                    </div>
                                    <div class="ptx-product-types-list product-types-list">
                                        <ul>
                                        </ul>
                                    </div>
                                    <div class="ptx-product-size-select product-size-select">
                                        <div class="product-size-title">
                                            <span class="fw-bold label">Size: </span>
                                            <span class="fw-bold placeholder">Select a Size</span>
                                            <span class="size"></span>
                                        </div>
                                        <ul>
                                        </ul>
                                    </div>
                                    <div class="ptx-product-color-select product-color-select">
                                        <div class="product-color-title">
                                            <span class="fw-bold label">Color: </span>
                                            <span class="color">Black</span>
                                        </div>
                                        <ul>
                                        </ul>
                                    </div>
                                    <div class="product-quantity-list">
                                        <div class="product-quantity-title">
                                            <span class="fw-bold label">Qty: </span>
                                            <span class="quantity">1</span>
                                        </div>
                                        <div class="product-quantity-select">
                                            <button class="btn minus disabled"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
                                            <span class="quantity">1</span>
                                            <button class="btn plus"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <div class="product-add-to-cart">
                                        <input type="hidden" name="product" value="" id="inProduct">
                                        <input type="hidden" name="qty" value="1" id="inQty">
                                        <input type="hidden" name="variable" value="" id="inVariable">
                                        <input type="hidden" name="sizeSelect" value="" id="sizeSelect">
                                        <input type="hidden" name="colorSelect" value="" id="colorSelect">

                                        <button class="btn btn-add-card fw-bold">Add to cart</button>
                                    </div>
                                    <div class="view-detail">
                                        <a href="#">View full product details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- modal show add cart -->
    <div class="modal fade" id="addToCart" tabindex="-1" role="dialog" aria-labelledby="product-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="product-wrapper">
                        <div class="row row-mobile" style="display: flex; align-items: center; justify-content: center">
                            <div class="col-xl-5 col-lg-5 col-12 col-mobile">
                                <div class="atc-status text-center" style="display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/check.png" width="20px" style="margin-right: 8px"> <b>Added to cart</b>
                                </div>
                                <div class="atc-product-image">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/loading-page.gif" alt="loading page">
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-7 col-12 col-mobile">

                                <div class="atc-btn btn fw-bold" style="color: #0062cc; border: solid thin #0062cc; margin-right: 20px">
                                    <a href="<?php echo wc_get_cart_url() ?>">Cart</a>
                                </div>

                                <div class="btn btn-primary fw-bold">
                                    <a href="<?php echo wc_get_checkout_url() ?>" style="color: #ffffff">Proceed to checkout</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- end content -->
<?php
get_footer( 'shop' );

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
    <?php wc_get_template_part( 'content', 'popup-add-cart' ); ?>

</div>

<!-- end content -->
<?php
get_footer( 'shop' );

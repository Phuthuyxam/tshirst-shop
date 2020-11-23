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
                                    <img src="images/regular1.jpg" alt="">
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-12 col-mobile">
                                <div class="product-detail">
                                    <div class="product-title">
                                        <span class="fs-md title">HEY SNOWFLAKE IN THE REAL WORLD T SHIRT</span>
                                        <span class="fs-md type">Classic T-Shirt</span>
                                    </div>
                                    <div class="product-price">
                                        <span class="price fs-xl fw-bold">$29.95 </span><span class="small-price fs-lg">$34.95</span>
                                    </div>
                                    <div class="product-types-list">
                                        <ul>
                                            <li class="type-image-wrapper active" data-name="Classic T-Shirt">
                                                <div class="type-image">
                                                    <img src="images/regular1.jpg" alt="">
                                                </div>
                                            </li>
                                            <li class="type-image-wrapper" data-name="Hooded Sweatshirt">
                                                <div class="type-image">
                                                    <img src="images/regular2.jpg" alt="">
                                                </div>
                                            </li>
                                            <li class="type-image-wrapper" data-name="Long Sleeve Tee">
                                                <div class="type-image">
                                                    <img src="images/regular3.jpg" alt="">
                                                </div>
                                            </li>
                                            <li class="type-image-wrapper" data-name="V-Neck T-Shirt">
                                                <div class="type-image">
                                                    <img src="images/regular4.jpg" alt="">
                                                </div>
                                            </li>
                                            <li class="type-image-wrapper" data-name="Crewneck Sweatshirt">
                                                <div class="type-image">
                                                    <img src="images/regular5.jpg" alt="">
                                                </div>
                                            </li>
                                            <li class="type-image-wrapper" data-name="Unisex Tank">
                                                <div class="type-image">
                                                    <img src="images/regular6.jpg" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-size-select">
                                        <div class="product-size-title">
                                            <span class="fw-bold label">Size: </span>
                                            <span class="fw-bold placeholder">Select a Size</span>
                                            <span class="size"></span>
                                        </div>
                                        <ul>
                                            <li class="fw-bold">S</li>
                                            <li class="fw-bold">M</li>
                                            <li class="fw-bold">L</li>
                                            <li class="fw-bold">XL</li>
                                            <li class="fw-bold">2XL</li>
                                        </ul>
                                    </div>
                                    <div class="product-color-select">
                                        <div class="product-color-title">
                                            <span class="fw-bold label">Color: </span>
                                            <span class="color">Black</span>
                                        </div>
                                        <ul>
                                            <li class="fw-bold active" data-name="Black">
                                                <div class="color-circle">
                                                    <div class="circle" style="background-color: #111111;"></div>
                                                </div>
                                            </li>
                                            <li class="fw-bold" data-name="Chocolate">
                                                <div class="color-circle">
                                                    <div class="circle" style="background-color: #381d1b;"></div>
                                                </div>
                                            </li>
                                            <li class="fw-bold" data-name="Charcoal Grey">
                                                <div class="color-circle">
                                                    <div class="circle" style="background-color: #36454F;"></div>
                                                </div>
                                            </li>
                                            <li class="fw-bold" data-name="Athletic Heather">
                                                <div class="color-circle">
                                                    <div class="circle" style="background-color: #97999B;"></div>
                                                </div>
                                            </li>
                                            <li class="fw-bold" data-name="J Navy">
                                                <div class="color-circle">
                                                    <div class="circle" style="background-color: #0A2245;"></div>
                                                </div>
                                            </li>
                                            <li class="fw-bold" data-name="Royal">
                                                <div class="color-circle">
                                                    <div class="circle" style="background-color: #054ae8;"></div>
                                                </div>
                                            </li>
                                            <li class="fw-bold">
                                                <div class="color-circle" data-name="True Red">
                                                    <div class="circle" style="background-color: #b1202d;"></div>
                                                </div>
                                            </li>
                                            <li class="fw-bold" data-name="Kelly">
                                                <div class="color-circle">
                                                    <div class="circle" style="background-color: #00984F;"></div>
                                                </div>
                                            </li>
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


</div>

<!-- end content -->
<?php
get_footer( 'shop' );

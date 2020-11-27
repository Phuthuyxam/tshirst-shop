<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

    <!--   main product      -->
    <div class="product-wrapper" style="margin-top: 2rem;">
        <div class="row row-mobile">
            <!-- slider -->
            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            //do_action( 'woocommerce_before_single_product_summary' );
            ?>


            <div class="summary entry-summary">
                <?php
                /**
                 * Hook: woocommerce_single_product_summary.
                 *
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 * @hooked WC_Structured_Data::generate_product_data() - 60
                 */
                do_action( 'woocommerce_single_product_summary' );
                ?>
            </div>

            <?php
            /**
             * Hook: woocommerce_after_single_product_summary.
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            //do_action( 'woocommerce_after_single_product_summary' );
            ?>


            <!-- slider -->
            <div class="col-xl-8 col-lg-8 col-sm-12 d-xl-block d-lg-block d-sm-none d-none">
                <div class="product-image-wrapper">
                    <div class="row">
                        <div class="col-xl-2 col-lg-2">
                            <div id="gal1" class="product-image-list">
                                <a href="#" class="active" data-image="<?php echo get_template_directory_uri() ?>/assets/images/regular1.jpg" data-zoom-image="<?php echo get_template_directory_uri() ?>/assets/images/regular1.jpg" data-order="1">
                                    <img id="img_01" src="<?php echo get_template_directory_uri() ?>/assets/images/regular1.jpg" />
                                </a>
                                <a href="#" data-image="<?php echo get_template_directory_uri() ?>/assets/images/thumb111.jpg" data-zoom-image="<?php echo get_template_directory_uri() ?>/assets/images/thumb111.jpg" data-order="2">
                                    <img id="img_01" src="<?php echo get_template_directory_uri() ?>/assets/images/thumb111.jpg" />
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-12 col-mobile">
                            <div class="product-image-number">
                                <span class="current fw-extraBold">1</span>
                                <span class="fw-extraBold">/</span>
                                <span class="total fw-extraBold">2</span>
                            </div>
                            <div class="product-image" id="productImage">
                                <img id="zoom_03" src="<?php echo get_template_directory_uri() ?>/assets/images/regular1.jpg" data-zoom-image="<?php echo get_template_directory_uri() ?>/assets/images/regular1.jpg"/>
                                <div class="product-nav">
                                    <div class="prev">
                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                    </div>
                                    <div class="next">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 d-xl-block d-lg-block d-sm-none d-none relate-wrapper">
                            <div class="bundle-wrapper">
                                <div class="heading">
                                    <span class="fw-bold fs-lg">Bundle and Save</span>
                                </div>
                                <div class="content">
                                    <div class="row" style="align-items: center;">
                                        <div class="col-xl-8 col-lg-8">
                                            <div class="bundle-images">
                                                <a href="#">
                                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/medium12.jpg" alt="">
                                                </a>
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                <a href="#">
                                                    <img src="<?php echo get_template_directory_uri() ?>/assets/images/medium11.jpg" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4">
                                            <div class="sale-off-percent">
                                                <span class="number fw-extraBold fs-2xl">10</span>
                                                <span class="type fw-extraBold fs-2xl">%</span>
                                                <span class="fw-extraBold fs-2xl"> Off</span>
                                            </div>
                                            <div class="bundle-price-wrapper pt-1">
                                                <span class="heading fw-bold">Total Price:</span>
                                                <div class="price">
                                                    <span class="discount-price fw-bold fs-xl">$47.61</span>
                                                    <span class="regular-price fs-lg">$52.90</span>
                                                </div>
                                            </div>
                                            <div class="add-both">
                                                <button class="btn btn-add-both fw-bold" data-toggle="modal" data-target="#bundleModal">Add Both to Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relate-products-wrapper">
                                <div class="heading">
                                    <span class="fw-bold fs-lg">Related products</span>
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <?php for ($i = 0 ; $i < 3; $i++): ?>
                                            <div class="col-lg-4 col-xl-4 col-6 col-mobile">
                                                <div class="item-wrapper">
                                                    <a href="#">
                                                        <div class="item-thumb">
                                                            <img src="<?php echo get_template_directory_uri() ?>/assets/images/medium1.jpg" alt="">
                                                        </div>
                                                        <div class="item-content">
                                                            <div class="item-title">
                                                                <h3 class="fs-sm">SKULL MOUSEPAD BEST GIFT ZD04</h3>
                                                            </div>
                                                            <div class="item-attribute">
                                                                <div class="item-price">
                                                                    <span class="price fs-md">$22.99</span>
                                                                    <span class="small-price fs-xs ">$26.43</span>
                                                                </div>
                                                                <div class="item-colors">
                                                                    <span class="fs-xs">15 colors</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <div class="btn-add-cart">
                                                        <button class="btn btn-primary fw-bold" data-toggle="modal" data-target="#productModal">Add to cart</button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- product content -->

            <div class="col-xl-4 col-lg-4 col-12 col-mobile">
                <div class="product-detail">
                    <div class="product-title">
                        <span class="fs-md title">HEY SNOWFLAKE IN THE REAL WORLD T SHIRT</span>
                        <span class="fs-md type">Classic T-Shirt</span>
                    </div>
                    <div class="product-price">
                        <span class="price fs-xl fw-bold">$29.95 </span><span class="small-price fs-lg">$34.95</span>
                    </div>
                    <div class="product-image-mobile d-xl-none d-lg-none d-sm-block d-xs-block">
                        <div class="owl-carousel owl-theme">
                            <div class="item"><img src="<?php echo get_template_directory_uri()?>/assets/images/regular1.jpg" /></div>
                            <div class="item"><img src="<?php echo get_template_directory_uri()?>/assets/images/thumb111.jpg" /></div>
                        </div>
                    </div>
                    <div class="products-list">
                        <div class="product-list-title">
                            <span class="fw-bold">Product:</span>
                        </div>
                        <div class="products-select">
                            <div class="products-select-overlay"></div>
                            <div class="product-name">
                                <span>Classic T-Shirt - $29.95</span>
                            </div>
                            <i class="fa fa-angle-down fs-md " aria-hidden="true"></i>
                        </div>
                        <div class="product-options">
                            <ul>
                                <li class="active">
                                    <span>Classic T-Shirt - $29.95</span>
                                    <i class="fa fa-check check-icon" aria-hidden="true"></i>
                                </li>
                                <li>
                                    <span>Premium Fit Mens Tee - $33.95</span>
                                    <i class="fa fa-check check-icon" aria-hidden="true"></i>
                                </li>
                                <li>
                                    <span>Hooded Sweatshirt - $49.95</span>
                                    <i class="fa fa-check check-icon" aria-hidden="true"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-types-list">
                        <ul>
                            <li class="type-image-wrapper active" data-name="Classic T-Shirt">
                                <div class="type-image">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/thumb12.jpg" alt="">
                                </div>
                            </li>
                            <li class="type-image-wrapper" data-name="Hooded Sweatshirt">
                                <div class="type-image">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/regular2.jpg" alt="">
                                </div>
                            </li>
                            <li class="type-image-wrapper" data-name="Long Sleeve Tee">
                                <div class="type-image">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/regular3.jpg" alt="">
                                </div>
                            </li>
                            <li class="type-image-wrapper" data-name="V-Neck T-Shirt">
                                <div class="type-image">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/regular4.jpg" alt="">
                                </div>
                            </li>
                            <li class="type-image-wrapper" data-name="Crewneck Sweatshirt">
                                <div class="type-image">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/regular5.jpg" alt="">
                                </div>
                            </li>
                            <li class="type-image-wrapper" data-name="Unisex Tank">
                                <div class="type-image">
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/regular6.jpg" alt="">
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
                    <div class="products-quantity-select">
                        <div class="product-quantity-title">
                            <span class="fw-bold">Qty: </span>
                            <span class="fw-bold quantity">1</span>
                        </div>
                        <div class="products-select quantity-select">
                            <div class="products-quantity-select-overlay"></div>
                            <div class="product-name">
                                <span class="quantity">1</span>
                            </div>
                            <i class="fa fa-angle-down fs-md " aria-hidden="true"></i>
                        </div>
                        <div class="quantity-options">
                            <ul>
                                <li class="active" data-value="1">1</li>
                                <li data-value="2">2</li>
                                <li data-value="3">3</li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-add-to-cart">
                        <button class="btn btn-add-card fw-bold">Add to cart</button>
                    </div>
                    <div class="relate-mobile d-xl-none d-lg-none d-sm-block d-xs-block relate-wrapper">
                        <div class="bundle-wrapper">
                            <div class="heading">
                                <span class="fw-bold fs-lg">Bundle and Save</span>
                            </div>
                            <div class="content">
                                <div class="row" style="align-items: center;">
                                    <div class="col-xl-8 col-lg-8">
                                        <div class="bundle-images">
                                            <a href="#">
                                                <img src="<?php echo get_template_directory_uri()?>/assets/images/medium12.jpg" alt="">
                                            </a>
                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            <a href="#">
                                                <img src="<?php echo get_template_directory_uri()?>/assets/images/medium11.jpg" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4">
                                        <div class="sale-off-percent">
                                            <span class="number fw-extraBold fs-2xl">10</span>
                                            <span class="type fw-extraBold fs-2xl">%</span>
                                            <span class="fw-extraBold fs-2xl"> Off</span>
                                        </div>
                                        <div class="bundle-price-wrapper pt-1">
                                            <span class="heading fw-bold">Total Price:</span>
                                            <div class="price">
                                                <span class="discount-price fw-bold fs-xl">$47.61</span>
                                                <span class="regular-price fs-lg">$52.90</span>
                                            </div>
                                        </div>
                                        <div class="add-both">
                                            <button class="btn btn-add-both fw-bold" data-toggle="modal" data-target="#bundleModal">Add Both to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relate-products-wrapper">
                            <div class="heading">
                                <span class="fw-bold fs-lg">Related products</span>
                            </div>
                            <div class="content">
                                <div class="row row-mobile">
                                    <?php for ($i = 0 ; $i < 3; $i++): ?>
                                        <div class="col-lg-4 col-xl-4 col-sm-4 col-mobile" style="padding: 0 5px;">
                                            <div class="item-wrapper">
                                                <a href="#">
                                                    <div class="item-thumb">
                                                        <img src="<?php echo get_template_directory_uri()?>/assets/images/medium1.jpg" alt="">
                                                    </div>
                                                    <div class="item-content">
                                                        <div class="item-title">
                                                            <h3 class="fs-sm">SKULL MOUSEPAD BEST GIFT ZD04</h3>
                                                        </div>
                                                        <div class="item-attribute">
                                                            <div class="item-price">
                                                                <span class="price fs-md">$22.99</span>
                                                                <span class="small-price fs-xs ">$26.43</span>
                                                            </div>
                                                            <div class="item-colors">
                                                                <span class="fs-xs">15 colors</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="btn-add-cart">
                                                    <button class="btn btn-primary fw-bold" data-toggle="modal" data-target="#productModal">Add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="campaign-wrapper" style="margin-top: 2rem;">
                        <h5 class="fw-bold fs-lg py-3">Campaign Details</h5>
                        <div class="content">I AM AN ASSHOLE MAN - I LOVE FREEDOM, DRINK BEER, LOVE MY WIFE SHIRT - BACK DESIGN</div>
                    </div>
                    <div class="campaign-wrapper">
                        <h5 class="fw-bold fs-lg py-3">Product Details</h5>
                        <div class="content">I AM AN ASSHOLE MAN - I LOVE FREEDOM, DRINK BEER, LOVE MY WIFE SHIRT - BACK DESIGN</div>
                    </div>
                    <div class="campaign-wrapper">
                        <h5 class="fw-bold fs-lg py-3">Shipping Info</h5>
                        <div class="content">I AM AN ASSHOLE MAN - I LOVE FREEDOM, DRINK BEER, LOVE MY WIFE SHIRT - BACK DESIGN</div>
                    </div>
                    <div class="campaign-wrapper tags-wrapper">
                        <h5 class="fw-bold fs-lg py-3">Tags</h5>
                        <div class="content tag-content">
                            <ul>
                                <li class="py-2 px-3">
                                    <a href="#">
                                        <span class="fw-bold fs-sm">Family & Relationships</span>
                                    </a>
                                </li>
                                <li class="py-2 px-3">
                                    <a href="#">
                                        <span class="fw-bold fs-sm">Husband</span>
                                    </a>
                                </li>
                                <li class="py-2 px-3">
                                    <a href="#">
                                        <span class="fw-bold fs-sm">Relationship</span>
                                    </a>
                                </li>
                                <li class="py-2 px-3">
                                    <a href="#">
                                        <span class="fw-bold fs-sm">Birthday</span>
                                    </a>
                                </li>
                                <li class="py-2 px-3">
                                    <a href="#">
                                        <span class="fw-bold fs-sm">Celebrations</span>
                                    </a>
                                </li>
                                <li class="py-2 px-3">
                                    <a href="#">
                                        <span class="fw-bold fs-sm">Holiday & Events</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="campaign-wrapper share-campaign py-4">
                        <h5>Share campaign</h5>
                        <a class="btn btn-share"><i class="fa fa-facebook-square" aria-hidden="true"></i> Share</a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

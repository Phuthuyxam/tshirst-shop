<?php
global $wooextension;
$product_cat = $wooextension->getAllProductTerm('product_cat');
$product_type = $wooextension->getAllProductTerm('ptx_product_type');
$product_color = $wooextension->getAllProductTerm('pa_color');
$active_product_cat = $_GET['product_cat'];
$active_product_type = $_GET['product_type'];
$active_product_color = $_GET['color'];

?>
<!-- sidebar -->
<div class="col-xl-3 col-lg-3 col-mobile">
    <div class="category-side-wrapper">

        <div class="category-side-heading">

            <?php if(wp_is_mobile()) do_action( 'woocommerce_before_shop_loop' ); ?>
        </div>

        <div class="category-side-heading">
            <div class="category-filter-title" style="display: flex; align-items: center">
                <img width="15" src="<?php echo get_template_directory_uri() ?>/assets/images/filter-results-button.svg">
                <span class="fw-bold" style="margin-left: 15px">Filter</span>
            </div>
            <div class="category-filter-reset">
                <span class="fw-bold">Reset</span>
            </div>
        </div>


        <div class="category-side-content">
            <div class="category-side-body">
                <div class="category-side-layout d-xl-none d-lg-none d-sm-block d-xs-block"></div>
                <div class="category-side-filter">
                    <div class="category-side-control">
                        <button class="btn btn-done fw-bold d-xl-none d-lg-none d-sm-block d-xs-block">Done</button>
                        <div class="category-filter-reset-mobile">
                            <span class="fw-bold">Reset</span>
                        </div>
                    </div>

                    <?php if(isset($product_cat) && !empty($product_cat)) : ?>
                    <div class="filter-item" style="border-top: 1px solid #f3f3f3;">
                        <div class="filter-title">
                            <span class="fw-bold">shop for</span>
                            <i class="fa fa-plus expand d-none" aria-hidden="true"></i>
                            <i class="fa fa-minus collapse " aria-hidden="true"></i>
                        </div>
                        <div class="filter-content" data-filter="product_cat">
                            <ul>
                                <?php foreach ($product_cat as $cat): ?>
                                    <li class="<?php echo (isset($active_product_cat) && !empty($active_product_cat) && $active_product_cat == $cat->slug) ? 'active' : false ?>" data-term="<?php echo $cat->slug ?>">
                                        <div class="filter-element">
                                            <i class="fa fa-circle-o normal" aria-hidden="true"></i>
                                            <i class="fa fa-dot-circle-o active" aria-hidden="true"></i>
                                            <span><?php echo $cat->name ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>


                    <div class="filter-item">
                        <div class="filter-title">
                            <span class="fw-bold">product type</span>
                            <i class="fa fa-plus expand d-none" aria-hidden="true"></i>
                            <i class="fa fa-minus collapse" aria-hidden="true"></i>
                        </div>
                        <div class="filter-content" data-filter="product_type">
                            <ul>
                                <?php foreach ($product_type as $type): ?>
                                    <li class="<?php echo (isset($active_product_type) && !empty($active_product_type) && $active_product_type == $type->slug) ? 'active' : false ?>" data-term="<?php echo $type->slug ?>">
                                        <div class="filter-element">
                                            <i class="fa fa-circle-o normal" aria-hidden="true"></i>
                                            <i class="fa fa-dot-circle-o active" aria-hidden="true"></i>
                                            <span><?php echo $type->name ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>


                    <div class="filter-item">
                        <div class="filter-title">
                            <span class="fw-bold">color</span>
                            <i class="fa fa-plus expand d-none" aria-hidden="true"></i>
                            <i class="fa fa-minus collapse" aria-hidden="true"></i>
                        </div>
                        <div class="filter-content" data-filter="color">
                            <ul>
                                <?php
                                    foreach ($product_color as $color):
                                        $color_hex = get_field('color_hex','pa_color_'.$color->term_id);
                                ?>
                                    <li class="<?php echo (isset($active_product_color) && !empty($active_product_color) && $active_product_color == $color->slug) ? 'active' : false ?>">
                                        <div class="filter-element">
                                            <div class="color-circle">
                                                <div class="circle" style="background-color: <?php echo $color_hex ?>;"></div>
                                            </div>
                                            <span><?php echo $color->name ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
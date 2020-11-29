<?php
    global $product;
    $attachment_ids = $product->get_gallery_image_ids();
    //This adds the thumbnail id as the first element of the array
    array_unshift($attachment_ids, get_post_thumbnail_id(get_the_ID()));
?>
<!-- slider -->
<div class="col-xl-8 col-lg-8 col-sm-12 d-xl-block d-lg-block d-sm-none d-none">
    <div class="product-image-wrapper">
        <div class="row">
            <?php
            if(isset($attachment_ids) && !empty($attachment_ids)):
                $firstImage = wp_get_attachment_image_src($attachment_ids[0], 'full')[0];
            ?>
            <div class="col-xl-2 col-lg-2">
                <div id="gal1" class="product-image-list">
                    <?php
                        foreach ($attachment_ids as $key => $thumId):
                            $image = wp_get_attachment_image_src($thumId)[0];
                            $imageFullSize = wp_get_attachment_image_src($thumId, 'full')[0];

                    ?>
                        <a href="#" class="<?php if($key == 0) echo 'active' ?>" data-image="<?php echo $imageFullSize ?>" data-zoom-image="<?php echo $imageFullSize ?>" data-order="<?php echo $key + 1; ?>">
                            <img id="img_0<?php echo $key + 1 ?>" src="<?php echo $imageFullSize ?>" />
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>


            <div class="col-xl-10 col-lg-10 col-12 col-mobile">
                <div class="product-image-number">
                    <span class="current fw-extraBold">1</span>
                    <span class="fw-extraBold">/</span>
                    <span class="total fw-extraBold"><?php echo count($attachment_ids) ?></span>
                </div>
                <div class="product-image" id="productImage">
                    <img id="zoom_03" src="<?php echo $firstImage ?>" data-zoom-image="<?php echo $firstImage ?>"/>
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

            <?php endif; ?>

            <div class="col-xl-12 col-lg-12 d-xl-block d-lg-block d-sm-none d-none relate-wrapper">
                <?php
                global $wooextension;
                $relaproduct = $wooextension->getRelateProduct();
                if($relaproduct->have_posts()):
                ?>
                    <div class="relate-products-wrapper">
                        <div class="heading">
                            <span class="fw-bold fs-lg">Related products</span>
                        </div>
                        <div class="content">
                            <div class="row">
                                <?php
                                while ($relaproduct->have_posts()){
                                    $relaproduct->the_post();
                                    wc_get_template_part( 'content', 'product' );
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                <?php endif; wp_reset_query(); ?>
            </div>


        </div>
    </div>
</div>
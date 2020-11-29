<?php
global $product;
$attachment_ids = $product->get_gallery_image_ids();
//This adds the thumbnail id as the first element of the array
array_unshift($attachment_ids, get_post_thumbnail_id(get_the_ID()));
if(isset($attachment_ids) && !empty($attachment_ids)):
?>
<div class="product-image-mobile d-xl-none d-lg-none d-sm-block d-xs-block">
    <div class="owl-carousel owl-theme">
        <?php
            foreach ($attachment_ids as $thumId):
                $imageFullSize = wp_get_attachment_image_src($thumId, 'full')[0];
        ?>
                    <div class="item"><img src="<?php echo $imageFullSize ?>" /></div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
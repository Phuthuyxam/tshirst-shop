// set default value

function setDefaultValue() {
    var dataProduct = jQuery('#ptx-single-add-cart').attr('data-product');
    if(dataProduct) {
        dataProduct = JSON.parse(dataProduct);
    }

    var size = jQuery('#ptx-product-size-select .active').attr('data-size');
    var color = jQuery('#ptx-product-color-select .active').attr('data-color');
    var quantity = jQuery('#ptx-quantity').text();

    if(dataProduct && dataProduct.length > 0) {
        var validate = validateData(dataProduct, size, color);
        if(!validate) {
            jQuery('#ptx-product-size-select .active').addClass('ptx-validate-size-error');
            jQuery('#ptx-product-color-select .active').addClass('ptx-validate-color-error');
            jQuery('#ptx-single-add-cart').prop('disabled', true);
        }else{
            jQuery('#ptx-product-size-select ul li').removeClass('ptx-validate-size-error');
            jQuery('#ptx-product-color-select ul li').removeClass('ptx-validate-color-error');
            jQuery('#ptx-single-add-cart').prop('disabled', false);
            // set value
            if(validate.price_html.length === 0) {
                let price_html_build = '';
            } else {
                jQuery('#ptx-single-price').html(validate.price_html);
            }


            setImageVariation(validate.image.full_src);
            jQuery('#ptx-single-size').val(size);
            jQuery('#ptx-single-color').val(color);
            jQuery('#ptx-single-avatar').val(validate.image.full_src);
            jQuery('#ptx-single-variation').val(validate.variation_id);

        }

    }

}
const htmlImg = jQuery('#gal1').html();
function setImageVariation(img) {

    var order = jQuery('#gal1 a').last().attr('data-order');

    var html = htmlImg + `<a href="#" class="active" data-image="`+ img +`" data-zoom-image="`+ img +`" data-order="`+ parseInt(order) + 1 +`">
                 <img id="img_`+ order +`" src="`+ img +`" />
            </a>`;
    jQuery('#gal1').html(html);

    if(jQuery('#zoom_03').length > 0) {
        jQuery('#zoom_03').attr('src',img);
        // jQuery('#zoom_03').attr('data-zoom-image',img);
        jQuery("#zoom_03").data('zoom-image', img).elevateZoom({
            gallery: 'gal1',
            cursor: 'pointer',
            galleryActiveClass: 'active',
            imageCrossfade: true
        });
    }



}

function validateData(data , size , color) {
    var result = false;
    for (var i = 0; i < data.length; i++) {
        var attributes = data[i].attributes;
        if((attributes.attribute_pa_color == color && attributes.attribute_pa_size == size)
            || (attributes.attribute_pa_color == color && attributes.attribute_pa_size == "")
            || (attributes.attribute_pa_color == "" && attributes.attribute_pa_size == size)) {
            result = data[i];
            break;
        }
    }
    return result;
}

// simple product add to cart
jQuery('#ptx-simple-add-cart').click(function () {
    var quantity = jQuery('#ptx-quantity').text();
    var productId = jQuery("#add-to-cart").val();
    var urlAddCart = jQuery(this).attr('data-addcart');
    var cartUrl = urlAddCart + "?add-to-cart=" + parseInt(productId) + "&quantity=" + parseInt(quantity);
    window.location.href = cartUrl;
})

// change value

jQuery('#ptx-product-size-select ul li').click(function () {
    jQuery(this).parent().find('li').removeClass('active');
    jQuery(this).addClass('active');
    jQuery(this).parents('.product-size-select').find('.placeholder').addClass('d-none');
    jQuery(this).parents('.product-size-select').find('.size').text(jQuery(this).text());
    setDefaultValue();
})

jQuery('#ptx-product-color-select ul li').click(function () {
    jQuery(this).parent().find('li').removeClass('active');
    jQuery(this).addClass('active');
    jQuery(this).parents('.product-color-select').find('.color').text(jQuery(this).data('name'));
    var key = jQuery(this).data('key');
    setDefaultValue();
})

// add cart variation product
jQuery('#ptx-single-add-cart').click(function () {
    var productId = jQuery('#ptx-single-productid').val();
    var varitionProduct = jQuery('#ptx-single-variation').val();
    var color = jQuery('#ptx-single-color').val();
    var size = jQuery('#ptx-single-size').val();
    var quantity = jQuery('#ptx-quantity').text();

    jQuery.ajax({
        type: "POST",
        url: mainUrl + '/wp-admin/admin-ajax.php',
        data: {
            'action' : 'woocommerce_ajax_add_to_cart',
            'pid' : productId,
            'vid' : varitionProduct,
            'qty' : quantity,
            'color' : color,
            'size' : size
        },
        dataType: 'json',
        success: function (data){
            if(data.error) {
                alert("Add to cart error please try again");
                location.reload();
            }else{
                var image = jQuery('#ptx-single-avatar').val();
                jQuery('.atc-product-image img').attr("src",image);
                jQuery('#productModal').modal('hide');
                if(data.product_upsell) {
                    jQuery('#section-upsell-product').html(data.product_upsell);
                }
                if(data.cart_info) {
                    jQuery('.ptx-cart-info').html(data.cart_info);
                }
                jQuery('#addToCart').modal('show');
            }

        },
    });

})
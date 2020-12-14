// set default value

function setDefaultValueUpsell() {
    var dataProduct = jQuery('#upsell-single-add-cart').attr('data-product');
    if(dataProduct) {
        dataProduct = JSON.parse(dataProduct);
    }

    var size = jQuery('#upsell-product-size .active').attr('data-size');
    var color = jQuery('#upsell-product-color .active').attr('data-color');

    if(dataProduct && dataProduct.length > 0) {
        var validate = validateDataUpsell(dataProduct, size, color);
        if(!validate) {
            jQuery('#upsell-product-size .active').addClass('ptx-validate-size-error');
            jQuery('#upsell-product-color .active').addClass('ptx-validate-color-error');
            jQuery('#upsell-single-add-cart').prop('disabled', true);
        }else{
            jQuery('#upsell-product-size ul li').removeClass('ptx-validate-size-error');
            jQuery('#upsell-product-color ul li').removeClass('ptx-validate-color-error');
            jQuery('#upsell-single-add-cart').prop('disabled', false);
            // set value
            jQuery('#upsell-product-price').html(validate.price_html);
            setImageVariation(validate.image.full_src);
            jQuery('#upsell-single-size').val(size);
            jQuery('#upsell-single-color').val(color);
            jQuery('#upsell-single-variation').val(validate.variation_id);

        }

    }

}

function setImageVariation(img) {
    jQuery('#upsell-product-img img').attr('src',img);
}

function validateDataUpsell(data , size , color) {
    var result = false;
    for (var i = 0; i < data.length; i++) {
        var attributes = data[i].attributes;
        if((attributes.attribute_pa_color === color && attributes.attribute_pa_size === size)
            || (attributes.attribute_pa_color === color && attributes.attribute_pa_size === "")
            || (attributes.attribute_pa_color === "" && attributes.attribute_pa_size === size)) {
            result = data[i];
            break;
        }
    }
    return result;
}

// change value

jQuery('body').on('click', '#upsell-product-size ul li', function () {
    jQuery(this).parent().find('li').removeClass('active');
    jQuery(this).addClass('active');
    jQuery(this).parents('.product-size-select').find('.placeholder').addClass('d-none');
    jQuery(this).parents('.product-size-select').find('.size').text(jQuery(this).text());
    setDefaultValueUpsell();
})

jQuery('body').on('click','#upsell-product-color ul li', function () {
    jQuery(this).parent().find('li').removeClass('active');
    jQuery(this).addClass('active');
    jQuery(this).parents('.product-color-select').find('.color').text(jQuery(this).data('name'));
    var key = jQuery(this).data('key');
    setDefaultValueUpsell();
})

// add cart variation product
jQuery('body').on('click','#upsell-single-add-cart', function () {
    var productId = jQuery('#upsell-single-productid').val();
    var varitionProduct = jQuery('#upsell-single-variation').val();
    var color = jQuery('#upsell-single-color').val();
    var size = jQuery('#upsell-single-size').val();
    var quantity = jQuery('#upsell-quantity').text();
    var cartUrl = jQuery('#cart-url').val();
    var builderUrl = cartUrl + "?add-to-cart="+ productId +"&variation_id="+ varitionProduct +"&quantity="+ quantity +"&attribute_pa_size="+ size +"&attribute_pa_color="+ color;
    window.location.href = builderUrl;
})
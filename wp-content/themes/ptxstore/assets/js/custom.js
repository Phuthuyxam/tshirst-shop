//Menu
jQuery(document).ready(function() {
    jQuery('.menu-box .main-menu>li.menu-item-has-children>a').append('<i class="fa fa-angle-down"></i>');
    jQuery('.menu-box .main-menu .sub-menu>li.menu-item-has-children>a').append('<i class="fa fa-angle-right"></i>');

    jQuery('.btn-show-menu').click(function() {
        jQuery(this).parents('header').find('.menu-box').css('width', '100vw');
    });
    jQuery('.menu-box .btn-hide-menu, .menu-box .bg-menu').click(function() {
        jQuery(this).parents('.menu-box').css('width', '0');
    });

    if (jQuery(window).width() < 992) {
        jQuery('.main-menu li.menu-item-has-children>a>i').click(function(e) {
            e.preventDefault();
            jQuery(this).parent().parent().children('.sub-menu').slideToggle('fast');
        });
    }

    jQuery('.treeview-item>a').on("click", function(e) {
        e.preventDefault();
        jQuery(this).parent().children('.sub-treeview').slideToggle('fast');
    });

    // search animate
    jQuery('.search-wrapper').click(function() {
        jQuery(this).addClass("active");
        jQuery('#search').focus();
        jQuery(this).find('.label-search').addClass('active');
        jQuery('#search').addClass('active');
    })

    jQuery("body").on('click', function(e) {
        if (!jQuery(e.target).hasClass('search-input') && !jQuery(e.target).hasClass('search-wrapper') &&
            !jQuery(e.target).hasClass('search') && !jQuery(e.target).hasClass('icon-search') && !jQuery(e.target).hasClass('label-search') && !jQuery(e.target).hasClass('search-mobile-icon')) {
            jQuery('#search').blur();
            if (jQuery('#search').val() == ""){
                jQuery(this).find('.label-search').removeClass('active');
            }
            jQuery('#search').removeClass('active');
            jQuery(this).find('.search-wrapper').removeClass("active");
            jQuery(this).find('.line-bottom').hide();
            // jQuery(this).find('header').removeClass('active')
        }
        if (jQuery(e.target).hasClass('header')) {
            jQuery(this).find(e.target).removeClass('active');
            jQuery(this).find('.search-wrapper').addClass('d-sm-none');
            jQuery(this).find('.search-wrapper').addClass('d-none');
        }
        // console.log(e.target);
        if(!jQuery(e.target).hasClass('sort-option') && !jQuery(e.target).hasClass('sort-overlay')){
            jQuery(this).find('.sort-options').addClass('d-none');
        }

        if(!jQuery(e.target).hasClass('products-select-overlay')) {
            jQuery(this).find('.product-options').hide();
        }

        if(!jQuery(e.target).hasClass('products-quantity-select-overlay')) {
            jQuery(this).find('.quantity-options').hide();
        }
    })

    jQuery('#search').keyup(function(e) {
        if (jQuery(this).val() == ""){
            jQuery(this).removeClass('active');
            jQuery(this).parents('.search-wrapper').find('.search-close-icon').hide();
            jQuery(this).parents('.search-wrapper').find('.line-bottom').show();
        }else{
            jQuery(this).parents('.search-wrapper').find('.line-bottom').hide();
            jQuery(this).addClass('active');
            jQuery(this).parents('.search-wrapper').find('.search-close-icon').show();
        }
    });

    jQuery('.search-mobile-icon').click(function(){
        jQuery(this).parents('body').find('header').addClass('active');
        jQuery('#search').focus();
        jQuery(this).parents('header').find('.search-wrapper').addClass('active');
        jQuery(this).parents('header').find('.search-wrapper').removeClass('d-sm-none');
        jQuery(this).parents('header').find('.search-wrapper').removeClass('d-none');
        jQuery(this).parents('header').find('.label-search').addClass('active');
    })

    jQuery('.filter-content ul li').click(function(){
        jQuery(this).parent().find('li').removeClass('active');
        jQuery(this).addClass('active');
    })

    jQuery('.filter-title').click(function(){
        jQuery(this).toggleClass('active');
        jQuery(this).find('.expand').toggleClass('d-none');
        jQuery(this).find('.collapse').toggleClass('d-none');
        jQuery(this).parents('.filter-item').find('.filter-content').slideToggle();
    })
    
    jQuery('.show-more').click(function(){
        jQuery(this).parents('ul').find('li.hide').removeClass('d-none');
        jQuery(this).addClass('d-none');
        jQuery(this).parents('ul').find('li.show-less').removeClass('d-none');
    })

    jQuery('.show-less').click(function(){
        jQuery(this).parents('ul').find('li.hide').addClass('d-none');
        jQuery(this).addClass('d-none');
        jQuery(this).parents('ul').find('li.show-more').removeClass('d-none');
    })

    jQuery('.sort-wrapper').click(function(){
        jQuery(this).find('.sort-options').removeClass('d-none');
    })

    jQuery('body').on('click', '#productModal .product-types-list ul li' , function(){

        var id = jQuery(this).attr("data-id");
        var url = mainUrl + '/wp-json/api/v1/get-woocomerce-product?productId='+id;
        var loading = mainUrl + '/wp-content/themes/ptxstore/assets/images/loading-page.gif';
        jQuery('#productModal').find('.product-image img').attr('src',loading);
        fetch(url)
            .then(response => response.json())
            .then(result => {
                result = JSON.parse(result);
                setColorList(result,jQuery('#productModal').find('.product-color-select'));
                setListSize(result[0],jQuery('#productModal .product-size-select ul'));
                setQuantity(result[0],jQuery('#productModal').find('.product-quantity-list'));
                setPrice(result[0],jQuery('#productModal').find('.product-price'));
                jQuery(this).parent().find('li').removeClass('active');
                jQuery(this).addClass('active');
                jQuery(this).parents('.product-wrapper').find('.product-image img').attr("src",jQuery(this).find('img').attr('src'));
                jQuery(this).parents('.product-wrapper').find('.product-title .title').text(jQuery(this).data('name'));
                jQuery('#inProduct').val(id);
            }).catch(error => {
            console.error(error);
        });


    })

    jQuery('.view-detail a').click(function (event) {
        event.preventDefault();

        var url = jQuery('.product-types-list ul .active').attr('data-url');

        window.location.href = url;

    })

    jQuery('body').on('click', '#productModal .product-size-select ul li', function(){
        jQuery(this).parent().find('li').removeClass('active');
        jQuery(this).addClass('active');
        jQuery(this).parents('.product-size-select').find('.placeholder').addClass('d-none');
        jQuery(this).parents('.product-size-select').find('.size').text(jQuery(this).text());
        setValueInput();
    })

    jQuery('body').on('click','#productModal .product-color-select ul li',function(){
        jQuery(this).parent().find('li').removeClass('active');
        jQuery(this).addClass('active');
        jQuery(this).parents('.product-color-select').find('.color').text(jQuery(this).data('name'));
        var key = jQuery(this).data('key');

        setValueInput();
    })

    jQuery('.btn-add-card').click(function () {
        var productId = jQuery('.product-types-list ul .active').attr('data-id');
        var variableProduct = jQuery('#inVariable').val();
        var quatity = jQuery('#inQty').val();
        var  size = jQuery('#sizeSelect').val();
        var color = jQuery('#colorSelect').val();
        jQuery.ajax({
            type: "POST",
            url: mainUrl + '/wp-admin/admin-ajax.php',
            data: {
                'action' : 'woocommerce_ajax_add_to_cart',
                'pid' : productId,
                'vid' : variableProduct,
                'qty' : quatity,
                'color' : color,
                'size' : size
            },
            dataType: 'json',
            success: function (data){
                console.log(data);
                if(data.error) {
                    alert("Add to cart error please try again");
                    location.reload();
                }else{
                    var image = jQuery('.product-image').html();
                    jQuery('.atc-product-image').html(image);
                    jQuery('#productModal').modal('hide');
                    jQuery('#addToCart').modal('show');
                }

            },
        });



    })

    jQuery('.product-quantity-select button.plus').click(function(){
        var val = jQuery(this).parents('.product-quantity-select').find('.quantity').text();
        jQuery(this).parents('.product-quantity-list').find('.quantity').text(parseInt(val) + 1);
        jQuery(this).parents('.product-quantity-select').find('.minus').removeClass('disabled');
        updateQuantity();
    })

    jQuery('.product-quantity-select button.minus').click(function(){
        var val = jQuery(this).parents('.product-quantity-select').find('.quantity').text();
        if (val > 1){
            jQuery(this).parents('.product-quantity-list').find('.quantity').text(parseInt(val) - 1);
        }else{
            jQuery(this).addClass('disabled');
            jQuery(this).parents('.product-quantity-list').find('.quantity').text(1);
        }
        updateQuantity();
    })

    function updateQuantity() {
        jQuery('#inQty').val(jQuery('.quantity').first().text());
    }

    jQuery('.category-side-layout').click(function(){
        jQuery(this).parents('.category-side-content').css('width','0');
        jQuery(this).parents('.category-side-content').addClass('animate__slideOutRight');
        jQuery(this).parents('.category-side-content').removeClass('animate__slideInRight');
    })

    jQuery('.category-filter-title').click(function(){
        jQuery(this).parents('body').find('.category-side-content').css('width','100%');
        jQuery(this).parents('body').find('.category-side-content').addClass('animate__animated animate__slideInRight');
        jQuery(this).parents('body').find('.category-side-content').removeClass('animate__slideOutRight');

    })

    jQuery('.btn-done').click(function(){
        jQuery(this).parents('.category-side-content').find('.category-side-layout').trigger('click');
    })

    jQuery('.category-filter-reset').click(function(){
        jQuery(this).parents('.category-side-content').find('li').removeClass('active');
    })

    jQuery('.category-side-body li').each(function(){
        if (jQuery(this).hasClass('active')){
            jQuery('.category-filter-reset').show();
        }
    })

    if(jQuery('#zoom_03').length > 0) {
        jQuery("#zoom_03").elevateZoom({
            gallery: 'gal1',
            cursor: 'pointer',
            galleryActiveClass: 'active',
            imageCrossfade: true
        });
    }

    jQuery('.products-select').click(function(){
        jQuery(this).parent().find('.product-options').show();
    }) 
    
    jQuery('.products-select.quantity-select').click(function(){
        jQuery(this).parent().find('.quantity-options').show();
    }) 

    jQuery('.btn-save-changes').click(function(){
        jQuery(this).parents('.product-wrapper').removeClass('active');
        jQuery(this).parents('.product-wrapper').next().addClass('active');
        jQuery('#bundleModalLabel').find('.item .current').text(jQuery(this).parents('.product-wrapper').next().data('order'));
    })
    jQuery('.quantity-options ul li').click(function(){
        jQuery(this).parents('.products-quantity-select').find('span.quantity').text(jQuery(this).data('value'));
        jQuery(this).parent().find('li').removeClass('active');
        jQuery(this).addClass('active');
    })

    var count = 0;
    jQuery('.product-nav .next').click(function(){
        count++;
        var total = jQuery(this).parents('.product-image-wrapper').find('.product-image-list a').length;
        if (count == total){
            jQuery(this).parents('.product-image-wrapper').find('.product-image-list a').each(function(){
                if (jQuery(this).data('order') == 1) {
                    jQuery(this).trigger('click');
                }
            })
            count = 0;
        }else {
            var next = jQuery(this).parents('.product-image-wrapper').find('.product-image-list a.active').next();
            next.trigger('click');
        }
    })

    jQuery('.product-nav .prev').click(function(){
        var total = jQuery(this).parents('.product-image-wrapper').find('.product-image-list a').length;
        if (count == 0){
            jQuery(this).parents('.product-image-wrapper').find('.product-image-list a').each(function(){
                if (jQuery(this).data('order') == total) {
                    jQuery(this).trigger('click');
                }
            })
            count = total;
        }else {
            var prev = jQuery(this).parents('.product-image-wrapper').find('.product-image-list a.active').prev();
            prev.trigger('click');
            count--;
        }
    })

    jQuery('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        items:1,
        navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"]
    })

    jQuery('.btn-add-cart button').click(function(){

        var dataProduct = jQuery(this).attr('data-product');
        var productId = jQuery(this).attr('data-id');
        if(!dataProduct){
            window.location.href = jQuery(this).attr('data-addcart');
        }else{
            // // data-toggle="modal" data-target="#productModal"
            var images = JSON.parse(dataProduct);
            var url = mainUrl +'/wp-json/api/v1/get-woocomerce-product?productId='+productId;
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    result = JSON.parse(result);
                    setColorList(result,jQuery('#productModal').find('.product-color-select'));
                    setListSize(result[0],jQuery('#productModal .product-size-select ul'));
                    setQuantity(result[0],jQuery('#productModal').find('.product-quantity-list'));
                    setPrice(result[0],jQuery('#productModal').find('.product-price'));
                    // // setImage(images[0],jQuery('#productModal').find('.product-image img'));
                    setListImages(images, jQuery('.product-types-list ul'));
                    setValueInput();
                    jQuery('#productModal').modal('show');

                }).catch(error => {
                console.error(error);
            });


        }
    })
});

function setValueInput() {
    // set product id
    var productId = jQuery('.ptx-product-types-list ul .active').attr('data-id');
    var size = jQuery('.ptx-product-size-select ul .active').attr('data-name');
    var color = jQuery('.ptx-product-color-select ul .active').attr('data-name');

    if(productId && size && color.length) {
        var endpoint = buildUrl(productId, color, size);
        var loading = mainUrl + '/wp-content/themes/ptxstore/assets/images/loading-page.gif';
        jQuery('#productModal').find('.product-image img').attr('src',loading);
        fetch(endpoint)
            .then(response => response.json())
            .then(result => {
                result = JSON.parse(result);
                jQuery('#sizeSelect').val(size);
                jQuery('#colorSelect').val(color);
                jQuery('#inVariable').val(result.variation_id);
                // setColorList(result,jQuery('#productModal').find('.product-color-select'));
                setListSize(result,jQuery('#productModal .product-size-select ul'));
                setPrice(result,jQuery('#productModal').find('.product-price'));
                setImage(result,jQuery('#productModal').find('.product-image img'));
            }).catch(error => {
            console.error(error);
        });
    }
}

function buildUrl(id,color,size) {
    var url = mainUrl +'/wp-json/api/v1/get-woocomerce-product?productId='+id+'&pa_color='+color+'&pa_size='+size;
    return url;
}

function setColorList(data,parent){
    var html = "";
    data.forEach((value,key) => {
        html += ` <li class="fw-bold `+(key == 0 ? 'active':'')+`" data-name="`+value.attributes.attribute_pa_color+`" data-key="`+key+`">
                    <div class="color-circle">
                        <div class="circle" style="background-color:`+ value.attributes.color_hex +`;"></div>
                    </div>
                </li>`;
        if (key == 0){
            parent.find('.product-color-title .color').text(value.attributes.attribute_pa_color);
        }                       
    })
    parent.find('ul').html(html);
}

function setQuantity(data,parent){
    parent.find('.quantity').text(data.min_qty);
}

function setPrice(data,parent) {
    parent.find('.price').text((new Intl.NumberFormat().format(data.display_price)) + currency);
    parent.find('.small-price').text((new Intl.NumberFormat().format(data.display_regular_price)) + currency);
}

function setListImages(data, parent) {
    var html = "";
    data.forEach(function (item, key) {
        html += `<li class="type-image-wrapper `+(key == 0 ? 'active':'')+`" data-name="`+ item.name +`" data-id="`+ item.id +`" data-url="`+ item.url +`">
                    <div class="type-image">
                        <img src="`+ item.image +`" alt="image cate list">
                    </div>
                </li>`;
    });

    parent.html(html);
}

function setListSize(data, parent) {
    var html = "";
    if( data.attributes.all_size  && data.attributes.all_size.length > 0 ) {
        data.attributes.all_size.forEach(function (item, key) {

            html += `<li class="fw-bold `+(key == 0 ? 'active':'')+`" data-name="`+ item.toLowerCase() +`">`+ item +`</li>`;
        });
    }else{
        html += `<li class="fw-bold active" data-name="`+ data.attributes.attribute_pa_size.toLowerCase() +`">`+ data.attributes.attribute_pa_size.toUpperCase() +`</li>`;
    }

    parent.html(html);
}

// function setImage(data,parent) {
//     parent.attr('src',data.image);
// }

function setImage(data,parent) {
    parent.attr('src',data.image.url);
}

jQuery('#addToCart').on('hidden.bs.modal', function () {
    window.location.reload();
})




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

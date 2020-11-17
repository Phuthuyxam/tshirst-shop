<?php include 'elements/header.php' ?>
<div class="main-wrapper">
    <div class="container custom-container">
        <div class="banner-wrapper">
            <img src="assets/images/banner.jpg" alt="" >
        </div>
        <div class="recommend-wrapper">
            <div class="recommend-heading">
                <h2 class="fs-lg fw-bold">Recommended For You</h2>
            </div>
            <div class="recommend-content">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-sm-3 col-2/3">
                        <div class="item-wrapper">
                            <a href="#">
                                <div class="item-thumb">
                                    <img src="assets/images/medium.jpg" alt="">
                                </div>
                                <div class="item-content">
                                    <div class="item-title">
                                        <h3 class="fs-sm">SKULL MOUSEPAD BEST GIFT ZD04</h3>
                                    </div>
                                    <div class="item-price">
                                        <span class="price fs-md">$22.99</span>
                                        <span class="small-price fs-xs ">$26.43</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-3 col-2/3">
                        <div class="item-wrapper">
                            <a href="#">
                                <div class="item-thumb">
                                    <img src="assets/images/medium1.jpg" alt="">
                                </div>
                                <div class="item-content">
                                    <div class="item-title">
                                        <h3 class="fs-sm">SKULL MOUSEPAD BEST GIFT ZD04</h3>
                                    </div>
                                    <div class="item-price">
                                        <span class="price fs-md">$22.99</span>
                                        <span class="small-price fs-xs ">$26.43</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-3 col-2/3">
                        <div class="item-wrapper">
                            <a href="#">
                                <div class="item-thumb">
                                    <img src="assets/images/medium2.jpg" alt="">
                                </div>
                                <div class="item-content">
                                    <div class="item-title">
                                        <h3 class="fs-sm">SKULL MOUSEPAD BEST GIFT ZD04</h3>
                                    </div>
                                    <div class="item-price">
                                        <span class="price fs-md">$22.99</span>
                                        <span class="small-price fs-xs ">$26.43</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-3 col-2/3">
                        <div class="item-wrapper">
                            <a href="#">
                                <div class="item-thumb">
                                    <img src="assets/images/medium3.jpg" alt="">
                                </div>
                                <div class="item-content">
                                    <div class="item-title">
                                        <h3 class="fs-sm">SKULL MOUSEPAD BEST GIFT ZD04</h3>
                                    </div>
                                    <div class="item-price">
                                        <span class="price fs-md">$22.99</span>
                                        <span class="small-price fs-xs ">$26.43</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-categories-wrapper">
                <div class="top-categories-heading">
                    <h2 class="fs-lg fw-bold">Shop Top Categories</h2>
                </div>
                <div class="top-categories-content">
                    <div class="row">
                        <?php for( $i = 0 ; $i < 6 ; $i++): ?>
                        <div class="col-lg-2 col-xl-2 col-sm-3 col-6">
                            <a href="#">
                                <div class="cate-wrapper">
                                    <div class="cate-thumb">
                                        <img src="assets/images/thumb.jpg" alt="" srcset="">
                                    </div>
                                    <div class="cate-title">
                                        <span>Relationship</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="products-wrapper type1" style="background-image: url(assets/images/tumb1.jpg);">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-sm-12">
                        <a href="#">
                            <div class="product-banner-wrapper">
                                <img src="assets/images/tumb1.jpg" class="d-sm-none d-lg-block d-xl-block d-none" alt="">
                                <div class="product-banner-title">
                                    <h2 class="fs-3xl fw-extraBold">GIFT YOUR WIFE</h2>
                                    <h3 class="fs-lg">View More Designs</h3>
                                    <h4 class="fs-lg fw-bold">SHOP NOW <i class="fa fa-angle-right" aria-hidden="true"></i></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-sm-12 col-12">
                        <div class="list-product-wrapper">
                            <div class="row">
                                <?php for($i = 0; $i < 4 ; $i++): ?>
                                <div class="col-xl-6 col-lg-6 col-sm-3 custom-col">
                                    <div class="item-wrapper">
                                        <a href="#">
                                            <div class="item-thumb">
                                                <img src="assets/images/medium.jpg" alt="">
                                            </div>
                                            <div class="item-content">
                                                <div class="item-title">
                                                    <h3 class="fs-sm">SKULL MOUSEPAD BEST GIFT ZD04</h3>
                                                </div>
                                                <div class="item-price">
                                                    <span class="price fs-md">$22.99</span>
                                                    <span class="small-price fs-xs ">$26.43</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php endfor; ?>
                                <div class="d-lg-none col-6 custom-col" style="min-width: 165px;">
                                    <div class="item-wrapper" style="height: calc(100% - 15px);">
                                        <a href="#" style="height: 100%; display: flex;align-items: center;justify-content: center;">
                                            <h4 class="fs-lg fw-extraBold">SHOP NOW</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products-wrapper type2" style="background-image: url(assets/images/tumb22.jpg);">
                <div class="row">
                    <div class="col-12">
                        <a href="#">
                            <div class="product-banner-wrapper">
                                <img src="assets/images/tumb2.jpg" class="d-sm-none d-lg-block d-xl-block d-none" alt="">
                                <div class="product-banner-title">
                                    <div class="product-banner-text">
                                        <h2 class="fs-3xl fw-extraBold">GIFT YOUR Daughter</h2>
                                        <h3 class="fs-lg">View More Designs</h3>
                                        <h4 class="fs-lg fw-bold">SHOP NOW <i class="fa fa-angle-right" aria-hidden="true"></i></h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12">
                        <div class="list-product-wrapper">
                            <div class="row">
                                <?php for($i = 0; $i < 4 ; $i++): ?>
                                <div class="col-3 custom-col">
                                    <div class="item-wrapper">
                                        <a href="#">
                                            <div class="item-thumb">
                                                <img src="assets/images/medium.jpg" alt="">
                                            </div>
                                            <div class="item-content">
                                                <div class="item-title">
                                                    <h3 class="fs-sm">SKULL MOUSEPAD BEST GIFT ZD04</h3>
                                                </div>
                                                <div class="item-price">
                                                    <span class="price fs-md">$22.99</span>
                                                    <span class="small-price fs-xs ">$26.43</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php endfor; ?>
                                <div class="d-lg-none col-3 custom-col" style="min-width: 165px;">
                                    <div class="item-wrapper" style="height: calc(100% - 15px);">
                                        <a href="#" style="height: 100%; display: flex;align-items: center;justify-content: center;">
                                            <h4 class="fs-lg fw-extraBold">SHOP NOW</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products-wrapper type3" style="background-image: url(assets/images/tumb33.jpg);">
                <div class="row">
                    <div class="col-sm-12 d-xl-none d-lg-none d-sm-block ">
                        <a href="#">
                            <div class="product-banner-wrapper">
                                <div class="product-banner-title">
                                    <h2 class="fs-3xl fw-extraBold">GIFT YOUR HUSBAND</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-sm-12 col-12">
                        <div class="list-product-wrapper">
                            <div class="row">
                                <?php for($i = 0; $i < 4 ; $i++): ?>
                                <div class="col-xl-6 col-lg-6 col-sm-3 custom-col">
                                    <div class="item-wrapper">
                                        <a href="#">
                                            <div class="item-thumb">
                                                <img src="assets/images/medium.jpg" alt="">
                                            </div>
                                            <div class="item-content">
                                                <div class="item-title">
                                                    <h3 class="fs-sm">SKULL MOUSEPAD BEST GIFT ZD04</h3>
                                                </div>
                                                <div class="item-price">
                                                    <span class="price fs-md">$22.99</span>
                                                    <span class="small-price fs-xs ">$26.43</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php endfor; ?>
                                <div class="d-lg-none col-3 custom-col" style="min-width: 165px;">
                                    <div class="item-wrapper" style="height: calc(100% - 15px);">
                                        <a href="#" style="height: 100%; display: flex;align-items: center;justify-content: center;">
                                            <h4 class="fs-lg fw-extraBold">SHOP NOW</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 d-sm-none d-lg-block d-xl-block d-none">
                        <a href="#">
                            <div class="product-banner-wrapper">
                                <img src="assets/images/tumb3.jpg" alt="">
                                <div class="product-banner-title">
                                    <h2 class="fs-3xl fw-extraBold">GIFT YOUR HUSBAND</h2>
                                    <h3 class="fs-lg">View More Designs</h3>
                                    <h4 class="fs-lg fw-bold">SHOP NOW <i class="fa fa-angle-right" aria-hidden="true"></i></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'elements/footer.php' ?>
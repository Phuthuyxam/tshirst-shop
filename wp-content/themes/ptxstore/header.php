<?php
global $wp;
do_action('pveser_header');
?>
<body <?php body_class(); ?>>
<?php
    $topHeader = get_field('top_header_setting', 'option');
    $noticeHeader = get_field('notice_setting', 'option');
    $logoHeader = get_field('logo_header', 'option');

?>

<div class="top-header-wrapper">
    <div class="top-header-content d-flex fw-extraBold">
        <?php echo $topHeader ?>
    </div>
</div>
<div class="notification-wrapper">
    <div class="notification-content d-flex">
        <?php echo $noticeHeader ?>
    </div>
</div>
<header class="header">
    <div class="main-header-wrapper">
        <div class="container custom-container">
            <div class="header-content-wrapper" style="align-items: center;">
                <div class="d-xl-none d-lg-none">
                    <button class="btn btn-show-menu"><i class="fa fa-bars"></i></button>
                </div>
                <div class="header-logo-wrapper">
                    <a href="<?php echo get_bloginfo('url') ?>">
                        <img src="<?php echo $logoHeader ?>" alt="<?php echo get_bloginfo('name') ?>">
                    </a>
                </div>
                <div class="d-lg-none d-xl-none" style="flex-grow: 1;"></div>
                <div class="search-wrapper d-sm-none d-lg-flex d-xl-flex d-none" id="searchWrapper">
                    <div class="search-icon-wrapper">
                        <i class="fa fa-search icon-search" aria-hidden="true"></i>
                    </div>
                    <label class="label-search">What are you looking for?</label>
                    <div class="search-input-wrapper">
                        <div class="search-input">
                            <form action="<?php echo wc_get_page_permalink( 'shop' ); ?>" method="get">
                                <input type="text" id="search" class="form-control search" name="key">
                            </form>
                        </div>
                        <div class="line-bottom"></div>
                    </div>
                    <div class="search-close-icon">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="track-order d-sm-none d-lg-block d-xl-block fw-bold d-none">
                    <a href="#">Track your order</a>
                </div>
                <div class="search-mobile-icon d-lg-none d-xl-none d-sm-block fw-bold">
                    <a href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                </div>
                <div class="cart-icon fw-bold" style="position: relative">
                    <?php echo do_shortcode('[custom-techno-mini-cart]') ?>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-site">
        <div class="container custom-container">
            <div class="menu-box">
                <div class="d-xl-block d-lg-block d-sm-block">
                    <div class="menu-mobile-header d-lg-none d-xl-none">
                        <div class="menu-mobile-logo">
                            <div style="display: flex; flex-grow: 1; justify-content: space-between;">
                                <div class="mobile-logo">
                                    <a href="#">
                                        <img src="<?php echo __THEME_HOST ?>/assets/images/logo.jpg" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-hide-menu d-xl-none d-lg-none d-sm-block"><i class="fa fa-times"></i></button>
                    </div>


                    <div class="menu-mobile-wrapper">
                        <?php
                            wp_nav_menu(
                                array('theme_location'=>'main-menu',
                                    'container' => false,
                                    'menu_class' => 'main-menu',
                                    'container'  => 'ul'
                                )
                            );
                        ?>
                        <div class="bg-menu" style="width: 3rem;"></div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</header>

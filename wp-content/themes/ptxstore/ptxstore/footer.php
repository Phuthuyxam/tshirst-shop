<footer>
    <div class="container custom-container">
        <div class="footer-wrapper">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-8 col-12">
                    <div class="footer-categories">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-6">
                                <div class="footer-items-wrapper">
                                    <h4 class="fw-bold"> <?php echo get_field('fblock_1_title', 'option') ?> </h4>
                                    <?php echo get_field('fblock_1_content', 'option') ?>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-6">
                                <div class="footer-items-wrapper">
                                    <h4 class="fw-bold"><?php echo get_field('fblock_2_title', 'option') ?> </h4>
                                    <?php echo get_field('fblock_2_content', 'option') ?>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-12">
                                <div class="footer-items-wrapper">
                                    <h4 class="fw-bold"><?php echo get_field('fblock_3_title', 'option') ?></h4>
                                    <?php echo get_field('fblock_3_content', 'option') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-social">
        <div class="container custom-container">
            <div class="row" style="align-items: center;">
                <div class="col-6">
                    <div class="copy-right">
                        <span><?php echo get_field('cpblock_content', 'option') ?></span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="social-wrapper">
                        <a href="#">Terms & Privacy</a>
                        <a href="#">DMCA</a>
                        <div class="social">
                            <a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php do_action('pveser_footer'); ?>

<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<style>
    .checkout-section .woocommerce-input-wrapper {
        width: 100%;
    }
    .ptx-form {
        padding: 1rem .75rem;
    }
    .ptx-form-row {
        position: relative;
    }
    .ptx-form-row label {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        transition: .25s ease-in-out;
        transform-origin: top left;
    }
    .ptx-form-row .select2-selection {
        height: 45px;
        margin: 0 0 4px !important;
    }
    .ptx-form-row  .select2-selection__rendered {
        line-height: 45px !important;
    }
    #billing_country_field {
        display: none;
    }
    #billing_first_name_field {
        width: 100%;
    }
    #billing_address_1_field , #billing_state_field , #ptxpayment_debit_card_date_field {
        width: 60%;
        display: inline-block;
    }
    #billing_apt_suite_field , #billing_postcode_field, #ptxpayment_debit_card_cvv_field {
        width: 40%;
        display: inline-block;
    }
    .payment-header-title {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .ta-right {
        margin-left: auto;
    }
    .card-detail {
        display: flex;
        align-items: center;
    }
    #payment_checkout {
        margin-top: 40px;
    }
    .card-detail {
        margin: 20px 0px;
    }
    .show-card-info {
        padding: 15px;
        border: solid thin #ced4da;
    }
    .woocommerce-billing-fields h3 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    #payment_checkout .form-group .input-text {
        display: block;
        width: 100%;
        padding: 1rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    #customer_details {
        padding-top: 1rem !important;
    }
    .card-detail h3 {
        margin-bottom: 0px;
    }
    #place_order {
        width: 100%;
        text-align: center;
        margin: 20px 0px;
    }
</style>
<div class="container custom-container checkout-section" style="margin-top: 50px; margin-bottom: 50px">

    <?php
    do_action( 'woocommerce_before_checkout_form', $checkout );

    // If checkout registration is disabled and not logged in, the user cannot checkout.
    if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
        echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
        return;
    }

    ?>
    <div class="row">
        <div class="col-12">
            <h1 style="font-size: 1.8rem; color: #000000; font-weight: 700;"> Checkout </h1>
        </div>
    </div>
    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
        <div class="row">

            <div class="col-md-7">
                <?php if ( $checkout->get_checkout_fields() ) : ?>

                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                <div id="customer_details">

                        <?php do_action( 'woocommerce_checkout_billing' ); ?>


        <!--			<div class="col-2">-->
        <!--				--><?php //do_action( 'woocommerce_checkout_shipping' ); ?>
        <!--			</div>-->
                </div>

                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

            <?php endif; ?>
            </div>

            <div class="col-md-5">
                <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
                <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
                <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
                <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
            </div>

        </div>
    </form>

    <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>
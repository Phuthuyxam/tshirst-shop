<?php


class Woocomerce_setup
{
    public function __construct(){
        add_action( 'init', [$this,'addTaxonomy'] );

        add_action( 'init', [$this,'addTaxonomyClassProduct'] );

        add_filter( 'woocommerce_checkout_fields', [$this, 'checkoutField'] );
        // add field
        add_action( 'woocommerce_billing_fields',[$this, 'custom_woocommerce_billing_fields'] );

        add_filter("woocommerce_checkout_fields", [$this, "order_fields"]);
        // Custom checkout fields validation
        add_action( 'woocommerce_checkout_process', [$this, 'custom_checkout_field_process'] );
        // Save custom checkout fields the data to the order
        add_action( 'woocommerce_checkout_create_order', [$this, 'custom_checkout_field_update_meta'] );

        add_action( 'woocommerce_after_checkout_billing_form', [$this, 'custom_checkout_fields_before_billing_details'] );

        add_action( 'woocommerce_thankyou', [$this , 'kia_display_order_data'], 20 );

        add_action( 'woocommerce_view_order',[$this, 'kia_display_order_data'], 20 );

        add_action( 'woocommerce_admin_order_data_after_order_details', [$this, 'kia_display_order_data_in_admin'] );

        add_filter('woocommerce_checkout_fields', [$this, 'addBootstrapToCheckoutFields'] );

        add_action( 'woocommerce_after_checkout_form', [$this, 'addCheckoutScript'] );

        add_shortcode( 'custom-techno-mini-cart', [$this, 'custom_mini_cart'] );

    }

    public function addTaxonomy() {
        $labels = array(
            'name' => 'Loại sản phẩm',
            'singular' => 'Loại sản phẩm',
            'menu_name' => 'Loại sản phẩm'
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'rewrite' => array(
                'slug' => 'loai-san-pham'
            ),
        );

        register_taxonomy('ptx_product_type', 'product', $args);
    }

    public function addTaxonomyClassProduct() {
        $labels = array(
            'name' => 'Lớp sản phẩm',
            'singular' => 'Lớp sản phẩm',
            'menu_name' => 'Lớp sản phẩm'
        );

        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            'rewrite' => array(
                'slug' => 'lop-san-pham'
            ),
        );

        register_taxonomy('ptx_product_class', 'product', $args);
    }
    // setup checkout field
    public function checkoutField($fields) {
        /**
        Remove all possible fields
         **/
        // Billing fields
        unset( $fields['billing']['billing_company'] );
        unset( $fields['billing']['billing_phone'] );
//        unset( $fields['billing']['billing_state'] );
//        unset( $fields['billing']['billing_first_name'] );
        unset( $fields['billing']['billing_last_name'] );
//        unset( $fields['billing']['billing_address_1'] );
        unset( $fields['billing']['billing_address_2'] );
//        unset( $fields['billing']['billing_city'] );
//        unset( $fields['billing']['billing_postcode'] );
//        unset( $fields['billing']['billing_country'] );
        // Shipping fields
        unset( $fields['shipping']['shipping_company'] );
        unset( $fields['shipping']['shipping_phone'] );
        unset( $fields['shipping']['shipping_state'] );
        unset( $fields['shipping']['shipping_first_name'] );
        unset( $fields['shipping']['shipping_last_name'] );
        unset( $fields['shipping']['shipping_address_1'] );
        unset( $fields['shipping']['shipping_address_2'] );
        unset( $fields['shipping']['shipping_city'] );
        unset( $fields['shipping']['shipping_postcode'] );
        // Order fields
        unset( $fields['order']['order_comments'] );
        return $fields;
    }


    public function custom_woocommerce_billing_fields( $fields ) {

        $fields['billing_apt_suite'] = array(
//            'placeholder' => _x('Apt, Suite', 'placeholder', 'woocommerce'), // Add custom field placeholder
            'label'    => 'Apt, Suite',
            'required' => false, // if field is required or not
            'clear' => false, // add clear or not
            'type' => 'text', // add field type
            'class' => array('apt_suite-field'),    // add class name
            'priority' => 50
        );

        return $fields;
    }


    public function order_fields($fields) {
        $fields["billing"]["billing_country"]["priority"] = 200;
        $fields["billing"]["billing_country"]["label"] = "";

        $fields["billing"]["billing_email"]["label"] = "Email";
//        $fields["billing"]["billing_email"]["placeholder"] = "Email";
        $fields["billing"]["billing_email"]["priority"] = 1;

        $fields["billing"]["billing_first_name"]["label"] = "Full Name";
//        $fields["billing"]["billing_first_name"]["placeholder"] = "Full Name";
        $fields["billing"]["billing_first_name"]["required"] = true;
        $fields["billing"]["billing_first_name"]["priority"] = 2;

        $fields["billing"]["billing_address_1"]["label"] = "Adress";
        $fields["billing"]["billing_address_1"]["placeholder"] = "";
        $fields["billing"]["billing_address_1"]["priority"] = 3;

        $fields["billing"]["billing_postcode"]["label"] = "Zip";
        $fields["billing"]["billing_postcode"]["placeholder"] = "";
        $fields["billing"]["billing_postcode"]["priority"] = 91;

        $fields["billing"]["billing_city"]["label"] = "City";
        $fields["billing"]["billing_city"]["placeholder"] = "";
        $fields["billing"]["billing_city"]["priority"] = 51;
//
//        $fields["billing"]["billing_postcode"]["label"] = "";
//        $fields["billing"]["billing_postcode"]["placeholder"] = "Zip";
//        $fields["billing"]["billing_postcode"]["priority"] = 91;

        return $fields;
    }

    public function custom_checkout_fields_before_billing_details(){
        $domain = 'woocommerce';
        $checkout = WC()->checkout;

        echo '<div id="payment_checkout">';

        echo '<div class="payment-header-title">';
        echo '<h3>' . __('Payment Info') . '</h3> ';

        echo '<div class="ta-right flex-grow flex-row-reverse d-n md:flex">
                <img class="self-center ml-p5" style="height:30px;" src="https://cdn.32pt.com/public/sl-retail/assets/logos/norton-seal.png" >
                <img class="self-center ml-p5" style="height:22px;" src="https://cdn.32pt.com/public/sl-retail/assets/logos/ssl-seal.svg">
                </div>';
        echo '</div>';

        ?>
        <div class="show-card-info">
            <div class="card-detail">
                <input type="radio" name="credit-card" value="credit-card" checked="checked" style="margin-right: 5px">
                <h3>Card</h3>

                <div class="flex-grow ta-right self-center" data-reactid=".1mzdcqbn1wc.9.0.0.2.0.0.0.b.0.1.0.1">
                    <img style="height:20px;opacity:0.4;" class="mr-p25" src="https://cdn.32pt.com/public/sl-retail/assets/logos/visa-icon.svg">
                    <img style="height:20px;opacity:0.4;" class="mr-p25" src="https://cdn.32pt.com/public/sl-retail/assets/logos/amex-icon.svg">
                    <img style="height:20px;opacity:0.4;" class="mr-p25" src="https://cdn.32pt.com/public/sl-retail/assets/logos/mastercard-icon.svg">
                    <img style="height:20px;opacity:0.4;" class="mr-p25" src="https://cdn.32pt.com/public/sl-retail/assets/logos/discover-icon.svg" >
                </div>
            </div>
        <?php

        woocommerce_form_field( 'ptxpayment_debit_card_number', array(
            'type'          => 'text',
            'label'         => __('', $domain ),
            'placeholder'   => __('Debit Or Credit Card Number', $domain ),
            'class'         => array('debit_card_number form-group'),
            'required'      => true, // or false
        ), $checkout->get_value( 'ptxpayment_debit_card_number' ) );

        woocommerce_form_field( 'ptxpayment_debit_card_date', array(
            'type'          => 'text',
            'label'         => __('', $domain ),
            'placeholder'   => __('MM / YY', $domain ),
            'class'         => array('debit_card_date form-group'),
            'required'      => true, // or false
        ), $checkout->get_value( 'ptxpayment_debit_card_date' ) );

        woocommerce_form_field( 'ptxpayment_debit_card_cvv', array(
            'type'          => 'text',
            'label'         => __('', $domain ),
            'placeholder'   => __('CVV', $domain ),
            'class'         => array('debit_card_cvv form-group'),
            'required'      => true, // or false
        ), $checkout->get_value( 'ptxpayment_debit_card_cvv' ) );


        echo '</div> </div>';
    }
    public function custom_checkout_field_process() {

        if ( isset($_POST['ptxpayment_debit_card_number']) && !empty($_POST['ptxpayment_debit_card_number']) ) {

            $cardTypes = ['Visa' , "Master", "American" , "Discover"];
            $validateCard = false;
            $inputString = str_replace(" ", "", $_POST['ptxpayment_debit_card_number']);
            foreach ($cardTypes as $card) {
                if($this->validateCC($inputString , $card) ) {
                    $validateCard = true;
                    break;
                }
            }

            if(!$validateCard) {
                $notice = "Credit card invalid. Please make sure that you entered a valid credit card ";
                wc_add_notice( __( $notice ), 'error' );
            }
        }else{
            wc_add_notice( __( 'Number card is required' ), 'error' );
        }

        if ( isset($_POST['ptxpayment_debit_card_date']) && !empty($_POST['ptxpayment_debit_card_date']) ) {

            $validateCard = false;
            if($this->validateExpirationDate($_POST['ptxpayment_debit_card_date']) ) {
                $validateCard = true;
            }
            if(!$validateCard) {
                $notice = "Your card has expired. Please check the card information";
                wc_add_notice( __( $notice ), 'error' );
            }
        }else{
            wc_add_notice( __( 'Expiration date is required' ), 'error' );
        }

        if ( isset($_POST['ptxpayment_debit_card_cvv']) && !empty($_POST['ptxpayment_debit_card_cvv']) ) {

            $cardTypes = ['Visa' , "Master", "American" , "Discover"];
            $validateCard = false;

            foreach ($cardTypes as $card) {

                if($this->validateCvv($_POST['ptxpayment_debit_card_cvv'] , $card) ) {
                    $validateCard = true;

                    break;
                }
            }

            if(!$validateCard) {
                $notice = "Credit card cvv invalid. Please make sure that you entered a valid credit card cvv ";
                wc_add_notice( __( $notice ), 'error' );
            }
        }else{
            wc_add_notice( __( 'Cvv number is required' ), 'error' );
        }

    }

    public function custom_checkout_field_update_meta( $order ){
        if( isset($_POST['ptxpayment_debit_card_number']) && ! empty($_POST['ptxpayment_debit_card_number']) )
            $order->update_meta_data( 'ptxpayment_debit_card_number', sanitize_text_field( $_POST['ptxpayment_debit_card_number'] ) );
        if( isset($_POST['ptxpayment_debit_card_date']) && ! empty($_POST['ptxpayment_debit_card_date']) )
            $order->update_meta_data( 'ptxpayment_debit_card_date', sanitize_text_field( $_POST['ptxpayment_debit_card_date'] ) );
        if( isset($_POST['ptxpayment_debit_card_cvv']) && ! empty($_POST['ptxpayment_debit_card_cvv']) )
            $order->update_meta_data( 'ptxpayment_debit_card_cvv', sanitize_text_field( $_POST['ptxpayment_debit_card_cvv'] ) );
        if( isset($_POST['billing_apt_suite']) && ! empty($_POST['billing_apt_suite']) )
            $order->update_meta_data( 'billing_apt_suite', sanitize_text_field( $_POST['billing_apt_suite'] ) );
    }

    // display the extra data on order received page and my-account order review
    function kia_display_order_data( $order_id ){
        $order = wc_get_order( $order_id ); ?>
        <h2><?php _e( 'Credit card info' ); ?></h2>
        <table class="shop_table shop_table_responsive additional_info">
            <tbody>
            <tr>
                <th><?php _e( 'Card Number:' ); ?></th>
                <td><?php echo $order->get_meta( 'ptxpayment_debit_card_number' ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Expiration Date:' ); ?></th>
                <td><?php echo $order->get_meta( 'ptxpayment_debit_card_date' ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Card cvv:' ); ?></th>
                <td><?php echo $order->get_meta( 'ptxpayment_debit_card_cvv' ); ?></td>
            </tr>
            </tbody>
        </table>
    <?php }

    // display the extra data in the order admin panel
    function kia_display_order_data_in_admin( $order ){  ?>
        <div class="order_data_column">
            <h4><?php _e( 'Credit card info', 'woocommerce' ); ?></h4>
            <?php
            echo '<p><strong>' . __( 'Card Number' ) . ':</strong>' . $order->get_meta( 'ptxpayment_debit_card_number' ) . '</p>';
            echo '<p><strong>' . __( 'Exp Date' ) . ':</strong>' . $order->get_meta( 'ptxpayment_debit_card_date' ) . '</p>';
            echo '<p><strong>' . __( 'Card cvv' ) . ':</strong>' . $order->get_meta( 'ptxpayment_debit_card_cvv' ) . '</p>'; ?>
        </div>
    <?php }

    public function validateCC($cc_num, $type) {

        if($type == "American") {
            $denum = "American Express";
        } elseif($type == "Dinners") {
            $denum = "Diner's Club";
        } elseif($type == "Discover") {
            $denum = "Discover";
        } elseif($type == "Master") {
            $denum = "Master Card";
        } elseif($type == "Visa") {
            $denum = "Visa";
        }

        if($type == "American") {
            $pattern = "/^([34|37]{2})([0-9]{13})$/";//American Express
            if (preg_match($pattern,$cc_num)) {
                $verified = true;
            } else {
                $verified = false;
            }


        } elseif($type == "Dinners") {
            $pattern = "/^([30|36|38]{2})([0-9]{12})$/";//Diner's Club
            if (preg_match($pattern,$cc_num)) {
                $verified = true;
            } else {
                $verified = false;
            }


        } elseif($type == "Discover") {
            $pattern = "/^([6011]{4})([0-9]{12})$/";//Discover Card
            if (preg_match($pattern,$cc_num)) {
                $verified = true;
            } else {
                $verified = false;
            }


        } elseif($type == "Master") {
            $pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
            if (preg_match($pattern,$cc_num)) {
                $verified = true;
            } else {
                $verified = false;
            }


        } elseif($type == "Visa") {
            $pattern = "/^([4]{1})([0-9]{12,15})$/";//Visa
            if (preg_match($pattern,$cc_num)) {
                $verified = true;
            } else {
                $verified = false;
            }

        }

        return $verified;
    }

    public function validateExpirationDate($date) {
        $dateInput = explode("/" , $date);
        $expires = DateTime::createFromFormat('my', $dateInput[0].$dateInput[1]);
        $now     = new DateTime();

        if ($expires < $now)
            return false;
        return true;
    }

    public function validateCvv($cvv ,  $cardType) {
        switch (($cardType)) {
            case 'Master':
                $digits = 3;
                break;
            case 'Visa':
                $digits = 3;
                break;
            case 'Discover':
                $digits = 3;
                break;
            case 'American':
                $digits = 4;
                break;
            default:
                return false;
        }

        if ((strlen($cvv) == $digits)
            && (strspn($cvv, '0123456789') == $digits)
        ) {
            return true;
        }

        return false;
    }

    public function addBootstrapToCheckoutFields($fields) {
        foreach ($fields as &$fieldset) {
            foreach ($fieldset as &$field) {
                // if you want to add the form-group class around the label and the input
                $field['class'][] = 'form-group ptx-form-row';

                // add form-control to the actual input
                $field['input_class'][] = 'form-control ptx-form';
            }
        }
        return $fields;
    }

    public function addCheckoutScript() {
        ?>
        <script type="text/javascript">

            jQuery(document).ready(function() {
                jQuery('.ptx-form').each(function (item) {
                    var value = jQuery(this).val();
                    if (value !== "") {
                        jQuery(this).parents('.ptx-form-row').find('label').css('transform', 'scale(.8) translateY(-2.2rem)');
                    }
                });

                jQuery('.ptx-form').on('change', function () {
                    jQuery(this).parents('.ptx-form-row').find('label').css('transform', 'translateY(-50%)');
                });

                jQuery('.ptx-form').on('focus', function () {
                    jQuery(this).parents('.ptx-form-row').find('label').css('transform', 'scale(.8) translateY(-2.2rem)');
                });

                jQuery('.country-current-choose').html(jQuery('#billing_country :selected').text());
                jQuery('.action-change-country').on('click', function () {
                    jQuery(this).parents('span').hide();
                    jQuery('#billing_country_field').show();
                    jQuery('#billing_country').select2();
                });

                let ccNumberInput = jQuery('#ptxpayment_debit_card_number'),
                    ccNumberPattern = /^\d{0,16}$/g,
                    ccNumberSeparator = " ",
                    ccNumberInputOldValue,
                    ccNumberInputOldCursor,

                    ccExpiryInput = jQuery('#ptxpayment_debit_card_date'),
                    ccExpiryPattern = /^\d{0,4}$/g,
                    ccExpirySeparator = "/",
                    ccExpiryInputOldValue,
                    ccExpiryInputOldCursor,

                    ccCVCInput = jQuery('#ptxpayment_debit_card_cvv_field'),
                    ccCVCPattern = /^\d{0,3}$/g,
                    ccCvvSeparator = "",
                    ccCvvInputOldValue,
                    ccCvvInputOldCursor,

                    mask = (value, limit, separator) => {
                        var output = [];
                        for (let i = 0; i < value.length; i++) {
                            if (i !== 0 && i % limit === 0) {
                                output.push(separator);
                            }

                            output.push(value[i]);
                        }

                        return output.join("");
                    },
                    unmask = (value) => value.replace(/[^\d]/g, ''),
                    checkSeparator = (position, interval) => Math.floor(position / (interval + 1)),
                    ccNumberInputKeyDownHandler = (e) => {
                        let el = e.target;
                        ccNumberInputOldValue = el.value;
                        ccNumberInputOldCursor = el.selectionEnd;
                    },
                    ccNumberInputInputHandler = (e) => {
                        let el = e.target,
                            newValue = unmask(el.value),
                            newCursorPosition;

                        if (newValue.match(ccNumberPattern)) {
                            newValue = mask(newValue, 4, ccNumberSeparator);

                            newCursorPosition =
                                ccNumberInputOldCursor - checkSeparator(ccNumberInputOldCursor, 4) +
                                checkSeparator(ccNumberInputOldCursor + (newValue.length - ccNumberInputOldValue.length), 4) +
                                (unmask(newValue).length - unmask(ccNumberInputOldValue).length);

                            el.value = (newValue !== "") ? newValue : "";
                        } else {
                            el.value = ccNumberInputOldValue;
                            newCursorPosition = ccNumberInputOldCursor;
                        }

                        el.setSelectionRange(newCursorPosition, newCursorPosition);

                        highlightCC(el.value);
                    },
                    highlightCC = (ccValue) => {
                        let ccCardType = '',
                            ccCardTypePatterns = {
                                amex: /^3/,
                                visa: /^4/,
                                mastercard: /^5/,
                                disc: /^6/,

                                genric: /(^1|^2|^7|^8|^9|^0)/,
                            };

                        for (const cardType in ccCardTypePatterns) {
                            if (ccCardTypePatterns[cardType].test(ccValue)) {
                                ccCardType = cardType;
                                break;
                            }
                        }

                        let activeCC = document.querySelector('.cc-types__img--active'),
                            newActiveCC = document.querySelector(`.cc-types__img--${ccCardType}`);

                        if (activeCC) activeCC.classList.remove('cc-types__img--active');
                        if (newActiveCC) newActiveCC.classList.add('cc-types__img--active');
                    },
                    ccExpiryInputKeyDownHandler = (e) => {
                        let el = e.target;
                        ccExpiryInputOldValue = el.value;
                        ccExpiryInputOldCursor = el.selectionEnd;
                    },
                    ccExpiryInputInputHandler = (e) => {
                        let el = e.target,
                            newValue = el.value;

                        newValue = unmask(newValue);
                        if (newValue.match(ccExpiryPattern)) {
                            newValue = mask(newValue, 2, ccExpirySeparator);
                            el.value = newValue;
                        } else {
                            el.value = ccExpiryInputOldValue;
                        }
                    };

                    ccCvvInputKeyDownHandler = (e) => {
                        let el = e.target;
                        ccCvvInputOldValue = el.value;
                        ccCvvInputOldCursor = el.selectionEnd;
                    },
                    ccCvvInputInputHandler = (e) => {
                        let el = e.target,
                            newValue = el.value;

                        newValue = unmask(newValue);
                        if (newValue.match(ccCVCPattern)) {
                            newValue = mask(newValue, 2, ccCvvSeparator);
                            el.value = newValue;
                        } else {
                            el.value = ccCvvInputOldValue;
                        }
                    };



                ccNumberInput.on('keydown', ccNumberInputKeyDownHandler);
                ccNumberInput.on('input', ccNumberInputInputHandler);

                ccExpiryInput.on('keydown', ccExpiryInputKeyDownHandler);
                ccExpiryInput.on('input', ccExpiryInputInputHandler);

                ccCVCInput.on('keydown', ccCvvInputKeyDownHandler);
                ccCVCInput.on('input', ccCvvInputInputHandler);

            });
        </script>
        <?php
    }

    public function custom_mini_cart() {
        echo '<a href="'. wc_get_cart_url() .'"> ';
        echo '<img src="'. get_template_directory_uri() .'/assets/images/shopping-cart.png" width="30px" alt="mini-cart">';
        echo '<div class="basket-item-count" style="display: inline; text-align: center; color: #ffffff; position: absolute; right: -12px; top: -7px; width: 20px; height: 20px; line-height: 20px; border-radius: 100%; background: #0984e3; ">';
        echo '<span class="cart-items-count count">';
        echo WC()->cart->get_cart_contents_count();
        echo '</span>';
        echo '</div>';
        echo '</a>';
    }

}

$ptxWooSetup = new Woocomerce_setup();
<?php


class Woocomerce_setup
{
    public function __construct(){
        add_action( 'init', [$this,'addTaxonomy'] );
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

//        $fields['billing_fullname'] = array(
//            'placeholder' => _x('Full Name', 'placeholder', 'woocommerce'), // Add custom field placeholder
//            'required' => true, // if field is required or not
//            'clear' => false, // add clear or not
//            'type' => 'text', // add field type
//            'class' => array('fullname-field'),
//            'priority' => 90// add class name
//        );

//        $fields['billing_address'] = array(
//            'placeholder' => _x('Adress', 'placeholder', 'woocommerce'), // Add custom field placeholder
//            'required' => true, // if field is required or not
//            'clear' => false, // add clear or not
//            'type' => 'text', // add field type
//            'class' => array('adress-field'),    // add class name
//            'priority' => 91
//        );
        $fields['billing_apt_suite'] = array(
            'placeholder' => _x('Apt, Suite', 'placeholder', 'woocommerce'), // Add custom field placeholder
            'required' => false, // if field is required or not
            'clear' => false, // add clear or not
            'type' => 'text', // add field type
            'class' => array('apt_suite-field'),    // add class name
            'priority' => 50
        );

//        $fields['billing_city'] = array(
//            'placeholder' => _x('City', 'placeholder', 'woocommerce'), // Add custom field placeholder
//            'required' => false, // if field is required or not
//            'clear' => false, // add clear or not
//            'type' => 'text', // add field type
//            'class' => array('city-field'),    // add class name
//            'priority' => 93
//        );

        $fields['billing_state'] = array(
            'placeholder' => _x('State', 'placeholder', 'woocommerce'), // Add custom field placeholder
            'required' => false, // if field is required or not
            'clear' => false, // add clear or not
            'type' => 'text', // add field type
            'class' => array('state-field'),    // add class name
            'priority' => 94
        );

        return $fields;
    }


    public function order_fields($fields) {
        $fields["billing"]["billing_country"]["priority"] = 200;
        $fields["billing"]["billing_country"]["label"] = "";

        $fields["billing"]["billing_email"]["label"] = "";
        $fields["billing"]["billing_email"]["placeholder"] = "Email";
        $fields["billing"]["billing_email"]["priority"] = 1;

        $fields["billing"]["billing_first_name"]["label"] = "";
        $fields["billing"]["billing_first_name"]["placeholder"] = "Full Name";
        $fields["billing"]["billing_first_name"]["required"] = true;
        $fields["billing"]["billing_first_name"]["priority"] = 2;

        $fields["billing"]["billing_address_1"]["label"] = "";
        $fields["billing"]["billing_address_1"]["placeholder"] = "Adress";
        $fields["billing"]["billing_address_1"]["priority"] = 3;

        $fields["billing"]["billing_postcode"]["label"] = "";
        $fields["billing"]["billing_postcode"]["placeholder"] = "Zip";
        $fields["billing"]["billing_postcode"]["priority"] = 91;

        $fields["billing"]["billing_city"]["label"] = "";
        $fields["billing"]["billing_city"]["placeholder"] = "City";
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

        echo '<h3>' . __('Payment Info') . '</h3>';

        woocommerce_form_field( 'ptxpayment_debit_card_number', array(
            'type'          => 'text',
            'label'         => __('', $domain ),
            'placeholder'   => __('Debit Or Credit Card Number', $domain ),
            'class'         => array('debit_card_number'),
            'required'      => true, // or false
        ), $checkout->get_value( 'ptxpayment_debit_card_number' ) );

        woocommerce_form_field( 'ptxpayment_debit_card_date', array(
            'type'          => 'text',
            'label'         => __('', $domain ),
            'placeholder'   => __('MM / YY', $domain ),
            'class'         => array('debit_card_date'),
            'required'      => true, // or false
        ), $checkout->get_value( 'ptxpayment_debit_card_date' ) );

        woocommerce_form_field( 'ptxpayment_debit_card_cvv', array(
            'type'          => 'text',
            'label'         => __('', $domain ),
            'placeholder'   => __('CVV', $domain ),
            'class'         => array('debit_card_cvv'),
            'required'      => true, // or false
        ), $checkout->get_value( 'ptxpayment_debit_card_cvv' ) );


        echo '</div>';
    }
    public function custom_checkout_field_process() {

        if ( isset($_POST['ptxpayment_debit_card_number']) && !empty($_POST['ptxpayment_debit_card_number']) ) {

            $cardTypes = ['Visa' , "Master", "American" , "Discover"];
            $validateCard = false;

            foreach ($cardTypes as $card) {
                if($this->validateCC($_POST['ptxpayment_debit_card_number'] , $card) ) {
                    $validateCard = true;
                    break;
                }
            }

            if(!$validateCard) {
                $notice = "Credit card invalid. Please make sure that you entered a valid credit card ";
                wc_add_notice( __( $notice ), 'error' );
            }
        }

        if ( isset($_POST['ptxpayment_debit_card_number']) && !empty($_POST['ptxpayment_debit_card_number']) ) {

            $cardTypes = ['Visa' , "Master", "American" , "Discover"];
            $validateCard = false;

            foreach ($cardTypes as $card) {
                if($this->validateCC($_POST['ptxpayment_debit_card_number'] , $card) ) {
                    $validateCard = true;
                    break;
                }
            }

            if(!$validateCard) {
                $notice = "Credit card invalid. Please make sure that you entered a valid credit card ";
                wc_add_notice( __( $notice ), 'error' );
            }
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
        }

    }

    public function custom_checkout_field_update_meta( $order ){
        if( isset($_POST['ptxpayment_debit_card_number']) && ! empty($_POST['ptxpayment_debit_card_number']) )
            $order->update_meta_data( 'ptxpayment_debit_card_number', sanitize_text_field( $_POST['ptxpayment_debit_card_number'] ) );
        if( isset($_POST['ptxpayment_debit_card_date']) && ! empty($_POST['ptxpayment_debit_card_date']) )
            $order->update_meta_data( 'ptxpayment_debit_card_date', sanitize_text_field( $_POST['ptxpayment_debit_card_date'] ) );
        if( isset($_POST['ptxpayment_debit_card_cvv']) && ! empty($_POST['ptxpayment_debit_card_cvv']) )
            $order->update_meta_data( 'ptxpayment_debit_card_cvv', sanitize_text_field( $_POST['ptxpayment_debit_card_cvv'] ) );
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

}

$ptxWooSetup = new Woocomerce_setup();
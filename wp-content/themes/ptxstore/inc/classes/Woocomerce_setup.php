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
        unset( $fields['billing']['billing_state'] );
        unset( $fields['billing']['billing_first_name'] );
        unset( $fields['billing']['billing_last_name'] );
        unset( $fields['billing']['billing_address_1'] );
        unset( $fields['billing']['billing_address_2'] );
        unset( $fields['billing']['billing_city'] );
        unset( $fields['billing']['billing_postcode'] );
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

        $fields['billing_fullname'] = array(
            'placeholder' => _x('Full Name', 'placeholder', 'woocommerce'), // Add custom field placeholder
            'required' => true, // if field is required or not
            'clear' => false, // add clear or not
            'type' => 'text', // add field type
            'class' => array('fullname-field'),
            'priority' => 90// add class name
        );

        $fields['billing_address'] = array(
            'placeholder' => _x('Adress', 'placeholder', 'woocommerce'), // Add custom field placeholder
            'required' => true, // if field is required or not
            'clear' => false, // add clear or not
            'type' => 'text', // add field type
            'class' => array('adress-field'),    // add class name
            'priority' => 91
        );
        $fields['billing_apt_suite'] = array(
            'placeholder' => _x('Apt, Suite', 'placeholder', 'woocommerce'), // Add custom field placeholder
            'required' => false, // if field is required or not
            'clear' => false, // add clear or not
            'type' => 'text', // add field type
            'class' => array('apt_suite-field'),    // add class name
            'priority' => 92
        );

        $fields['billing_city'] = array(
            'placeholder' => _x('City', 'placeholder', 'woocommerce'), // Add custom field placeholder
            'required' => false, // if field is required or not
            'clear' => false, // add clear or not
            'type' => 'text', // add field type
            'class' => array('city-field'),    // add class name
            'priority' => 93
        );

        $fields['billing_state'] = array(
            'placeholder' => _x('State', 'placeholder', 'woocommerce'), // Add custom field placeholder
            'required' => false, // if field is required or not
            'clear' => false, // add clear or not
            'type' => 'text', // add field type
            'class' => array('state-field'),    // add class name
            'priority' => 94
        );

        $fields['billing_zip'] = array(
            'placeholder' => _x('Zip', 'placeholder', 'woocommerce'), // Add custom field placeholder
            'required' => false, // if field is required or not
            'clear' => false, // add clear or not
            'type' => 'text', // add field type
            'class' => array('zip-field'),    // add class name
            'priority' => 95
        );

        return $fields;
    }


    public function order_fields($fields) {
        $fields["billing"]["billing_country"]["priority"] = 200;
        $fields["billing"]["billing_country"]["label"] = "";
        $fields["billing"]["billing_email"]["label"] = "";
        return $fields;
    }


    public function custom_checkout_field_process() {
        if ( isset($_POST['_my_field_name']) && empty($_POST['_my_field_name']) )
            wc_add_notice( __( 'Please fill in "My 1st new field".' ), 'error' );
    }

    public function custom_checkout_field_update_meta( $order, $data ){
        if( isset($_POST['_my_field_name']) && ! empty($_POST['_my_field_name']) )
            $order->update_meta_data( '_my_field_name', sanitize_text_field( $_POST['_my_field_name'] ) );
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
}

$ptxWooSetup = new Woocomerce_setup();
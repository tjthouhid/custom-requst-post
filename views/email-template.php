<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'WC_ABSPATH' ) ) {
    define( 'WC_ABSPATH', WP_PLUGIN_DIR . '/' . plugin_basename( dirname( __FILE__ ) ) . '/woocommerce/' );
}


$wc_default_path = WC_ABSPATH."templates/";





wc_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading ) ,"",$wc_default_path);
$text_align = is_rtl() ? 'right' : 'left';
?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $customer['name'] ) ); ?></p>
<?php /* translators: %s: Order number */ ?>
<p><?php printf( esc_html__( 'We found %s Products that could work for you based on the sizes you requested.', 'woocommerce' ), esc_html( $customer['found'] ) ); ?></p>

<div style="margin-bottom: 40px;">
	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
		<thead>
			<tr>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Width', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Height', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( '', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
            <?php 
            if($customer['products']) {
                foreach ($customer['products_data'] as $product) {
            ?>
                <tr class="">
                    <td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align: middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; word-wrap:break-word;">
                        <!-- <img style="background: #365749; padding: 6px 12px; color: #fff; text-decoration: none display: block; width: auto; max-height: 260px;" src="<?php //echo $product['image'];?>" alt="Product image" /> -->
                        <br>
                        <?php echo wp_kses_post($product['title']);?>
                    </td>
                    <td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
                        <?php echo $product['width'] . 'cm';?>
                    </td>
                    <td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
                        <?php echo $product['height'] . 'cm';?>
                    </td>
                    <td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; vertical-align:middle; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
                        <?php echo '<a target="_blank" href="' . $product['url'] . '">View Product</a>'; ?>
                    </td>
                </tr>
            <?php }}?>
		</tbody>
	</table>
</div>
<?php 

    wc_get_template( 'views/email-footer.php' , array(
        'id' => $customer['id'],
        'site_url' => $customer['site_url'],
    ) ,
    "",
    untrailingslashit( CUSTOM_REQUEST_PLUGIN_DIR ) .'/'); 
?>

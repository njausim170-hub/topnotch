<?php
/**
 * TopNotch Mall Child - functions.
 *
 * @package TopNotchMallChild
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue the parent stylesheet, then the child stylesheet.
 */
add_action(
	'wp_enqueue_scripts',
	static function (): void {
		wp_enqueue_style( 'powerplug-parent', get_template_directory_uri() . '/style.css', [], null );
		wp_enqueue_style( 'powerplug-child', get_stylesheet_uri(), [ 'powerplug-parent' ], null );
	},
	30
);

/**
 * "Order on WhatsApp" button on single product pages.
 *
 * Renders under the Add to Cart button and opens WhatsApp with the product
 * name, link and price pre-filled. Uses the WhatsApp number set in
 * Appearance > Customize > PowerPlug Pro > Header & Contact.
 */
add_action(
	'woocommerce_after_add_to_cart_button',
	static function (): void {
		global $product;
		if ( ! $product instanceof \WC_Product ) {
			return;
		}
		$wa = '254708777192';
		if ( class_exists( '\PowerPlug\Customizer\Customizer' ) ) {
			$wa = (string) preg_replace( '/[^0-9]/', '', \PowerPlug\Customizer\Customizer::val( 'pp_whatsapp' ) );
		}
		if ( '' === $wa ) {
			return;
		}
		$name  = wp_strip_all_tags( $product->get_name() );
		$price = trim( wp_strip_all_tags( $product->get_price_html() ) );
		$url   = get_permalink( $product->get_id() );
		$text  = sprintf( 'Hello TopNotch Mall, I would like to order: %s (%s) - %s. Is it available?', $name, $url, $price );
		printf(
			'<a class="button tnm-order-whatsapp" href="https://wa.me/%s?text=%s" target="_blank" rel="noopener">%s</a>',
			esc_attr( $wa ),
			rawurlencode( $text ),
			esc_html__( 'Order on WhatsApp', 'powerplug-child' )
		);
	},
	20
);

/**
 * Example: override store contact details without touching the parent.
 */
add_filter(
	'powerplug_business_details',
	static function ( array $details ): array {
		// $details['phone'] = '+254 708 777192';
		return $details;
	}
);

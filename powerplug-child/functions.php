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
 * Appearance > Customize > TopNotch Mall > Header & Contact.
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
 * Lightweight front-end performance.
 *
 * Drops core requests most stores never use: the emoji-detection script and
 * its inline styles, plus wp-embed.js. Fewer bytes and fewer HTTP requests on
 * every page load, with no visual change. Safe, standard hardening.
 */
add_action(
	'init',
	static function (): void {
		if ( is_admin() ) {
			return;
		}
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		add_filter( 'emoji_svg_url', '__return_false' );
	}
);

add_action(
	'wp_footer',
	static function (): void {
		wp_dequeue_script( 'wp-embed' );
	},
	1
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

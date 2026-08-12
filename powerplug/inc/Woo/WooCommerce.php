<?php
declare( strict_types=1 );

namespace PowerPlug\Woo;

use PowerPlug\Core\Bootable;

defined( 'ABSPATH' ) || exit;

/**
 * WooCommerce presentation layer: badges, trust signals, sticky add-to-cart,
 * brand attribute, and Merchant-Center-friendly product data.
 */
final class WooCommerce implements Bootable {

	public function boot(): void {
		add_action( 'after_setup_theme', [ $this, 'columns' ] );
		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'stock_badge' ], 9 );
		add_action( 'woocommerce_single_product_summary', [ $this, 'trust_badges' ], 35 );
		add_action( 'woocommerce_after_single_product_summary', [ $this, 'delivery_estimate' ], 6 );
		add_action( 'wp_footer', [ $this, 'sticky_atc' ] );
		add_filter( 'woocommerce_product_tabs', [ $this, 'specifications_tab' ] );
		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'cart_fragments' ] );

		// Remove default WooCommerce sidebar (Pages/Archives/Categories widgets) on shop, category and product pages.
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	}

	public function columns(): void {
		add_filter( 'loop_shop_columns', static fn() => 4 );
		add_filter( 'loop_shop_per_page', static fn() => 24 );
	}

	/**
	 * Keep the header cart count and mini-cart drawer live on AJAX add-to-cart.
	 *
	 * @param array<string,string> $fragments
	 * @return array<string,string>
	 */
	public function cart_fragments( array $fragments ): array {
		$count = ( WC()->cart instanceof \WC_Cart ) ? WC()->cart->get_cart_contents_count() : 0;
		$fragments['span.pp-cart__count'] = '<span class="pp-cart__count">' . esc_html( (string) $count ) . '</span>';

		ob_start();
		woocommerce_mini_cart();
		$mini = (string) ob_get_clean();
		$fragments['div.pp-minicart__body'] = '<div class="pp-minicart__body">' . $mini . '</div>';

		return $fragments;
	}

	public function stock_badge(): void {
		global $product;
		if ( ! $product instanceof \WC_Product ) {
			return;
		}
		if ( $product->is_on_sale() ) {
			echo '<span class="pp-badge pp-badge--sale">' . esc_html__( 'Sale', 'powerplug' ) . '</span>';
		}
		if ( ! $product->is_in_stock() ) {
			echo '<span class="pp-badge pp-badge--oos">' . esc_html__( 'Out of stock', 'powerplug' ) . '</span>';
		}
	}

	public function trust_badges(): void {
		$badges = [
			__( 'Genuine & warranty-backed', 'powerplug' ),
			__( 'Nationwide delivery', 'powerplug' ),
			__( 'M-Pesa & Pay on delivery', 'powerplug' ),
		];
		echo '<ul class="pp-trust" aria-label="' . esc_attr__( 'Store guarantees', 'powerplug' ) . '">';
		foreach ( $badges as $b ) {
			echo '<li>' . esc_html( $b ) . '</li>';
		}
		echo '</ul>';
	}

	public function delivery_estimate(): void {
		echo '<p class="pp-delivery">' .
			esc_html__( 'Order before 5:00 PM for same-day dispatch in Nairobi. Delivery: Nairobi same or next day, other towns 1–2 days, remote areas 2–5 days.', 'powerplug' ) .
			'</p>';
	}

	public function sticky_atc(): void {
		if ( ! function_exists( 'is_product' ) || ! is_product() ) {
			return;
		}
		global $product;
		if ( ! $product instanceof \WC_Product ) {
			return;
		}
		printf(
			'<div class="pp-sticky-atc" role="region" aria-label="%1$s"><span class="pp-sticky-atc__name">%2$s</span><span class="pp-sticky-atc__price">%3$s</span><a class="pp-sticky-atc__btn" href="#" data-add-to-cart="%4$d">%5$s</a></div>',
			esc_attr__( 'Add to cart', 'powerplug' ),
			esc_html( $product->get_name() ),
			wp_kses_post( $product->get_price_html() ),
			(int) $product->get_id(),
			esc_html__( 'Add to Cart', 'powerplug' )
		);
	}

	/**
	 * @param array<string,array<string,mixed>> $tabs
	 * @return array<string,array<string,mixed>>
	 */
	public function specifications_tab( array $tabs ): array {
		$tabs['pp_specs'] = [
			'title'    => __( 'Specifications', 'powerplug' ),
			'priority' => 15,
			'callback' => static function (): void {
				global $product;
				if ( ! $product instanceof \WC_Product ) {
					return;
				}
				$attrs = $product->get_attributes();
				if ( empty( $attrs ) ) {
					echo '<p>' . esc_html__( 'Specifications available on request.', 'powerplug' ) . '</p>';
					return;
				}
				echo '<table class="pp-specs shop_attributes">';
				foreach ( $attrs as $attr ) {
					$name  = wc_attribute_label( $attr->get_name() );
					$value = $product->get_attribute( $attr->get_name() );
					printf( '<tr><th>%s</th><td>%s</td></tr>', esc_html( $name ), esc_html( $value ) );
				}
				echo '</table>';
			},
		];
		return $tabs;
	}
}

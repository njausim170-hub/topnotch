<?php
declare( strict_types=1 );

namespace PowerPlug\Woo;

use PowerPlug\Core\Bootable;

defined( 'ABSPATH' ) || exit;

/**
 * Quick view: adds a "Quick view" button to loop items and returns product
 * data over AJAX for a modal. Read-only and public; no nonce required.
 */
final class QuickView implements Bootable {

	public function boot(): void {
		add_action( 'wp_ajax_pp_quickview', array( $this, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_pp_quickview', array( $this, 'ajax' ) );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'button' ), 15 );
	}

	public function button(): void {
		global $product;
		if ( ( $product instanceof \WC_Product ) === false ) {
			return;
		}
		printf(
			'<button type="button" class="pp-qv-btn" data-pp-quickview="%d">%s</button>',
			(int) $product->get_id(),
			esc_html__( 'Quick view', 'powerplug' )
		);
	}

	public function ajax(): void {
		$id      = isset( $_GET['id'] ) ? absint( wp_unslash( $_GET['id'] ) ) : 0;
		$product = $id ? wc_get_product( $id ) : null;
		if ( ( $product instanceof \WC_Product ) === false ) {
			wp_send_json_error( array( 'message' => __( 'Product not found.', 'powerplug' ) ), 404 );
		}
		$img_id = (int) $product->get_image_id();
		$img    = $img_id ? (string) wp_get_attachment_image_url( $img_id, 'large' ) : (string) wc_placeholder_img_src( 'large' );
		wp_send_json_success( array(
			'id'          => (int) $product->get_id(),
			'title'       => $product->get_name(),
			'price'       => $product->get_price_html(),
			'image'       => $img,
			'excerpt'     => wp_kses_post( (string) $product->get_short_description() ),
			'permalink'   => (string) get_permalink( $product->get_id() ),
			'in_stock'    => $product->is_in_stock(),
			'purchasable' => $product->is_purchasable(),
			'add_url'     => $product->add_to_cart_url(),
			'add_text'    => $product->add_to_cart_text(),
		) );
	}
}

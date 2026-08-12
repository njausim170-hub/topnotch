<?php
declare( strict_types=1 );

namespace PowerPlug\Security;

use PowerPlug\Core\Bootable;

defined( 'ABSPATH' ) || exit;

/**
 * Baseline OWASP security headers + hardening. A dedicated security plugin
 * (e.g. Wordfence) handles WAF/brute-force; this covers header hygiene.
 */
final class Headers implements Bootable {

	public function boot(): void {
		add_filter( 'wp_headers', [ $this, 'headers' ] );
		remove_action( 'wp_head', 'wp_generator' );
		add_filter( 'the_generator', '__return_empty_string' );
		add_filter( 'xmlrpc_enabled', '__return_false' );
	}

	/**
	 * @param array<string,string> $headers
	 * @return array<string,string>
	 */
	public function headers( array $headers ): array {
		$headers['X-Content-Type-Options']    = 'nosniff';
		$headers['X-Frame-Options']           = 'SAMEORIGIN';
		$headers['Referrer-Policy']           = 'strict-origin-when-cross-origin';
		$headers['Permissions-Policy']        = 'geolocation=(), microphone=(), camera=()';
		$headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains';
		return $headers;
	}
}

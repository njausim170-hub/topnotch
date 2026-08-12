<?php
/**
 * @package PowerPlug
 */
defined( 'ABSPATH' ) || exit;
$pp_year     = (string) gmdate( 'Y' );
$pp_phone    = \PowerPlug\Customizer\Customizer::val( 'pp_phone' );
$pp_email    = \PowerPlug\Customizer\Customizer::val( 'pp_email' );
$pp_hours    = \PowerPlug\Customizer\Customizer::val( 'pp_hours' );
$pp_address  = \PowerPlug\Customizer\Customizer::val( 'pp_address' );
$pp_whatsapp = \PowerPlug\Customizer\Customizer::val( 'pp_whatsapp' );
$pp_tel      = preg_replace( '/[^0-9+]/', '', $pp_phone );
?>
</main>
<footer class="pp-footer" role="contentinfo">
	<div class="pp-footer__cols">
		<div class="pp-footer__col pp-footer__about">
			<?php the_custom_logo(); ?>
			<p><?php esc_html_e( 'TopNotch Mall is your trusted Nairobi store for genuine solar & power systems, generators, power tools, water pumps and home appliances — with fast countrywide delivery. Pay by M-Pesa, bank transfer or on delivery.', 'powerplug' ); ?></p>
			<p class="pp-footer__social">
				<?php if ( strlen( $pp_whatsapp ) > 0 ) : ?><a href="https://wa.me/<?php echo esc_attr( $pp_whatsapp ); ?>" rel="noopener">WhatsApp</a> &middot;<?php endif; ?>
				<a href="https://www.facebook.com/" rel="noopener">Facebook</a> &middot;
				<a href="https://www.instagram.com/" rel="noopener">Instagram</a> &middot;
				<a href="https://www.tiktok.com/" rel="noopener">TikTok</a>
			</p>
		</div>
		<div class="pp-footer__col">
			<h3 class="pp-footer__title"><?php esc_html_e( 'Shop', 'powerplug' ); ?></h3>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/product-category/solar-power/' ) ); ?>"><?php esc_html_e( 'Solar & Power', 'powerplug' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/product-category/generators/' ) ); ?>"><?php esc_html_e( 'Generators', 'powerplug' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/product-category/water-pumps/' ) ); ?>"><?php esc_html_e( 'Water Pumps', 'powerplug' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/product-category/power-tools/' ) ); ?>"><?php esc_html_e( 'Power Tools', 'powerplug' ); ?></a></li>
				<li><a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'All Categories', 'powerplug' ); ?></a></li>
			</ul>
		</div>
		<div class="pp-footer__col">
			<h3 class="pp-footer__title"><?php esc_html_e( 'Customer Care', 'powerplug' ); ?></h3>
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'pp-footer__menu', 'fallback_cb' => false, 'depth' => 1 ) ); ?>
			<?php else : ?>
				<ul class="pp-footer__menu">
					<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>"><?php esc_html_e( 'About Us', 'powerplug' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/return-refund-policy/' ) ); ?>"><?php esc_html_e( 'Return and Refund Policy', 'powerplug' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/shipping-delivery-policy/' ) ); ?>"><?php esc_html_e( 'Shipping and Delivery Policy', 'powerplug' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>"><?php esc_html_e( 'Terms and Conditions', 'powerplug' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'powerplug' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'powerplug' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</div>
		<div class="pp-footer__col">
			<h3 class="pp-footer__title"><?php esc_html_e( 'Get in Touch', 'powerplug' ); ?></h3>
			<ul class="pp-footer__contact">
				<?php if ( strlen( $pp_address ) > 0 ) : ?><li><?php echo esc_html( $pp_address ); ?></li><?php endif; ?>
				<?php if ( strlen( $pp_phone ) > 0 ) : ?><li><a href="tel:<?php echo esc_attr( $pp_tel ); ?>"><?php echo esc_html( $pp_phone ); ?></a></li><?php endif; ?>
				<?php if ( strlen( $pp_email ) > 0 ) : ?><li><a href="mailto:<?php echo esc_attr( $pp_email ); ?>"><?php echo esc_html( $pp_email ); ?></a></li><?php endif; ?>
				<?php if ( strlen( $pp_hours ) > 0 ) : ?><li><?php echo esc_html( $pp_hours ); ?></li><?php endif; ?>
				<li><?php esc_html_e( 'We accept: M-Pesa and Pay on Delivery', 'powerplug' ); ?></li>
			</ul>
		</div>
	</div>
	<div class="pp-footer__trust">
		<span class="pp-footer__trust-label"><?php esc_html_e( 'Secure payments', 'powerplug' ); ?></span>
		<span class="pp-pay">M-Pesa</span>
		<span class="pp-pay">Visa</span>
		<span class="pp-pay">Mastercard</span>
		<span class="pp-pay">Pay on Delivery</span>
		<span class="pp-footer__trust-secure"><?php esc_html_e( 'SSL secured checkout', 'powerplug' ); ?></span>
	</div>
	<div class="pp-footer__legal">
		<p>&copy; <?php echo esc_html( $pp_year ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved. All prices in Kenyan Shillings (KES).', 'powerplug' ); ?>
		<a href="<?php echo esc_url( home_url( '/return-refund-policy/' ) ); ?>"><?php esc_html_e( 'Returns', 'powerplug' ); ?></a> &middot;
		<a href="<?php echo esc_url( home_url( '/shipping-delivery-policy/' ) ); ?>"><?php esc_html_e( 'Shipping', 'powerplug' ); ?></a> &middot;
		<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy', 'powerplug' ); ?></a> &middot;
		<a href="<?php echo esc_url( home_url( '/terms-conditions/' ) ); ?>"><?php esc_html_e( 'Terms', 'powerplug' ); ?></a></p>
	</div>
</footer>
<?php if ( strlen( $pp_whatsapp ) > 0 ) : ?>
<a class="pp-whatsapp" href="https://wa.me/<?php echo esc_attr( $pp_whatsapp ); ?>" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'powerplug' ); ?>" rel="noopener">WhatsApp</a>
<?php endif; ?>
<a class="pp-backtotop" href="#pp-main" aria-label="<?php esc_attr_e( 'Back to top', 'powerplug' ); ?>">&uarr;</a>
<?php wp_footer(); ?>
</body>
</html>

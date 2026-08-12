# Changelog - PowerPlug Pro

All notable changes to this theme are documented here.
This project follows semantic versioning (MAJOR.MINOR.PATCH).

## 2.14.2

- Added a Customer Reviews section on the homepage that automatically shows approved WooCommerce product reviews (4 stars and up), with optional Customizer seed slots for genuine quotes; the section stays hidden until real content exists.
- Added a homepage trust strip: genuine and warranty-backed stock, physical Nairobi shop, secure M-Pesa or pay-on-delivery, and nationwide delivery.

## 2.14.1 - Mobile performance + accessibility
### Performance
- Hero: first slide now renders a single responsive image (srcset 768/1024/1376 with sizes) instead of a duplicate CSS background + full-size image, so mobile downloads a right-sized hero and the LCP element loads sooner.
- Hero images recompressed (progressive, optimized) and mobile/tablet variants generated.
- Header logo no longer requested at full resolution (small sizes hint) and no longer competes with the hero for fetch priority.
- Unused WordPress core block-library CSS is dequeued on classic (non-block) pages, cutting render-blocking CSS.
### Accessibility
- Footer legal links (Returns, Shipping, Privacy, Terms) are underlined so they are distinguishable without relying on colour.
### SEO
- Built-in meta tags now auto-defer to Rank Math, Yoast, SEOPress or All in One SEO when active (filter powerplug_force_meta to override). Structured data can be disabled via the powerplug_disable_schema filter for sites that prefer their plugin's schema.

## 2.14.0 - Domain migration + Merchant-safe messaging
### Changed
- Site domain updated to the new powertoolsplug.co.ke domain across theme defaults, contact email default (info@powertoolsplug.co.ke), Theme/Author URI, and WooCommerce from-address default.
- Top bar promo replaced the blanket Free delivery claim with a Merchant-safe message: Genuine, warranty-backed power tools & equipment | Pay by M-Pesa or on delivery.
### Fixed
- Product Offer schema no longer asserts free shipping (shippingRate value 0) by default. OfferShippingDetails is emitted only when a flat rate is explicitly set via the powerplug_flat_shipping option, so structured data cannot conflict with Merchant Center shipping settings.

## 2.13.2 - Mini-cart drawer thumbnail fix
### Fixed
- Product images in the "Your Cart" slide-in drawer rendered full-size on mobile and desktop. Root cause: WooCommerce's thumbnail-shrink rule is scoped to .woocommerce ul.cart_list, but the drawer (.pp-minicart__body) renders woocommerce_mini_cart() outside any .woocommerce wrapper, so nothing constrained the images. Added mini-cart line-item styling: 56px thumbnail, product name + quantity layout, and a styled remove button.

## 2.13.1 - Homepage 6-per-row restored
### Fixed
- The v2.13.0 unified product-card block used \!important on the column count, which also overrode the homepage rows (they are wrapped in .woocommerce too), dropping them from 6 to 4 per row. Re-asserted the homepage grid (6 desktop / 4 / 3 / 2) scoped to .pp-shop-full .pp-shop-main with higher priority. Category/shop listings are unaffected.

## 2.13.0 - Unified product cards on all listings
### Fixed
- Category, shop, tag and search product grids now use the SAME card design as the homepage. Root cause: those listings sit in a container that only received weak global rules, so WooCommerce's default float layout won (no card border, overlapping title/price, plain button). Fix: one authoritative product-card block scoped to .woocommerce/.pp-wc__main that overrides WooCommerce defaults - bordered card, contained image, 2-line clamped title, bold price, full-width green add-to-cart with cart glyph, outlined quick view, responsive 4/3/2 columns.

## 2.12.0 - Google alignment + mobile drawer tap fix
### Fixed
- Mobile drawer: tapping a menu item or category did nothing (drawer just closed). Root cause: the dim overlay (z-index 999, body-level) painted above the drawer, which is trapped in the sticky header's stacking context (z-index 100). The overlay swallowed every tap. Fix: raise the header above the overlay while open and set the overlay to pointer-events:none.
### SEO / Google Merchant Center
- Product JSON-LD now includes shippingDetails (OfferShippingDetails) and hasMerchantReturnPolicy (MerchantReturnPolicy) - the fields Search Console flags as missing on merchant listings.
- Added mpn (falls back to SKU), a full image array (main + gallery), and a brand fallback (meta -> product attribute) so the brand-or-identifier requirement is met.
- Added a "Google Merchant" product panel (Brand / GTIN / MPN) under Product data -> Inventory; values flow into the schema.
- Added a Store (LocalBusiness) entity with address, phone, opening hours, price range, and social profiles; Organization gained contactPoint + sameAs.
- Added canonical tags on shop and category archives (WordPress core already handles singular content).
- Filters for merchants: powerplug_return_policy, powerplug_shipping_details, powerplug_opening_hours, powerplug_social_profiles, powerplug_flat_shipping.

## 2.11.0 - Lighthouse accessibility & LCP fixes
### Accessibility
- Added aria-labels to the header Account/Wishlist icon links (their text label is hidden on mobile).
- Enlarged hero slider dot touch targets to 24px (kept the small visual dot).
- Fixed footer legal text contrast (mode-independent light color) and darkened the WhatsApp button so its white label meets WCAG AA.
### Performance / SEO
- Added a real <img fetchpriority="high"> for the first hero slide (fixes desktop NO_LCP and speeds LCP detection).
- Added a meta description (fixes the Lighthouse SEO audit).
- Removed the unused Google Fonts preconnects (the theme uses a system font stack).

## 2.10.0 - Phase 6: Performance, Security, SEO & Accessibility
### Performance
- Removed legacy head bloat (RSD, WLW manifest, shortlink, adjacent-post links).
- Added preconnect + dns-prefetch resource hints for Google Fonts.
- Retained: emoji script/style removal, native lazy-loading, main-CSS preload, deferred theme JS.
### Security
- Baseline OWASP response headers: X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy, Strict-Transport-Security.
- Removed WordPress generator version string; disabled XML-RPC.
### SEO / Structured data
- Product JSON-LD now includes priceValidUntil and itemCondition (clears Search Console warnings).
- Variable products emit AggregateOffer (lowPrice/highPrice/offerCount) instead of an empty price.
- BreadcrumbList is now a full dynamic trail (Home > Shop > category ancestors > product) and also renders on category and shop pages.
- Organization + WebSite graphs retained; stands down when Yoast or Rank Math is active.
### Accessibility
- Visible :focus-visible keyboard focus ring on all interactive elements (WCAG 2.4.7).
- Styled, visible WooCommerce breadcrumb; aria-label on the product filter panel.
- Reduced-motion support for drawers and modals.

## 2.9.0 - Phase 5: Setup safety & branding controls
- Demo importer now auto-detects a populated store and skips demo categories/products/menus, so live inventory is never overwritten.
- Customizer "Branding & Colors" section: primary brand color + heading/text color with live retinting via CSS variables.
- Authoritative mobile navigation drawer fix (resolved cascading @media conflicts from earlier versions).

## 2.8.0 - Phase 4: Product discovery
- Filter sidebar: categories, price range, rating, and WooCommerce product attributes (incl. Brand); shareable URL-based filtering.
- Styled sort dropdown, numbered pagination, and an AJAX "Load more products" button.
- Mobile refinements: cart image sizing, stacked/centered checkout, centered category and section layouts.

## 2.7.0 - Mobile navigation & commerce polish
- Mobile slide-in drawer with header + live "Shop by Category" list and quick links.
- Equal-height related/up-sell product grid.
- Full cart and checkout styling (coupon field, boxed totals, sticky order review).

## 2.6.0 - Templates & WooCommerce foundation
- Added page.php (renders full page content) and woocommerce.php full-width wrapper.
- Quick View modal, AJAX add-to-cart + mini-cart, single-product and archive polish.
- Seeder also runs on admin_init so in-place updates repopulate starter pages.

## 2.0.0 - 2.5.0 - Phase 2: Brand & design system
- Full rebrand to PowerPlug Pro (green #268655 + charcoal #111418).
- OOP theme architecture (PSR-4, PowerPlug namespace), theme.json design system.
- Header (top contact bar, search, cart), hero, featured categories, footer, and page content.

## 1.0.0 - Initial scaffold
- Base theme structure, autoloader, setup wizard, plugin installer, demo importer.

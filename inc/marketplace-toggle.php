<?php
/**
 * Lawyer directory kill-switch (spec 16 §0.10).
 *
 * The lawyer directory is temporarily disabled until lawyer data is
 * populated via the app.rawlaw.in API integration. Flip
 * RAWLAW_MARKETPLACE_LIVE to true once that's ready — nothing else
 * needs to change; the archive, single profiles and their sitemap/
 * robots handling all key off this one constant.
 *
 * Scoped to the `lawyer` post type only. `practice_area` and
 * `lawyer_location` taxonomy archives are NOT gated here — those also
 * list editorial articles (spec 15 §2.4's hub-and-spoke design), so
 * disabling them would hide real content along with the empty
 * directory.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * ⚠️ BEFORE flipping this to true: roadmap item 0.11 (BCI Rule 36) is
 * only decided for star ratings (removed outright, see progress.md).
 * Advocate photographs, comparative listings and lead-routing to named
 * advocates — all live again the moment real profiles are shown — still
 * need actual counsel sign-off. Get that first, not after launch.
 */
if ( ! defined( 'RAWLAW_MARKETPLACE_LIVE' ) ) {
	define( 'RAWLAW_MARKETPLACE_LIVE', false );
}

function rawlaw_marketplace_is_live() {
	return (bool) RAWLAW_MARKETPLACE_LIVE;
}

function rawlaw_marketplace_is_gated_request() {
	return ! rawlaw_marketplace_is_live() && ( is_post_type_archive( 'lawyer' ) || is_singular( 'lawyer' ) );
}

function rawlaw_marketplace_disabled_notice() {
	get_header();
	$requirement_url = function_exists( 'rawlaw_get_post_requirement_url' )
		? rawlaw_get_post_requirement_url()
		: home_url( '/post-a-requirement/' );
	?>
	<section class="marketplace marketplace--disabled">
		<div class="container">
			<div class="marketplace__empty" style="max-width:640px;margin:96px auto;text-align:center;">
				<h1><?php esc_html_e( 'Verified lawyer directory — coming soon', 'rawlaw' ); ?></h1>
				<p class="muted"><?php esc_html_e( "We're building RawLaw's verified advocate directory. In the meantime, describe your legal issue and we'll connect you directly with the right advocate.", 'rawlaw' ); ?></p>
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $requirement_url ); ?>"><?php esc_html_e( 'Post your requirement', 'rawlaw' ); ?></a>
			</div>
		</div>
	</section>
	<?php
	get_footer();
	exit;
}

function rawlaw_marketplace_gate() {
	if ( rawlaw_marketplace_is_gated_request() ) {
		rawlaw_marketplace_disabled_notice();
	}
}
add_action( 'template_redirect', 'rawlaw_marketplace_gate' );

/**
 * noindex,follow while gated — keeps the URL crawlable for whenever it
 * goes live, but out of the index while there is no real content.
 */
add_filter( 'wp_robots', function( $robots ) {
	if ( rawlaw_marketplace_is_gated_request() ) {
		$robots['noindex'] = true;
	}
	return $robots;
} );

/**
 * Keep the (currently empty, but future-proofed) lawyer post type out
 * of the core sitemap entirely while gated.
 */
add_filter( 'wp_sitemaps_post_types', function( $post_types ) {
	if ( ! rawlaw_marketplace_is_live() ) {
		unset( $post_types['lawyer'] );
	}
	return $post_types;
} );

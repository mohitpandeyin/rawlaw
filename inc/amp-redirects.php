<?php
/**
 * 301 the old paired-AMP twin URLs to their canonical equivalent
 * (spec 16 §2.1). AMP support has been removed from the theme; these
 * redirects exist purely to collapse already-indexed/linked AMP twins
 * (`?amp=1` and `/amp/`) back onto the one real URL instead of leaving
 * them as dangling duplicates.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_redirect_amp_twins() {
	if ( is_admin() ) {
		return;
	}

	$path       = (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH );
	$is_amp_qs  = isset( $_GET['amp'] );
	$is_amp_uri = (bool) preg_match( '#/amp/?$#', $path );

	if ( ! $is_amp_qs && ! $is_amp_uri ) {
		return;
	}

	$canonical = home_url( preg_replace( '#/amp/?$#', '/', $path ) );
	$canonical = remove_query_arg( 'amp', $canonical );

	wp_safe_redirect( $canonical, 301 );
	exit;
}
add_action( 'template_redirect', 'rawlaw_redirect_amp_twins', 0 );

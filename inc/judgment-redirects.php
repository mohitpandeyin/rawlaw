<?php
/**
 * 301 old `/judgments/...` URLs after the `judgment` CPT removal
 * (2026-08-07 — see docs/AUDIT.md). Judgment posts were converted to
 * regular `post` rows (flat `/%postname%/` permalinks, this theme's
 * existing convention), so a single-post URL just drops the
 * `judgments/` prefix. There is no replacement for the archive itself
 * — it sends visitors to the homepage.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_redirect_judgment_urls() {
	if ( is_admin() ) {
		return;
	}

	$path = trim( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ), '/' );

	if ( 'judgments' !== $path && 0 !== strpos( $path, 'judgments/' ) ) {
		return;
	}

	// Single judgment: judgments/<slug>/ -> /<slug>/ (matches the converted
	// post's new flat permalink). Anything else under judgments/ (the bare
	// archive, pagination, feeds) has no single replacement — send home.
	if ( preg_match( '#^judgments/([^/]+)/?$#', $path, $m ) && ! in_array( $m[1], array( 'page', 'feed' ), true ) ) {
		wp_safe_redirect( home_url( '/' . $m[1] . '/' ), 301 );
		exit;
	}

	wp_safe_redirect( home_url( '/' ), 301 );
	exit;
}
add_action( 'template_redirect', 'rawlaw_redirect_judgment_urls', 0 );

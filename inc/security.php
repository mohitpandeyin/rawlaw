<?php
/**
 * Sensible security & cleanup defaults.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// Remove version disclosure.
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

// Remove unnecessary head clutter.
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'feed_links_extra', 3 );

// Disable XML-RPC entirely (RawLaw doesn't use it).
add_filter( 'xmlrpc_enabled', '__return_false' );

// Disable file editing in admin.
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

// Hide login error specifics to reduce username enumeration.
add_filter( 'login_errors', function() { return __( 'Invalid credentials.', 'rawlaw' ); } );

// Lightweight security headers.
function rawlaw_security_headers( $headers ) {
	$headers['X-Content-Type-Options'] = 'nosniff';
	$headers['Referrer-Policy']        = 'strict-origin-when-cross-origin';
	$headers['Permissions-Policy']     = 'interest-cohort=(), camera=(), microphone=(), geolocation=()';
	return $headers;
}
add_filter( 'wp_headers', 'rawlaw_security_headers' );

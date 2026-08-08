<?php
/**
 * Custom post types.
 *
 * This theme has none left as of 2026-08-07 — see docs/AUDIT.md:
 * `lawyer` was removed because that data now lives exclusively on
 * app.rawlaw.in; `judgment` was removed by converting its posts to
 * regular `post` rows (see `inc/judgment-redirects.php` for the URL
 * redirect this required) since case-law write-ups are ordinary
 * editorial content, not a distinct data model. `rawlaw_register_cpts()`
 * is kept as a no-op hook point rather than deleted outright, since
 * `rawlaw_activation_flush()` below still needs somewhere to call
 * into before its rewrite flush.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_register_cpts() {}
add_action( 'init', 'rawlaw_register_cpts' );

/**
 * Flush rewrites on theme activation.
 */
function rawlaw_activation_flush() {
	rawlaw_register_cpts();
	rawlaw_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'rawlaw_activation_flush' );

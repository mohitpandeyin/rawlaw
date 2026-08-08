<?php
/**
 * robots.txt (spec 14 §2.2).
 *
 * Ships AFTER the canonical + noindex work in inc/seo-meta.php:
 * robots-disallowing an already-indexed URL prevents re-crawl, which
 * prevents a `noindex` from ever being seen, which freezes bloat in
 * the index permanently.
 *
 * Per roadmap 0.14: no AI crawler is blocked, training included — one
 * ruleset applies to every crawler, human or bot, alike.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_robots_txt( $output, $public ) {
	if ( '0' === (string) $public ) {
		return $output;
	}

	$lines = array(
		'User-agent: *',
		'Disallow: /wp-admin/',
		'Allow: /wp-admin/admin-ajax.php',
		'Disallow: /*?s=',
		'Content-Signal: search=yes, ai-input=yes, ai-train=yes',
		'',
		'Sitemap: ' . home_url( '/wp-sitemap.xml' ),
		'Sitemap: ' . home_url( '/sitemap-news.xml' ),
	);

	return implode( "\n", $lines ) . "\n";
}
add_filter( 'robots_txt', 'rawlaw_robots_txt', 10, 2 );

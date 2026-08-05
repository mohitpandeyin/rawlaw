<?php
/**
 * Bare `/news/` URL for the "News" category (spec 16 §0.13).
 *
 * WordPress's `category_base` option is global — changing it would
 * strip the `/category/` prefix from every category, not just this
 * one. This is scoped to the "news" category alone; every other
 * category keeps its normal `/category/<slug>/` URL. Individual posts
 * are unaffected — they already resolve flat at `/<post-slug>/`.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_news_rewrite_rules() {
	add_rewrite_rule( '^news/feed/(feed|rdf|rss|rss2|atom)/?$', 'index.php?category_name=news&feed=$matches[1]', 'top' );
	add_rewrite_rule( '^news/(feed|rdf|rss|rss2|atom)/?$', 'index.php?category_name=news&feed=$matches[1]', 'top' );
	add_rewrite_rule( '^news/page/([0-9]{1,})/?$', 'index.php?category_name=news&paged=$matches[1]', 'top' );
	add_rewrite_rule( '^news/?$', 'index.php?category_name=news', 'top' );
}
add_action( 'init', 'rawlaw_news_rewrite_rules' );

/**
 * Make get_category_link() — and therefore rawlaw_news_url() and every
 * "News" archive link/breadcrumb built from it — emit the bare URL.
 */
function rawlaw_news_category_link( $link, $term_id ) {
	$term = get_term( $term_id, 'category' );
	if ( $term && ! is_wp_error( $term ) && 'news' === $term->slug ) {
		return home_url( '/news/' );
	}
	return $link;
}
add_filter( 'category_link', 'rawlaw_news_category_link', 10, 2 );

/**
 * 301 the old /category/news/ URL (and its pagination) to the bare one,
 * so any existing indexing/backlinks consolidate onto the new URL.
 */
function rawlaw_redirect_old_news_category_url() {
	if ( is_admin() ) {
		return;
	}
	$path = trim( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ), '/' );
	if ( ! preg_match( '#^category/news(/|$)#', $path ) ) {
		return;
	}
	$rest = preg_replace( '#^category/news#', '', $path );
	wp_safe_redirect( home_url( '/news' . $rest . '/' ), 301 );
	exit;
}
add_action( 'template_redirect', 'rawlaw_redirect_old_news_category_url', 0 );

/**
 * The new route only works once rewrite rules are flushed. Flushing is
 * expensive, so gate it behind an option instead of running every load.
 * Bump the option name if this rule ever needs to change again.
 */
function rawlaw_maybe_flush_news_rewrite() {
	if ( ! get_option( 'rawlaw_news_rewrite_flushed_v2' ) ) {
		flush_rewrite_rules();
		update_option( 'rawlaw_news_rewrite_flushed_v2', 1 );
	}
}
add_action( 'init', 'rawlaw_maybe_flush_news_rewrite', 20 );

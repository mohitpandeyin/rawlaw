<?php
/**
 * News sitemap and IndexNow — push-based discovery (spec 16 §1.11).
 *
 * Both are served via an exact-path check on `template_redirect` rather
 * than a rewrite rule, so they work without a permalink-structure flush.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ------------------------------------------------------------------------
 * News sitemap — last 2 days only, max 1,000 entries (Google News spec).
 * --------------------------------------------------------------------- */

function rawlaw_request_path() {
	return trim( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ), '/' );
}

function rawlaw_render_news_sitemap() {
	$publication_name = get_bloginfo( 'name' );
	$language         = substr( get_locale(), 0, 2 );

	$query = new WP_Query( array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 1000,
		'no_found_rows'  => true,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'date_query'     => array(
			array( 'after' => '2 days ago', 'inclusive' => true ),
		),
	) );

	header( 'Content-Type: application/xml; charset=UTF-8' );
	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . "\n";

	while ( $query->have_posts() ) :
		$query->the_post();
		echo "<url>\n";
		echo '<loc>' . esc_url( get_permalink() ) . "</loc>\n";
		echo "<news:news>\n";
		echo "<news:publication>\n";
		echo '<news:name>' . esc_html( $publication_name ) . "</news:name>\n";
		echo '<news:language>' . esc_html( $language ) . "</news:language>\n";
		echo "</news:publication>\n";
		echo '<news:publication_date>' . esc_html( get_the_date( 'c' ) ) . "</news:publication_date>\n";
		echo '<news:title>' . esc_html( get_the_title() ) . "</news:title>\n";
		echo "</news:news>\n";
		echo "</url>\n";
	endwhile;
	wp_reset_postdata();

	echo '</urlset>';
}

/* ------------------------------------------------------------------------
 * IndexNow — push new/updated URLs to Bing (upstream of Copilot grounding).
 * --------------------------------------------------------------------- */

function rawlaw_indexnow_key() {
	$key = get_option( 'rawlaw_indexnow_key' );
	if ( ! $key ) {
		$key = wp_generate_password( 32, false, false );
		update_option( 'rawlaw_indexnow_key', $key );
	}
	return $key;
}

function rawlaw_indexnow_ping( $url ) {
	$key = rawlaw_indexnow_key();
	wp_remote_get(
		add_query_arg(
			array(
				'url'         => rawurlencode( $url ),
				'key'         => $key,
				'keyLocation' => rawurlencode( home_url( '/' . $key . '.txt' ) ),
			),
			'https://api.indexnow.org/indexnow'
		),
		array( 'timeout' => 5, 'blocking' => false )
	);
}

function rawlaw_indexnow_on_publish( $new_status, $old_status, $post ) {
	if ( 'publish' !== $new_status ) { return; }
	if ( ! in_array( $post->post_type, array( 'post', 'page' ), true ) ) { return; }
	rawlaw_indexnow_ping( get_permalink( $post ) );
}
add_action( 'transition_post_status', 'rawlaw_indexnow_on_publish', 10, 3 );

/* ------------------------------------------------------------------------
 * Kill the crawlable ?replytocom= URL set (spec 16 §1.13).
 *
 * `comment-reply.js` (already enqueued) progressively enhances these links
 * via JS, so the query-string href is only a no-JS fallback; stripping it
 * still lands the visitor on the comment form via the #respond anchor.
 * --------------------------------------------------------------------- */

add_filter( 'comment_reply_link', function( $link ) {
	return preg_replace( '/\?replytocom=\d+#respond/', '#respond', $link );
} );

/* ------------------------------------------------------------------------
 * Virtual endpoints — /sitemap-news.xml and the IndexNow key file.
 * --------------------------------------------------------------------- */

function rawlaw_serve_discovery_endpoints() {
	$path = rawlaw_request_path();

	if ( 'sitemap-news.xml' === $path ) {
		// WordPress has already queued a 404 status by this point (nothing
		// matched a real rewrite rule) — override it before any output, or
		// crawlers correctly ignore this sitemap regardless of its body.
		status_header( 200 );
		rawlaw_render_news_sitemap();
		exit;
	}

	if ( rawlaw_indexnow_key() . '.txt' === $path ) {
		status_header( 200 );
		header( 'Content-Type: text/plain; charset=UTF-8' );
		echo rawlaw_indexnow_key(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		exit;
	}
}
add_action( 'template_redirect', 'rawlaw_serve_discovery_endpoints' );

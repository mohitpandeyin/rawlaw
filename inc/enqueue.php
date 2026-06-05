<?php
/**
 * Asset enqueueing.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_enqueue_assets() {
	$ver_main = file_exists( RAWLAW_DIR . 'assets/css/main.css' )
		? filemtime( RAWLAW_DIR . 'assets/css/main.css' ) : RAWLAW_VERSION;
	$ver_js = file_exists( RAWLAW_DIR . 'assets/js/main.js' )
		? filemtime( RAWLAW_DIR . 'assets/js/main.js' ) : RAWLAW_VERSION;

	// Theme metadata stylesheet.
	wp_enqueue_style( 'rawlaw-style', get_stylesheet_uri(), array(), RAWLAW_VERSION );

	// Editorial typography from Google Fonts (preconnected for speed).
	wp_enqueue_style(
		'rawlaw-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'rawlaw-main', RAWLAW_URI . 'assets/css/main.css', array( 'rawlaw-style' ), $ver_main );
	wp_enqueue_style( 'rawlaw-print', RAWLAW_URI . 'assets/css/print.css', array( 'rawlaw-main' ), $ver_main, 'print' );

	wp_enqueue_script( 'rawlaw-main', RAWLAW_URI . 'assets/js/main.js', array(), $ver_js, true );
	wp_script_add_data( 'rawlaw-main', 'defer', true );

	// Scroll-driven marquee (homepage features-bar) — skip on AMP.
	if ( is_front_page() && ! rawlaw_is_amp() ) {
		$ver_marquee = file_exists( RAWLAW_DIR . 'assets/js/marquee.js' )
			? filemtime( RAWLAW_DIR . 'assets/js/marquee.js' ) : RAWLAW_VERSION;

		wp_enqueue_script(
			'gsap',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
			array(),
			'3.12.5',
			true
		);
		wp_enqueue_script(
			'gsap-scrolltrigger',
			'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
			array( 'gsap' ),
			'3.12.5',
			true
		);
		wp_enqueue_script(
			'rawlaw-marquee',
			RAWLAW_URI . 'assets/js/marquee.js',
			array( 'gsap-scrolltrigger' ),
			$ver_marquee,
			true
		);
	}

	wp_localize_script( 'rawlaw-main', 'RawLawData', array(
		'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
		'restRoot'   => esc_url_raw( rest_url() ),
		'searchUrl'  => esc_url_raw( home_url( '/?s=' ) ),
		'i18n'       => array(
			'menu'      => __( 'Menu', 'rawlaw' ),
			'close'     => __( 'Close', 'rawlaw' ),
			'search'    => __( 'Search', 'rawlaw' ),
			'loadMore'  => __( 'Load more', 'rawlaw' ),
		),
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rawlaw_enqueue_assets' );

/**
 * Preconnect Google Fonts to avoid render-blocking warmup.
 */
function rawlaw_resource_hints( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = array( 'href' => 'https://fonts.googleapis.com', 'crossorigin' );
		$hints[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $hints;
}
add_filter( 'wp_resource_hints', 'rawlaw_resource_hints', 10, 2 );

/**
 * Critical CSS — inline a tiny above-the-fold chunk for fast first paint.
 * Skipped when main.css is enqueued (it contains the full superset).
 */
function rawlaw_inline_critical_css() {
	if ( wp_style_is( 'rawlaw-main', 'enqueued' ) ) {
		return;
	}
	$css = file_get_contents( RAWLAW_DIR . 'assets/css/critical.css' );
	if ( $css ) {
		echo "<style id=\"rawlaw-critical\">{$css}</style>\n"; // phpcs:ignore
	}
}
add_action( 'wp_head', 'rawlaw_inline_critical_css', 1 );

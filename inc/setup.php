<?php
/**
 * Theme setup.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'rawlaw_setup' ) ) :
	function rawlaw_setup() {
		load_theme_textdomain( 'rawlaw', RAWLAW_DIR . 'languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'custom-logo', array(
			'height'      => 60,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		) );
		add_theme_support( 'html5', array(
			'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets',
		) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/editor.css' );
		add_theme_support( 'custom-line-height' );
		add_theme_support( 'custom-spacing' );
		add_theme_support( 'custom-units' );

		register_nav_menus( array(
			'primary'     => __( 'Primary Navigation', 'rawlaw' ),
			'secondary'   => __( 'Secondary / Topics', 'rawlaw' ),
			'footer'      => __( 'Footer Navigation', 'rawlaw' ),
			'marketplace' => __( 'Marketplace Navigation', 'rawlaw' ),
		) );

		// Editorial image sizes.
		add_image_size( 'rawlaw-hero',     1600, 900, true );
		add_image_size( 'rawlaw-featured', 1200, 720, true );
		add_image_size( 'rawlaw-card',      720, 480, true );
		add_image_size( 'rawlaw-compact',   320, 240, true );
		add_image_size( 'rawlaw-square',    480, 480, true );

		// Editor palette mirrors the theme tokens.
		add_theme_support( 'editor-color-palette', array(
			array( 'name' => __( 'Ink',     'rawlaw' ), 'slug' => 'ink',     'color' => '#0B1220' ),
			array( 'name' => __( 'Paper',   'rawlaw' ), 'slug' => 'paper',   'color' => '#FFFFFF' ),
			array( 'name' => __( 'Surface', 'rawlaw' ), 'slug' => 'surface', 'color' => '#FFFFFF' ),
			array( 'name' => __( 'Navy',    'rawlaw' ), 'slug' => 'navy',    'color' => '#1A3F72' ),
			array( 'name' => __( 'Editorial Blue', 'rawlaw' ), 'slug' => 'editorial-blue', 'color' => '#112E56' ),
			array( 'name' => __( 'Muted',   'rawlaw' ), 'slug' => 'muted',   'color' => '#5A6072' ),
			array( 'name' => __( 'Border',  'rawlaw' ), 'slug' => 'border',  'color' => '#DCE4EE' ),
		) );

		add_theme_support( 'editor-font-sizes', array(
			array( 'name' => __( 'Small',   'rawlaw' ), 'slug' => 'small',   'size' => 14 ),
			array( 'name' => __( 'Normal',  'rawlaw' ), 'slug' => 'normal',  'size' => 17 ),
			array( 'name' => __( 'Large',   'rawlaw' ), 'slug' => 'large',   'size' => 22 ),
			array( 'name' => __( 'XL',      'rawlaw' ), 'slug' => 'xl',      'size' => 28 ),
			array( 'name' => __( 'Display', 'rawlaw' ), 'slug' => 'display', 'size' => 44 ),
		) );

		add_theme_support( 'disable-custom-colors' );
		add_theme_support( 'disable-custom-font-sizes' );
	}
endif;
add_action( 'after_setup_theme', 'rawlaw_setup' );

/**
 * Content width for media.
 */
function rawlaw_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rawlaw_content_width', 760 );
}
add_action( 'after_setup_theme', 'rawlaw_content_width', 0 );

/**
 * Add a body class for marketplace pages so we can scope styles cleanly.
 */
function rawlaw_body_classes( $classes ) {
	if ( is_singular( 'lawyer' ) || is_post_type_archive( 'lawyer' ) || is_tax( array( 'practice_area', 'lawyer_location' ) ) ) {
		$classes[] = 'is-marketplace';
	}
	if ( is_singular( 'post' ) ) {
		$classes[] = 'is-article';
	}
	if ( is_front_page() ) {
		$classes[] = 'is-front';
	}
	// Remove 'archive' body class — it conflicts with the theme's .archive layout class.
	$classes = array_diff( $classes, array( 'archive' ) );
	return $classes;
}
add_filter( 'body_class', 'rawlaw_body_classes' );

/**
 * Cleaner excerpts.
 */
function rawlaw_excerpt_length( $length ) { return 28; }
add_filter( 'excerpt_length', 'rawlaw_excerpt_length', 999 );

function rawlaw_excerpt_more( $more ) { return '&hellip;'; }
add_filter( 'excerpt_more', 'rawlaw_excerpt_more' );

/**
 * Pingback header for singular posts.
 */
function rawlaw_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'rawlaw_pingback_header' );

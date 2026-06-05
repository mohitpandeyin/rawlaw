<?php
/**
 * Custom post types: Lawyer (marketplace) + Judgment (editorial deep archive).
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_register_cpts() {
	// Lawyer / Advocate marketplace listing.
	register_post_type( 'lawyer', array(
		'labels' => array(
			'name'                  => __( 'Lawyers', 'rawlaw' ),
			'singular_name'         => __( 'Lawyer', 'rawlaw' ),
			'menu_name'             => __( 'Lawyers', 'rawlaw' ),
			'add_new_item'          => __( 'Add New Lawyer', 'rawlaw' ),
			'edit_item'             => __( 'Edit Lawyer', 'rawlaw' ),
			'search_items'          => __( 'Search Lawyers', 'rawlaw' ),
			'not_found'             => __( 'No lawyers found.', 'rawlaw' ),
		),
		'public'             => true,
		'has_archive'        => 'find-a-lawyer',
		'rewrite'            => array( 'slug' => 'lawyer', 'with_front' => false ),
		'menu_icon'          => 'dashicons-businessperson',
		'show_in_rest'       => true,
		'menu_position'      => 22,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'author', 'custom-fields' ),
	) );

	// Judgment archive (treated like editorial content).
	register_post_type( 'judgment', array(
		'labels' => array(
			'name'                  => __( 'Judgments', 'rawlaw' ),
			'singular_name'         => __( 'Judgment', 'rawlaw' ),
			'menu_name'             => __( 'Judgments', 'rawlaw' ),
		),
		'public'             => true,
		'has_archive'        => 'judgments',
		'rewrite'            => array( 'slug' => 'judgments', 'with_front' => false ),
		'menu_icon'          => 'dashicons-book-alt',
		'show_in_rest'       => true,
		'menu_position'      => 6,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'author', 'custom-fields' ),
	) );
}
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

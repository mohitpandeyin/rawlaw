<?php
/**
 * Custom taxonomies for the marketplace + editorial layer.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_register_taxonomies() {
	register_taxonomy( 'practice_area', array( 'lawyer', 'judgment', 'post' ), array(
		'labels' => array(
			'name'          => __( 'Practice Areas', 'rawlaw' ),
			'singular_name' => __( 'Practice Area', 'rawlaw' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'practice-area' ),
	) );

	register_taxonomy( 'lawyer_location', array( 'lawyer' ), array(
		'labels' => array(
			'name'          => __( 'Locations', 'rawlaw' ),
			'singular_name' => __( 'Location', 'rawlaw' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'location' ),
	) );

	register_taxonomy( 'court', array( 'judgment', 'post' ), array(
		'labels' => array(
			'name'          => __( 'Courts', 'rawlaw' ),
			'singular_name' => __( 'Court', 'rawlaw' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'court' ),
	) );
}
add_action( 'init', 'rawlaw_register_taxonomies' );

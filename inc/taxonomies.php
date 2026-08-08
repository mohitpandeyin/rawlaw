<?php
/**
 * Custom taxonomies for editorial content.
 *
 * Both taxonomies now attach only to `post` — they used to also
 * attach to `lawyer` and `judgment`, both removed 2026-08-07 (see
 * docs/AUDIT.md). `judgment` posts were converted to `post` rows
 * rather than deleted, so their existing `practice_area`/`court`
 * term relationships carry over unchanged; only the object-type
 * registration needed updating.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_register_taxonomies() {
	register_taxonomy( 'practice_area', array( 'post' ), array(
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

	register_taxonomy( 'court', array( 'post' ), array(
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

<?php
/**
 * Sidebars / widget areas.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_register_sidebars() {
	$common = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget__title">',
		'after_title'   => '</h2>',
	);

	register_sidebar( array_merge( $common, array(
		'name'        => __( 'Article Sidebar', 'rawlaw' ),
		'id'          => 'sidebar-article',
		'description' => __( 'Appears next to articles and on archive pages.', 'rawlaw' ),
	) ) );

	register_sidebar( array_merge( $common, array(
		'name'        => __( 'Marketplace Sidebar', 'rawlaw' ),
		'id'          => 'sidebar-marketplace',
		'description' => __( 'Appears on lawyer profiles and marketplace pages.', 'rawlaw' ),
	) ) );

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar( array_merge( $common, array(
			'name'        => sprintf( __( 'Footer %d', 'rawlaw' ), $i ),
			'id'          => 'footer-' . $i,
			'description' => __( 'Footer column.', 'rawlaw' ),
		) ) );
	}
}
add_action( 'widgets_init', 'rawlaw_register_sidebars' );

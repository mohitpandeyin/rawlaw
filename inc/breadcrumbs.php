<?php
/**
 * Accessible breadcrumbs with Schema.org BreadcrumbList JSON-LD.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_breadcrumbs() {
	if ( is_front_page() ) { return; }

	$items   = array();
	$items[] = array( 'name' => __( 'Home', 'rawlaw' ), 'url' => home_url( '/' ) );

	if ( is_category() || is_single() ) {
		if ( is_single() ) {
			$post_type = get_post_type();
			if ( 'lawyer' === $post_type ) {
				$items[] = array(
					'name' => __( 'Find a Lawyer', 'rawlaw' ),
					'url'  => get_post_type_archive_link( 'lawyer' ),
				);
				$terms = get_the_terms( get_the_ID(), 'practice_area' );
				if ( $terms && ! is_wp_error( $terms ) ) {
					$items[] = array( 'name' => $terms[0]->name, 'url' => get_term_link( $terms[0] ) );
				}
			} else {
				$cat = rawlaw_primary_category();
				if ( $cat ) {
					if ( $cat->parent ) {
						$parent = get_term( $cat->parent, 'category' );
						$items[] = array( 'name' => $parent->name, 'url' => get_term_link( $parent ) );
					}
					$items[] = array( 'name' => $cat->name, 'url' => get_term_link( $cat ) );
				}
			}
			$items[] = array( 'name' => get_the_title(), 'url' => get_permalink() );
		} else {
			$cat = get_queried_object();
			if ( $cat->parent ) {
				$parent = get_term( $cat->parent, 'category' );
				$items[] = array( 'name' => $parent->name, 'url' => get_term_link( $parent ) );
			}
			$items[] = array( 'name' => $cat->name, 'url' => get_term_link( $cat ) );
		}
	} elseif ( is_tag() ) {
		$items[] = array( 'name' => single_tag_title( '', false ), 'url' => get_term_link( get_queried_object() ) );
	} elseif ( is_tax() ) {
		$tax = get_queried_object();
		$items[] = array( 'name' => $tax->name, 'url' => get_term_link( $tax ) );
	} elseif ( is_author() ) {
		$items[] = array( 'name' => get_the_author(), 'url' => get_author_posts_url( get_queried_object_id() ) );
	} elseif ( is_search() ) {
		$items[] = array( 'name' => sprintf( __( 'Search: %s', 'rawlaw' ), get_search_query() ), 'url' => '' );
	} elseif ( is_post_type_archive( 'lawyer' ) ) {
		$items[] = array( 'name' => __( 'Find a Lawyer', 'rawlaw' ), 'url' => get_post_type_archive_link( 'lawyer' ) );
	} elseif ( is_page() ) {
		$ancestors = array_reverse( get_post_ancestors( get_the_ID() ) );
		foreach ( $ancestors as $aid ) {
			$items[] = array( 'name' => get_the_title( $aid ), 'url' => get_permalink( $aid ) );
		}
		$items[] = array( 'name' => get_the_title(), 'url' => get_permalink() );
	} elseif ( is_404() ) {
		$items[] = array( 'name' => __( 'Page not found', 'rawlaw' ), 'url' => '' );
	}

	if ( count( $items ) <= 1 ) { return; }

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'rawlaw' ) . '"><ol>';
	$last = count( $items ) - 1;
	$jsonld = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => array(),
	);
	foreach ( $items as $i => $item ) {
		if ( $i === $last ) {
			printf( '<li aria-current="page">%s</li>', esc_html( $item['name'] ) );
		} else {
			printf(
				'<li><a href="%s">%s</a><span class="breadcrumbs__sep" aria-hidden="true">/</span></li>',
				esc_url( $item['url'] ),
				esc_html( $item['name'] )
			);
		}
		$jsonld['itemListElement'][] = array(
			'@type'    => 'ListItem',
			'position' => $i + 1,
			'name'     => $item['name'],
			'item'     => $item['url'] ?: home_url( add_query_arg( null, null ) ),
		);
	}
	echo '</ol></nav>';
	echo '<script type="application/ld+json">' . wp_json_encode( $jsonld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
}

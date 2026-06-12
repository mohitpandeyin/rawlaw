<?php
/**
 * Schema.org JSON-LD for articles, authors, organisation, lawyer profiles.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Recursively strip null/empty values so JSON-LD stays clean for validators.
 *
 * @param mixed $value Value to sanitize.
 * @return mixed
 */
function rawlaw_schema_strip_empty( $value ) {
	if ( is_array( $value ) ) {
		$clean = array();
		foreach ( $value as $key => $item ) {
			$item = rawlaw_schema_strip_empty( $item );
			if ( null === $item ) {
				continue;
			}
			if ( is_array( $item ) && empty( $item ) ) {
				continue;
			}
			$clean[ $key ] = $item;
		}
		return $clean;
	}

	if ( null === $value || '' === $value ) {
		return null;
	}

	return $value;
}

function rawlaw_schema_jsonld() {
	if ( is_admin() ) { return; }
	$nodes = array();

	// Organisation node (always present).
	$logo_id = get_theme_mod( 'custom_logo' );
	$logo    = $logo_id ? wp_get_attachment_image_src( $logo_id, 'full' ) : null;
	$nodes[] = array(
		'@type' => 'NewsMediaOrganization',
		'@id'   => home_url( '/#organization' ),
		'name'  => get_bloginfo( 'name' ),
		'url'   => home_url( '/' ),
		'logo'  => $logo ? array(
			'@type'  => 'ImageObject',
			'url'    => $logo[0],
			'width'  => $logo[1],
			'height' => $logo[2],
		) : null,
		'sameAs' => array_filter( array(
			get_theme_mod( 'rawlaw_social_twitter' ),
			get_theme_mod( 'rawlaw_social_linkedin' ),
			get_theme_mod( 'rawlaw_social_facebook' ),
			get_theme_mod( 'rawlaw_social_youtube' ),
		) ),
	);

	// WebSite + SearchAction.
	$nodes[] = array(
		'@type'           => 'WebSite',
		'@id'             => home_url( '/#website' ),
		'url'             => home_url( '/' ),
		'name'            => get_bloginfo( 'name' ),
		'publisher'       => array( '@id' => home_url( '/#organization' ) ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => home_url( '/?s={search_term_string}' ),
			'query-input' => 'required name=search_term_string',
		),
	);

	if ( is_singular( 'post' ) ) {
		$post = get_queried_object();
		$nodes[] = array(
			'@type'            => 'NewsArticle',
			'@id'              => get_permalink() . '#article',
			'mainEntityOfPage' => get_permalink(),
			'headline'         => get_the_title(),
			'description'      => wp_strip_all_tags( get_the_excerpt() ),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'image'            => has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'rawlaw-hero' ) : null,
			'articleSection'   => rawlaw_primary_category() ? rawlaw_primary_category()->name : null,
			'author'           => array(
				'@type' => 'Person',
				'name'  => get_the_author_meta( 'display_name', $post->post_author ),
				'url'   => get_author_posts_url( $post->post_author ),
			),
			'publisher'        => array( '@id' => home_url( '/#organization' ) ),
		);
	}

	if ( is_singular( 'lawyer' ) ) {
		$id = get_the_ID();
		$rating = rawlaw_lawyer_rating( $id );
		$practice = get_the_terms( $id, 'practice_area' );
		$location = get_the_terms( $id, 'lawyer_location' );

		$node = array(
			'@type'       => 'Attorney',
			'@id'         => get_permalink() . '#lawyer',
			'name'        => get_the_title(),
			'description' => wp_strip_all_tags( get_the_excerpt() ),
			'url'         => get_permalink(),
			'image'       => has_post_thumbnail() ? wp_get_attachment_image_url( get_post_thumbnail_id(), 'rawlaw-square' ) : null,
			'knowsAbout'  => $practice ? wp_list_pluck( $practice, 'name' ) : null,
			'areaServed'  => $location ? wp_list_pluck( $location, 'name' ) : null,
		);
		if ( $rating ) {
			$node['aggregateRating'] = array(
				'@type'       => 'AggregateRating',
				'ratingValue' => $rating['avg'],
				'reviewCount' => $rating['count'],
				'bestRating'  => 5,
				'worstRating' => 1,
			);
		}
		$nodes[] = $node;
	}

	$nodes = array_values( array_filter( array_map( 'rawlaw_schema_strip_empty', $nodes ) ) );
	$out = rawlaw_schema_strip_empty( array( '@context' => 'https://schema.org', '@graph' => $nodes ) );
	echo "\n<script type=\"application/ld+json\">" . wp_json_encode( $out, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
}
add_action( 'wp_head', 'rawlaw_schema_jsonld', 20 );

<?php
/**
 * Customizer options.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_customize_register( $wp_customize ) {
	// Branding section.
	$wp_customize->add_section( 'rawlaw_brand', array(
		'title'    => __( 'RawLaw — Brand & Social', 'rawlaw' ),
		'priority' => 30,
	) );

	// Translated at definition (literal strings) so i18n tooling can extract
	// them — __( $variable ) is not extractable.
	$socials = array(
		'twitter'   => __( 'X / Twitter URL', 'rawlaw' ),
		'linkedin'  => __( 'LinkedIn URL', 'rawlaw' ),
		'facebook'  => __( 'Facebook URL', 'rawlaw' ),
		'youtube'   => __( 'YouTube URL', 'rawlaw' ),
		'instagram' => __( 'Instagram URL', 'rawlaw' ),
	);
	foreach ( $socials as $key => $label ) {
		$id = 'rawlaw_social_' . $key;
		$wp_customize->add_setting( $id, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => $label,
			'section' => 'rawlaw_brand',
			'type'    => 'url',
		) );
	}

	$wp_customize->add_setting( 'rawlaw_tagline', array(
		'default'           => __( 'Legal news, judgments and analysis — for India.', 'rawlaw' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rawlaw_tagline', array(
		'label'   => __( 'Editorial tagline (homepage hero)', 'rawlaw' ),
		'section' => 'rawlaw_brand',
	) );

	// Homepage section.
	$wp_customize->add_section( 'rawlaw_home', array(
		'title'    => __( 'RawLaw — Homepage', 'rawlaw' ),
		'priority' => 31,
	) );

	$wp_customize->add_setting( 'rawlaw_home_section_cats', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rawlaw_home_section_cats', array(
		'label'       => __( 'Homepage category sections (comma-separated slugs)', 'rawlaw' ),
		'description' => __( 'e.g. supreme-court,high-court,policy,opinion', 'rawlaw' ),
		'section'     => 'rawlaw_home',
	) );

	// Newsletter.
	$wp_customize->add_setting( 'rawlaw_newsletter_action', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'rawlaw_newsletter_action', array(
		'label'       => __( 'Newsletter form action URL', 'rawlaw' ),
		'description' => __( 'Mailchimp / ConvertKit / Substack form endpoint.', 'rawlaw' ),
		'section'     => 'rawlaw_brand',
		'type'        => 'url',
	) );

	// Default OG image — used when a post has neither its own SEO image
	// override nor a featured image (spec 17).
	$wp_customize->add_setting( 'rawlaw_default_og_image', array(
		'default'           => '',
		'sanitize_callback' => 'absint',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'rawlaw_default_og_image', array(
		'label'       => __( 'Default social-share image', 'rawlaw' ),
		'description' => __( 'Used for og:image/twitter:image when a page has no featured image and no per-post override. Falls back to the site logo if left empty.', 'rawlaw' ),
		'section'     => 'rawlaw_brand',
		'mime_type'   => 'image',
	) ) );
}
add_action( 'customize_register', 'rawlaw_customize_register' );

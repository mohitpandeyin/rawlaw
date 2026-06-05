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

	$socials = array(
		'twitter'  => 'X / Twitter URL',
		'linkedin' => 'LinkedIn URL',
		'facebook' => 'Facebook URL',
		'youtube'  => 'YouTube URL',
		'instagram'=> 'Instagram URL',
	);
	foreach ( $socials as $key => $label ) {
		$id = 'rawlaw_social_' . $key;
		$wp_customize->add_setting( $id, array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		) );
		$wp_customize->add_control( $id, array(
			'label'   => __( $label, 'rawlaw' ),
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

	// Google Analytics / GA4 Measurement ID for AMP analytics.
	$wp_customize->add_setting( 'rawlaw_ga_id', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rawlaw_ga_id', array(
		'label'       => __( 'GA4 Measurement ID', 'rawlaw' ),
		'description' => __( 'e.g. G-XXXXXXXXXX — used for AMP analytics.', 'rawlaw' ),
		'section'     => 'rawlaw_brand',
	) );
}
add_action( 'customize_register', 'rawlaw_customize_register' );

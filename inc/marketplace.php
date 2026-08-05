<?php
/**
 * Marketplace query helpers (filters, search).
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Modify the lawyer archive query based on query-string filters.
 */
function rawlaw_filter_lawyer_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) { return; }
	if ( ! ( $query->is_post_type_archive( 'lawyer' ) || $query->is_tax( array( 'practice_area', 'lawyer_location' ) ) ) ) { return; }

	$query->set( 'posts_per_page', 12 );

	$tax_query  = array();
	$meta_query = array();

	if ( ! empty( $_GET['practice'] ) ) {
		$tax_query[] = array(
			'taxonomy' => 'practice_area',
			'field'    => 'slug',
			'terms'    => array_map( 'sanitize_title', (array) $_GET['practice'] ),
		);
	}
	if ( ! empty( $_GET['location'] ) ) {
		$tax_query[] = array(
			'taxonomy' => 'lawyer_location',
			'field'    => 'slug',
			'terms'    => array_map( 'sanitize_title', (array) $_GET['location'] ),
		);
	}
	// `city` is the free-text equivalent of `location` — used by the homepage
	// router. Resolved against the lawyer_location taxonomy only; the old
	// `_rawlaw_city` meta fallback was dead code (never registered in any
	// UI, so never written) and is retired per spec 15 §5.2.
	if ( ! empty( $_GET['city'] ) ) {
		$city = sanitize_text_field( wp_unslash( $_GET['city'] ) );
		$term = get_term_by( 'name', $city, 'lawyer_location' );
		if ( $term && ! is_wp_error( $term ) ) {
			$tax_query[] = array(
				'taxonomy' => 'lawyer_location',
				'field'    => 'slug',
				'terms'    => array( $term->slug ),
			);
		}
	}
	// Free-text `q` from the homepage smart-search — wires into WP_Query `s`.
	if ( ! empty( $_GET['q'] ) ) {
		$query->set( 's', sanitize_text_field( wp_unslash( $_GET['q'] ) ) );
	}
	if ( ! empty( $_GET['min_exp'] ) ) {
		// Named clause so a simultaneous ?sort=experience can order by this
		// exact clause instead of adding a second meta_key/orderby pair on
		// the same key, which would JOIN wp_postmeta twice (spec register T-19).
		$meta_query['experience'] = array(
			'key'     => '_rawlaw_experience',
			'value'   => (int) $_GET['min_exp'],
			'compare' => '>=',
			'type'    => 'NUMERIC',
		);
	}
	if ( ! empty( $_GET['verified'] ) ) {
		$meta_query[] = array( 'key' => '_rawlaw_verified', 'value' => '1' );
	}

	if ( $tax_query ) { $query->set( 'tax_query', $tax_query ); }

	if ( ! empty( $_GET['sort'] ) && 'experience' === $_GET['sort'] ) {
		if ( ! isset( $meta_query['experience'] ) ) {
			$meta_query['experience'] = array(
				'key'     => '_rawlaw_experience',
				'compare' => 'EXISTS',
				'type'    => 'NUMERIC',
			);
		}
		$query->set( 'orderby', array( 'experience' => 'DESC' ) );
	}

	if ( $meta_query ) { $query->set( 'meta_query', $meta_query ); }
}
add_action( 'pre_get_posts', 'rawlaw_filter_lawyer_archive' );

/**
 * Text reviews (no star rating — see spec 15 §3.5 / roadmap 0.11) are
 * still supported via the standard comment form on lawyer profiles.
 */
function rawlaw_review_post_supports() {
	add_post_type_support( 'lawyer', 'comments' );
}
add_action( 'init', 'rawlaw_review_post_supports' );

/**
 * Handle consultation enquiry form submissions from lawyer profiles.
 *
 * Stores the enquiry as a private custom-post-type entry and emails the lawyer.
 * Provides a baseline. Site owners can integrate CRMs by hooking `rawlaw_consult_after`.
 */
function rawlaw_handle_consultation() {
	// Honeypot — bots fill hidden fields; humans don't. Matches the
	// rl_website convention already used in inc/search-router.php.
	if ( ! empty( $_POST['rl_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'consult', 'sent', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	if ( ! isset( $_POST['rawlaw_consult_nonce'] ) || ! wp_verify_nonce( $_POST['rawlaw_consult_nonce'], 'rawlaw_consult' ) ) {
		wp_die( esc_html__( 'Invalid request.', 'rawlaw' ), 400 );
	}

	// Rate limit — max 3 submissions per IP per hour, matching contact-form.php.
	$ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$rate_key = 'rawlaw_consult_rl_' . md5( $ip . wp_salt( 'auth' ) );
	$attempts = (int) get_transient( $rate_key );
	if ( $attempts >= 3 ) {
		wp_die( esc_html__( 'Too many submissions. Please try again in an hour.', 'rawlaw' ), 429 );
	}
	set_transient( $rate_key, $attempts + 1, HOUR_IN_SECONDS );

	$lawyer_id = isset( $_POST['lawyer_id'] ) ? (int) $_POST['lawyer_id'] : 0;
	if ( ! $lawyer_id || 'lawyer' !== get_post_type( $lawyer_id ) ) {
		wp_die( esc_html__( 'Invalid lawyer.', 'rawlaw' ), 400 );
	}

	$data = array(
		'name'    => isset( $_POST['name'] )    ? sanitize_text_field( wp_unslash( $_POST['name'] ) )    : '',
		'email'   => isset( $_POST['email'] )   ? sanitize_email( wp_unslash( $_POST['email'] ) )         : '',
		'phone'   => isset( $_POST['phone'] )   ? sanitize_text_field( wp_unslash( $_POST['phone'] ) )    : '',
		'city'    => isset( $_POST['city'] )    ? sanitize_text_field( wp_unslash( $_POST['city'] ) )     : '',
		'message' => isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '',
	);

	if ( ! $data['name'] || ! is_email( $data['email'] ) || ! $data['message'] ) {
		wp_safe_redirect( add_query_arg( 'consult', 'invalid', wp_get_referer() ) ); exit;
	}

	$author = get_userdata( get_post_field( 'post_author', $lawyer_id ) );
	$to     = $author && $author->user_email ? $author->user_email : get_option( 'admin_email' );
	$subj   = sprintf( __( 'New consultation enquiry — %s', 'rawlaw' ), get_the_title( $lawyer_id ) );
	$body   = sprintf(
		"Name: %s\nEmail: %s\nPhone: %s\nCity: %s\n\nMessage:\n%s\n\nEnquiry sent via RawLaw.",
		$data['name'], $data['email'], $data['phone'], $data['city'], $data['message']
	);
	wp_mail( $to, $subj, $body, array( 'Reply-To: ' . $data['email'] ) );

	do_action( 'rawlaw_consult_after', $lawyer_id, $data );

	wp_safe_redirect( add_query_arg( 'consult', 'sent', get_permalink( $lawyer_id ) ) ); exit;
}
add_action( 'admin_post_nopriv_rawlaw_consult', 'rawlaw_handle_consultation' );
add_action( 'admin_post_rawlaw_consult',        'rawlaw_handle_consultation' );

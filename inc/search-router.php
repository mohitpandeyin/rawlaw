<?php
/**
 * Smart legal-help router + Post-a-Requirement subsystem.
 *
 * Three responsibilities:
 *   1. `template_redirect` router — intercepts `?rl_lookup=1&rl_q=...&rl_city=...`,
 *      maps the free-text query to a known practice area, and either routes the
 *      visitor to the lawyer archive (high-confidence match) or to the
 *      Post-a-Requirement page (free-form intent).
 *   2. `legal_requirement` private CPT — stores submissions for moderators.
 *   3. Form handler — accepts requirement submissions via admin-post.php,
 *      validates, stores, emails admins, and redirects with a status flag.
 *
 * Designed AMP-safe: no JS, no client-side state, all server-side decisions.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ------------------------------------------------------------------
 * 1. Synonym map — query keywords → practice_area slugs.
 *    Keep this in PHP (small, fast, no DB hits). Filterable so sites
 *    can extend mappings without forking the theme.
 * ------------------------------------------------------------------ */
function rawlaw_practice_area_synonyms() {
	$map = array(
		'family-law' => array(
			'divorce', 'mutual divorce', 'maintenance', 'alimony', 'custody', 'child custody',
			'marriage', 'matrimonial', 'domestic violence', 'dowry', '498a', '498 a', 'adoption',
			'guardian', 'nikah', 'khula', 'judicial separation', 'restitution',
		),
		'criminal-law' => array(
			'criminal', 'bail', 'anticipatory bail', 'fir', 'arrest', 'ipc', 'bns',
			'cheque bounce', 'ni act', '138', 'pocso', 'ndps', 'theft', 'assault',
			'fraud', 'cheating', '420', 'murder', 'rape', 'kidnap',
		),
		'property' => array(
			'property', 'real estate', 'land', 'plot', 'flat', 'house', 'tenancy', 'rent',
			'rera', 'partition', 'mutation', 'registration', 'sale deed', 'gift deed',
			'lease', 'eviction', 'ancestral property', 'will', 'succession',
		),
		'consumer-protection' => array(
			'consumer', 'consumer complaint', 'refund', 'defective', 'product complaint',
			'service deficiency', 'amazon', 'flipkart', 'airline', 'builder',
		),
		'labour-employment' => array(
			'labour', 'labor', 'employment', 'employee', 'termination', 'fired',
			'wrongful termination', 'pf', 'provident fund', 'gratuity', 'esi',
			'salary not paid', 'bonus', 'industrial dispute', 'pos h', 'posh',
			'workplace harassment',
		),
		'cyber-crime' => array(
			'cyber', 'cybercrime', 'hacking', 'online fraud', 'phishing', 'upi fraud',
			'social media', 'defamation online', 'data breach', 'it act', 'identity theft',
		),
		'corporate' => array(
			'corporate', 'company', 'business', 'contract', 'agreement', 'mou',
			'shareholder', 'partnership', 'llp', 'startup', 'investment', 'sebi',
			'nclt', 'insolvency', 'ibc',
		),
		'tax' => array(
			'tax', 'income tax', 'gst', 'tds', 'notice from tax', 'assessment',
			'appeal income tax', 'gstr',
		),
		'motor-accident' => array(
			'accident', 'motor accident', 'road accident', 'insurance claim',
			'mact', 'hit and run', 'vehicle',
		),
		'constitutional' => array(
			'fundamental right', 'writ', 'habeas corpus', 'mandamus', 'pil',
			'public interest', 'constitutional',
		),
		'immigration' => array(
			'immigration', 'visa', 'passport', 'oci', 'pio', 'citizenship', 'fcra',
		),
	);
	return apply_filters( 'rawlaw_practice_area_synonyms', $map );
}

/**
 * Best-effort match: free-text query → practice_area slug.
 *
 * Strategy (cheap, deterministic, no external services):
 *   1. Normalise: lowercase, collapse whitespace.
 *   2. Try the synonym map first — longest synonyms first to prefer specific terms.
 *   3. Fall back to matching against existing `practice_area` term names/slugs.
 *   4. Return the first matched slug, or empty string.
 */
function rawlaw_match_practice_area( $query ) {
	$query = strtolower( trim( (string) $query ) );
	if ( '' === $query ) { return ''; }
	$query = preg_replace( '/\s+/', ' ', $query );

	$synonyms = rawlaw_practice_area_synonyms();

	// Flatten + sort by length desc so "cheque bounce" beats "cheque".
	$flat = array();
	foreach ( $synonyms as $slug => $words ) {
		foreach ( $words as $word ) { $flat[] = array( $slug, $word ); }
	}
	usort( $flat, static function ( $a, $b ) {
		return strlen( $b[1] ) - strlen( $a[1] );
	} );

	foreach ( $flat as $pair ) {
		list( $slug, $word ) = $pair;
		// Word-boundary match to avoid false positives ("art" in "partition").
		if ( preg_match( '/(^|\W)' . preg_quote( $word, '/' ) . '($|\W)/u', $query ) ) {
			return $slug;
		}
	}

	// Fallback: match registered taxonomy terms by name/slug.
	$terms = get_terms( array(
		'taxonomy'   => 'practice_area',
		'hide_empty' => false,
		'number'     => 100,
	) );
	if ( ! is_wp_error( $terms ) && $terms ) {
		foreach ( $terms as $term ) {
			$name = strtolower( $term->name );
			$slug = strtolower( $term->slug );
			if ( $name && false !== strpos( $query, $name ) ) { return $term->slug; }
			if ( $slug && false !== strpos( $query, str_replace( '-', ' ', $slug ) ) ) { return $term->slug; }
		}
	}

	return '';
}

/* ------------------------------------------------------------------
 * 2. The router — runs on `template_redirect` whenever `rl_lookup=1`.
 * ------------------------------------------------------------------ */
function rawlaw_search_router() {
	if ( empty( $_GET['rl_lookup'] ) ) { return; }

	$q    = isset( $_GET['rl_q'] )    ? sanitize_text_field( wp_unslash( $_GET['rl_q'] ) )    : '';
	$city = isset( $_GET['rl_city'] ) ? sanitize_text_field( wp_unslash( $_GET['rl_city'] ) ) : '';

	$q    = mb_substr( $q, 0, 240 );
	$city = mb_substr( $city, 0, 60 );

	// Empty query → just open the lawyer marketplace.
	if ( '' === $q ) {
		wp_safe_redirect( get_post_type_archive_link( 'lawyer' ) ?: home_url( '/' ) );
		exit;
	}

	$matched = rawlaw_match_practice_area( $q );

	if ( $matched ) {
		$archive = get_post_type_archive_link( 'lawyer' ) ?: home_url( '/lawyers/' );
		$args    = array( 'practice' => $matched );
		if ( $city ) { $args['city'] = $city; }
		// Preserve the original query so the archive can show "Showing results for …".
		$args['q'] = $q;
		wp_safe_redirect( add_query_arg( $args, $archive ) );
		exit;
	}

	// No confident match → guide the visitor to post a requirement.
	$target = rawlaw_get_post_requirement_url();
	$args   = array( 'intent' => $q );
	if ( $city ) { $args['city'] = $city; }
	wp_safe_redirect( add_query_arg( array_map( 'rawurlencode', $args ), $target ) );
	exit;
}
add_action( 'template_redirect', 'rawlaw_search_router', 1 );

/* ------------------------------------------------------------------
 * 3. Resolve the Post-a-Requirement URL.
 *    Auto-creates the page on first call if missing so the router
 *    always has somewhere safe to send users.
 * ------------------------------------------------------------------ */
function rawlaw_get_post_requirement_url() {
	$page_id = (int) get_option( 'rawlaw_post_requirement_page_id', 0 );

	if ( $page_id && 'publish' === get_post_status( $page_id ) ) {
		return get_permalink( $page_id );
	}

	// Try to find an existing page with our template assigned.
	$existing = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'page-templates/post-requirement.php',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );
	if ( ! empty( $existing ) ) {
		update_option( 'rawlaw_post_requirement_page_id', (int) $existing[0] );
		return get_permalink( $existing[0] );
	}

	// Auto-create.
	$new_id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => __( 'Post a Legal Requirement', 'rawlaw' ),
		'post_name'    => 'post-a-requirement',
		'post_content' => '', // Template renders all content; body is left empty by design.
		'meta_input'   => array(
			'_wp_page_template' => 'page-templates/post-requirement.php',
		),
	) );

	if ( $new_id && ! is_wp_error( $new_id ) ) {
		update_option( 'rawlaw_post_requirement_page_id', (int) $new_id );
		return get_permalink( $new_id );
	}

	return home_url( '/post-a-requirement/' );
}

/* ------------------------------------------------------------------
 * 4. `legal_requirement` private CPT — stores citizen submissions.
 * ------------------------------------------------------------------ */
function rawlaw_register_legal_requirement_cpt() {
	register_post_type( 'legal_requirement', array(
		'labels' => array(
			'name'          => __( 'Legal Requirements', 'rawlaw' ),
			'singular_name' => __( 'Legal Requirement', 'rawlaw' ),
			'menu_name'     => __( 'Requirements', 'rawlaw' ),
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'rewrite'             => false,
		'menu_icon'           => 'dashicons-megaphone',
		'menu_position'       => 23,
		'capability_type'     => 'post',
		'supports'            => array( 'title', 'editor', 'custom-fields' ),
	) );
}
add_action( 'init', 'rawlaw_register_legal_requirement_cpt' );

/* ------------------------------------------------------------------
 * 5. Submission handler — admin-post.php?action=rawlaw_post_requirement
 * ------------------------------------------------------------------ */
function rawlaw_handle_post_requirement() {
	$referer = wp_get_referer() ?: home_url( '/' );

	// Honeypot — bots fill hidden fields; humans don't.
	if ( ! empty( $_POST['rl_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'requirement', 'sent', $referer ) );
		exit;
	}

	if ( ! isset( $_POST['rawlaw_req_nonce'] ) || ! wp_verify_nonce( $_POST['rawlaw_req_nonce'], 'rawlaw_post_requirement' ) ) {
		wp_safe_redirect( add_query_arg( 'requirement', 'invalid', $referer ) );
		exit;
	}

	$name    = isset( $_POST['name'] )    ? sanitize_text_field( wp_unslash( $_POST['name'] ) )        : '';
	$email   = isset( $_POST['email'] )   ? sanitize_email( wp_unslash( $_POST['email'] ) )            : '';
	$phone   = isset( $_POST['phone'] )   ? sanitize_text_field( wp_unslash( $_POST['phone'] ) )       : '';
	$city    = isset( $_POST['city'] )    ? sanitize_text_field( wp_unslash( $_POST['city'] ) )        : '';
	$area    = isset( $_POST['area'] )    ? sanitize_title( wp_unslash( $_POST['area'] ) )             : '';
	$budget  = isset( $_POST['budget'] )  ? sanitize_text_field( wp_unslash( $_POST['budget'] ) )      : '';
	$mode    = isset( $_POST['mode'] )    ? sanitize_text_field( wp_unslash( $_POST['mode'] ) )        : '';
	$urgency = isset( $_POST['urgency'] ) ? sanitize_text_field( wp_unslash( $_POST['urgency'] ) )     : '';
	$details = isset( $_POST['details'] ) ? sanitize_textarea_field( wp_unslash( $_POST['details'] ) ) : '';
	$consent = ! empty( $_POST['consent'] );

	// Validation — fail-fast with a single status flag back to the form.
	if ( ! $consent || ! $name || ! is_email( $email ) || strlen( $details ) < 20 ) {
		$back = add_query_arg(
			array(
				'requirement' => 'invalid',
				'intent'      => rawurlencode( $details ),
				'city'        => rawurlencode( $city ),
			),
			$referer
		);
		wp_safe_redirect( $back );
		exit;
	}

	$title = wp_trim_words( $details, 10, '…' );
	if ( $area ) {
		$title = ucwords( str_replace( '-', ' ', $area ) ) . ' — ' . $title;
	}

	$post_id = wp_insert_post( array(
		'post_type'    => 'legal_requirement',
		'post_status'  => 'private',
		'post_title'   => $title,
		'post_content' => $details,
	) );

	if ( ! $post_id || is_wp_error( $post_id ) ) {
		wp_safe_redirect( add_query_arg( 'requirement', 'error', $referer ) );
		exit;
	}

	// Store meta — using namespaced keys (`_rawlaw_*`) so it's hidden from REST by default.
	$meta = array(
		'_rawlaw_req_name'    => $name,
		'_rawlaw_req_email'   => $email,
		'_rawlaw_req_phone'   => $phone,
		'_rawlaw_req_city'    => $city,
		'_rawlaw_req_area'    => $area,
		'_rawlaw_req_budget'  => $budget,
		'_rawlaw_req_mode'    => $mode,
		'_rawlaw_req_urgency' => $urgency,
		'_rawlaw_req_ip'      => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
		'_rawlaw_req_ua'      => isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '',
	);
	foreach ( $meta as $k => $v ) { update_post_meta( $post_id, $k, $v ); }

	// Link the practice area taxonomy if it matches a real term.
	if ( $area ) {
		$term = get_term_by( 'slug', $area, 'practice_area' );
		if ( $term && ! is_wp_error( $term ) ) {
			wp_set_object_terms( $post_id, array( (int) $term->term_id ), 'practice_area' );
		}
	}

	// Notify admins.
	$admin_email = get_option( 'admin_email' );
	$subject     = sprintf( __( '[RawLaw] New legal requirement — %s', 'rawlaw' ), $title );
	$body        = sprintf(
		"A new legal requirement has been posted on RawLaw.\n\nName: %s\nEmail: %s\nPhone: %s\nCity: %s\nPractice Area: %s\nBudget: %s\nMode: %s\nUrgency: %s\n\nDetails:\n%s\n\nReview: %s",
		$name, $email, $phone, $city, $area, $budget, $mode, $urgency, $details,
		admin_url( 'post.php?post=' . $post_id . '&action=edit' )
	);
	wp_mail( $admin_email, $subject, $body, array( 'Reply-To: ' . $email ) );

	do_action( 'rawlaw_requirement_posted', $post_id, $meta );

	$thanks = add_query_arg( 'requirement', 'sent', $referer );
	wp_safe_redirect( $thanks );
	exit;
}
add_action( 'admin_post_nopriv_rawlaw_post_requirement', 'rawlaw_handle_post_requirement' );
add_action( 'admin_post_rawlaw_post_requirement',        'rawlaw_handle_post_requirement' );

/* ------------------------------------------------------------------
 * 6. On theme switch — flush rewrites and ensure the requirement page exists.
 * ------------------------------------------------------------------ */
function rawlaw_search_router_activate() {
	rawlaw_register_legal_requirement_cpt();
	rawlaw_get_post_requirement_url(); // Side-effect: auto-creates the page.
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'rawlaw_search_router_activate' );

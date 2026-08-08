<?php
/**
 * Smart legal-help router — no-JS fallback for the homepage query intake.
 *
 * With JavaScript on, the homepage hero's query form is intercepted by
 * `assets/js/main.js` and opens a modal that submits straight to
 * `https://app.rawlaw.in/register/client` — this file's router never
 * runs in that path. This is purely the fallback for a JS-disabled
 * submission of the simple hero form (`?rl_lookup=1&rl_q=...&rl_city=...`):
 * it best-effort matches the free text to a known practice area, then
 * redirects to the same app.rawlaw.in intake, pre-filled.
 *
 * Before 2026-08-07 a confident match instead routed to a local `lawyer`
 * archive, and no match routed to a local `legal_requirement` CPT/form.
 * Both were removed the same day — lawyer data lives on app.rawlaw.in
 * (never stored here), and the local intake form was the site's only
 * surviving lead-capture path after that, itself now replaced by a
 * direct handoff. See docs/AUDIT.md.
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
 *    No-JS fallback only (see file docblock) — hands off to
 *    app.rawlaw.in exactly like the JS-enabled modal does.
 * ------------------------------------------------------------------ */
function rawlaw_search_router() {
	if ( empty( $_GET['rl_lookup'] ) ) { return; }

	$q    = isset( $_GET['rl_q'] )    ? sanitize_text_field( wp_unslash( $_GET['rl_q'] ) )    : '';
	$city = isset( $_GET['rl_city'] ) ? sanitize_text_field( wp_unslash( $_GET['rl_city'] ) ) : '';

	$q    = mb_substr( $q, 0, 240 );
	$city = mb_substr( $city, 0, 60 );

	$args = array();
	if ( $q ) {
		// No separate title field in this simple fallback form — the same
		// text seeds both, matching how the JS wizard's two fields behave
		// when someone only fills the one-line hero input.
		$args['title']       = mb_substr( $q, 0, 140 );
		$args['description'] = $q;
		$matched = rawlaw_match_practice_area( $q );
		if ( $matched ) { $args['category'] = $matched; }
	}
	if ( $city ) { $args['city'] = $city; }

	$target = 'https://app.rawlaw.in/register/client';
	// wp_redirect(), not wp_safe_redirect(): app.rawlaw.in is a known,
	// hardcoded first-party domain (used the same way elsewhere in this
	// theme), not a value derived from user input, so the safe-redirect
	// host allowlist isn't the right tool here — it would just silently
	// downgrade this to a same-site redirect instead of the intended one.
	wp_redirect( $args ? add_query_arg( array_map( 'rawurlencode', $args ), $target ) : $target, 302 );
	exit;
}
add_action( 'template_redirect', 'rawlaw_search_router', 1 );

/* ------------------------------------------------------------------
 * 3. Old /post-a-requirement/ URL — the form/CPT it served are gone
 *    (2026-08-07, see docs/AUDIT.md). 301 anyone who still has it
 *    bookmarked or indexed straight to the same app.rawlaw.in intake.
 * ------------------------------------------------------------------ */
function rawlaw_redirect_old_post_requirement_url() {
	if ( is_admin() ) { return; }
	$path = trim( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ) ), PHP_URL_PATH ), '/' );
	if ( 'post-a-requirement' !== $path && 'post-a-requirement-2' !== $path ) { return; }
	wp_redirect( 'https://app.rawlaw.in/register/client', 301 );
	exit;
}
add_action( 'template_redirect', 'rawlaw_redirect_old_post_requirement_url', 0 );
add_action( 'after_switch_theme', 'rawlaw_search_router_activate' );

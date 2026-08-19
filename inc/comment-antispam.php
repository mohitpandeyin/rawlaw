<?php
/**
 * Comment spam protection: honeypot, timing check, reCAPTCHA v3.
 *
 * reCAPTCHA keys are stored via the Customizer (theme_mod), never hardcoded
 * here, since this theme ships to a public git remote.
 *
 * v3 is score-based and invisible — there's no checkbox widget. Google shows
 * a small floating badge instead; per Google's terms, either leave that badge
 * visible (default, nothing to do) or, if it's ever hidden via CSS, the page
 * must show the "protected by reCAPTCHA" text somewhere.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'RAWLAW_RECAPTCHA_ACTION', 'comment' );
define( 'RAWLAW_RECAPTCHA_THRESHOLD', 0.5 ); // Google's suggested cutoff; raise to be stricter.

/* ─────────────────────────────────────────────────────────────────────────────
 * 1. CUSTOMIZER — reCAPTCHA keys (Appearance → Customize → Comment Spam Protection)
 * ───────────────────────────────────────────────────────────────────────────── */

function rawlaw_antispam_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'rawlaw_antispam', array(
		'title'       => __( 'RawLaw — Comment Spam Protection', 'rawlaw' ),
		'priority'    => 32,
		'description' => __( 'Google reCAPTCHA v3 (invisible, score-based) keys for the comment form. Leave both blank to skip reCAPTCHA — the honeypot and timing checks below still run either way. Register a v3 key pair at google.com/recaptcha/admin for this exact domain.', 'rawlaw' ),
	) );

	$wp_customize->add_setting( 'rawlaw_recaptcha_site_key', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rawlaw_recaptcha_site_key', array(
		'label'   => __( 'reCAPTCHA v3 Site Key', 'rawlaw' ),
		'section' => 'rawlaw_antispam',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'rawlaw_recaptcha_secret_key', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rawlaw_recaptcha_secret_key', array(
		'label'       => __( 'reCAPTCHA v3 Secret Key', 'rawlaw' ),
		'description' => __( 'Stored in the database only — never committed to theme files. Only users who can edit theme options can see it here.', 'rawlaw' ),
		'section'     => 'rawlaw_antispam',
		'type'        => 'text',
	) );
}
add_action( 'customize_register', 'rawlaw_antispam_customize_register' );

/**
 * True once both reCAPTCHA keys are configured.
 */
function rawlaw_recaptcha_configured() {
	return (bool) ( get_theme_mod( 'rawlaw_recaptcha_site_key', '' ) && get_theme_mod( 'rawlaw_recaptcha_secret_key', '' ) );
}

/* ─────────────────────────────────────────────────────────────────────────────
 * 2. HONEYPOT + TIMING FIELDS — injected at the top of the comment form
 * ───────────────────────────────────────────────────────────────────────────── */

function rawlaw_comment_form_guard_fields() {
	// Admins/editors commenting from the dashboard session are trusted — skip.
	if ( current_user_can( 'moderate_comments' ) ) {
		return;
	}

	$timestamp = time();
	$token     = $timestamp . ':' . wp_hash( $timestamp . 'rawlaw_comment_guard' );
	?>
	<p class="rawlaw-hp-wrap" aria-hidden="true" style="position:absolute!important;left:-9999px!important;top:-9999px!important;width:1px;height:1px;overflow:hidden;margin:0;padding:0;">
		<label for="rawlaw_hp_field"><?php esc_html_e( 'Leave this field blank', 'rawlaw' ); ?></label>
		<input type="text" name="rawlaw_hp_field" id="rawlaw_hp_field" value="" tabindex="-1" autocomplete="off">
	</p>
	<input type="hidden" name="rawlaw_ts_field" value="<?php echo esc_attr( $token ); ?>">
	<?php
}
add_action( 'comment_form_top', 'rawlaw_comment_form_guard_fields' );

/* ─────────────────────────────────────────────────────────────────────────────
 * 3. reCAPTCHA v3 — no widget markup; JS fetches a token on submit and the
 *    comment form is held until it's attached (see assets/js/recaptcha-v3.js)
 * ───────────────────────────────────────────────────────────────────────────── */

/**
 * Only `rawlaw-recaptcha-v3` (our own handler) is enqueued eagerly — Google's
 * `api.js` is not. `api.js?render=SITE_KEY` spins up a hidden anchor iframe
 * the moment it loads, on every page view, whether or not that visitor ever
 * touches the comment field. That iframe is Google's own code running in
 * `google.com`'s origin: it calls `requestStorageAccess()` for its risk
 * heuristics, the browser denies it under third-party-cookie restrictions,
 * and Chrome logs that denial as a console error — harmless (reCAPTCHA
 * degrades gracefully and still scores the request) but real, and it is not
 * fixable from our side: a page cannot intercept or suppress a console
 * message logged inside a cross-origin frame's own JS context.
 *
 * What *is* ours to fix is exposure: loading `api.js` on every single
 * article view for the sake of the small fraction of visitors who ever
 * write a comment is real third-party weight (script parse + an iframe
 * request) paid by everyone. `recaptcha-v3.js` now injects `api.js` itself,
 * lazily, on first interaction with the comment field — see that file for
 * the load sequencing.
 */
function rawlaw_maybe_enqueue_recaptcha() {
	if ( ! is_singular() || ! comments_open() || current_user_can( 'moderate_comments' ) || ! rawlaw_recaptcha_configured() ) {
		return;
	}

	$site_key = get_theme_mod( 'rawlaw_recaptcha_site_key', '' );

	$ver = file_exists( RAWLAW_DIR . 'assets/js/recaptcha-v3.js' )
		? filemtime( RAWLAW_DIR . 'assets/js/recaptcha-v3.js' ) : RAWLAW_VERSION;

	wp_enqueue_script(
		'rawlaw-recaptcha-v3',
		RAWLAW_URI . 'assets/js/recaptcha-v3.js',
		array(),
		$ver,
		true
	);
	wp_localize_script( 'rawlaw-recaptcha-v3', 'RawLawRecaptcha', array(
		'apiUrl'  => 'https://www.google.com/recaptcha/api.js?render=' . rawurlencode( $site_key ),
		'siteKey' => $site_key,
		'action'  => RAWLAW_RECAPTCHA_ACTION,
	) );
}
add_action( 'wp_enqueue_scripts', 'rawlaw_maybe_enqueue_recaptcha' );

/* ─────────────────────────────────────────────────────────────────────────────
 * 4. VALIDATION — runs on every comment submission, before it's saved
 * ───────────────────────────────────────────────────────────────────────────── */

function rawlaw_validate_comment_submission( $commentdata ) {
	if ( current_user_can( 'moderate_comments' ) ) {
		return $commentdata;
	}

	// 4a. Honeypot — a real visitor never fills this in.
	$honeypot = isset( $_POST['rawlaw_hp_field'] ) ? sanitize_text_field( wp_unslash( $_POST['rawlaw_hp_field'] ) ) : '';
	if ( '' !== $honeypot ) {
		rawlaw_reject_comment( __( 'Your comment looked automated and was blocked. If this is a mistake, please reload the page and try again.', 'rawlaw' ) );
	}

	// 4b. Timing — the signed timestamp must be intact and at least 4 seconds old.
	$ts_field = isset( $_POST['rawlaw_ts_field'] ) ? sanitize_text_field( wp_unslash( $_POST['rawlaw_ts_field'] ) ) : '';
	$ts_parts = explode( ':', $ts_field, 2 );
	$valid_ts = false;

	if ( 2 === count( $ts_parts ) ) {
		list( $timestamp, $hash ) = $ts_parts;
		if ( ctype_digit( $timestamp ) && hash_equals( wp_hash( $timestamp . 'rawlaw_comment_guard' ), $hash ) ) {
			$valid_ts = ( time() - (int) $timestamp ) >= 4;
		}
	}
	if ( ! $valid_ts ) {
		rawlaw_reject_comment( __( 'Your comment form expired or was submitted too quickly. Please reload the page and try again.', 'rawlaw' ) );
	}

	// 4c. reCAPTCHA v3 — only when both keys are configured.
	if ( rawlaw_recaptcha_configured() ) {
		$secret_key = get_theme_mod( 'rawlaw_recaptcha_secret_key', '' );
		$token      = isset( $_POST['g-recaptcha-response'] ) ? sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) : '';

		if ( '' === $token || ! rawlaw_verify_recaptcha( $token, $secret_key ) ) {
			rawlaw_reject_comment( __( 'Your comment could not be verified as human and was blocked. Please reload the page and try again.', 'rawlaw' ) );
		}
	}

	return $commentdata;
}
add_filter( 'preprocess_comment', 'rawlaw_validate_comment_submission' );

function rawlaw_reject_comment( $message ) {
	wp_die(
		esc_html( $message ),
		esc_html__( 'Comment Blocked', 'rawlaw' ),
		array( 'response' => 403, 'back_link' => true )
	);
}

/**
 * Verify a reCAPTCHA v3 response token against Google's siteverify endpoint.
 * v3 always returns "success" for any syntactically valid token — the real
 * signal is the score, so both are checked.
 */
function rawlaw_verify_recaptcha( $token, $secret_key ) {
	$response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
		'timeout' => 10,
		'body'    => array(
			'secret'   => $secret_key,
			'response' => $token,
			'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
		),
	) );

	if ( is_wp_error( $response ) ) {
		return false;
	}

	$body = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( empty( $body['success'] ) ) {
		return false;
	}
	if ( isset( $body['action'] ) && RAWLAW_RECAPTCHA_ACTION !== $body['action'] ) {
		return false;
	}

	return isset( $body['score'] ) && $body['score'] >= RAWLAW_RECAPTCHA_THRESHOLD;
}

<?php
/**
 * Contact form: CPT registration, admin UI, AJAX handler, rate limiting.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ─────────────────────────────────────────────────────────────────────────────
 * 1. REGISTER CPT — rawlaw_contact
 * ───────────────────────────────────────────────────────────────────────────── */

function rawlaw_register_contact_cpt() {
	register_post_type( 'rawlaw_contact', array(
		'labels' => array(
			'name'          => __( 'Contact Entries', 'rawlaw' ),
			'singular_name' => __( 'Contact Entry', 'rawlaw' ),
			'menu_name'     => __( 'Contact Inbox', 'rawlaw' ),
			'all_items'     => __( 'All Entries', 'rawlaw' ),
			'view_item'     => __( 'View Entry', 'rawlaw' ),
			'search_items'  => __( 'Search Entries', 'rawlaw' ),
			'not_found'     => __( 'No entries found.', 'rawlaw' ),
		),
		'public'             => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-email-alt',
		'menu_position'      => 30,
		'supports'           => array( 'title' ),
		'capabilities'       => array(
			'create_posts' => 'do_not_allow', // Entries are created only by the form handler.
		),
		'map_meta_cap'       => true,
	) );
}
add_action( 'init', 'rawlaw_register_contact_cpt' );

/* ─────────────────────────────────────────────────────────────────────────────
 * 2. ADMIN LIST COLUMNS
 * ───────────────────────────────────────────────────────────────────────────── */

function rawlaw_contact_columns( $columns ) {
	return array(
		'cb'       => $columns['cb'],
		'title'    => __( 'Name', 'rawlaw' ),
		'email'    => __( 'Email', 'rawlaw' ),
		'phone'    => __( 'Phone', 'rawlaw' ),
		'subject'  => __( 'Subject', 'rawlaw' ),
		'status'   => __( 'Status', 'rawlaw' ),
		'date'     => __( 'Submitted', 'rawlaw' ),
	);
}
add_filter( 'manage_rawlaw_contact_posts_columns', 'rawlaw_contact_columns' );

function rawlaw_contact_column_data( $column, $post_id ) {
	switch ( $column ) {
		case 'email':
			$email = get_post_meta( $post_id, '_contact_email', true );
			echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
			break;

		case 'phone':
			$phone = get_post_meta( $post_id, '_contact_phone', true );
			echo esc_html( $phone ?: '—' );
			break;

		case 'subject':
			echo esc_html( get_post_meta( $post_id, '_contact_subject', true ) );
			break;

		case 'status':
			$read = get_post_meta( $post_id, '_contact_read', true );
			if ( '1' === $read ) {
				echo '<span style="color:#46b450;font-weight:600;">&#10003; ' . esc_html__( 'Read', 'rawlaw' ) . '</span>';
			} else {
				echo '<span style="display:inline-block;background:#e8614d;color:#fff;padding:2px 10px;border-radius:4px;font-size:11px;font-weight:700;letter-spacing:.04em;">' . esc_html__( 'NEW', 'rawlaw' ) . '</span>';
			}
			break;
	}
}
add_action( 'manage_rawlaw_contact_posts_custom_column', 'rawlaw_contact_column_data', 10, 2 );

function rawlaw_contact_sortable_columns( $columns ) {
	$columns['subject'] = 'subject';
	return $columns;
}
add_filter( 'manage_edit-rawlaw_contact_sortable_columns', 'rawlaw_contact_sortable_columns' );

/* ─────────────────────────────────────────────────────────────────────────────
 * 3. ADMIN META BOX — full entry detail view
 * ───────────────────────────────────────────────────────────────────────────── */

function rawlaw_contact_meta_box() {
	add_meta_box(
		'rawlaw_contact_details',
		__( 'Contact Details', 'rawlaw' ),
		'rawlaw_contact_meta_box_cb',
		'rawlaw_contact',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_rawlaw_contact', 'rawlaw_contact_meta_box' );

function rawlaw_contact_meta_box_cb( $post ) {
	$email   = get_post_meta( $post->ID, '_contact_email', true );
	$phone   = get_post_meta( $post->ID, '_contact_phone', true );
	$subject = get_post_meta( $post->ID, '_contact_subject', true );
	$message = get_post_meta( $post->ID, '_contact_message', true );
	$sent_at = get_post_meta( $post->ID, '_contact_submitted_at', true );
	$read    = get_post_meta( $post->ID, '_contact_read', true );
	?>
	<table class="form-table" style="font-size:13px;">
		<tr>
			<th style="width:120px;"><?php esc_html_e( 'Name', 'rawlaw' ); ?></th>
			<td><?php echo esc_html( get_the_title( $post->ID ) ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Email', 'rawlaw' ); ?></th>
			<td><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Phone', 'rawlaw' ); ?></th>
			<td><?php echo esc_html( $phone ?: '—' ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Subject', 'rawlaw' ); ?></th>
			<td><?php echo esc_html( $subject ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Message', 'rawlaw' ); ?></th>
			<td>
				<div style="background:#f8f8f8;border:1px solid #ddd;border-radius:4px;padding:12px 14px;white-space:pre-wrap;line-height:1.6;max-width:680px;">
					<?php echo esc_html( $message ); ?>
				</div>
			</td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Submitted', 'rawlaw' ); ?></th>
			<td><?php echo esc_html( $sent_at ?: get_the_date( 'j M Y, g:i a', $post->ID ) ); ?></td>
		</tr>
		<tr>
			<th><?php esc_html_e( 'Status', 'rawlaw' ); ?></th>
			<td>
				<?php wp_nonce_field( 'rawlaw_contact_read_' . $post->ID, '_rawlaw_read_nonce' ); ?>
				<label style="cursor:pointer;">
					<input type="checkbox" name="_contact_read" value="1" <?php checked( $read, '1' ); ?>>
					<?php esc_html_e( 'Mark as read', 'rawlaw' ); ?>
				</label>
			</td>
		</tr>
	</table>
	<?php
}

function rawlaw_contact_save_meta( $post_id ) {
	if ( ! isset( $_POST['_rawlaw_read_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_rawlaw_read_nonce'] ) ), 'rawlaw_contact_read_' . $post_id ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$read = isset( $_POST['_contact_read'] ) ? '1' : '0';
	update_post_meta( $post_id, '_contact_read', $read );
}
add_action( 'save_post_rawlaw_contact', 'rawlaw_contact_save_meta' );

/**
 * Auto-mark entry as read when an admin opens it in the edit screen.
 */
function rawlaw_contact_auto_mark_read() {
	$screen = get_current_screen();
	if ( $screen && 'rawlaw_contact' === $screen->post_type && 'post' === $screen->base ) {
		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
		if ( $post_id && current_user_can( 'edit_post', $post_id ) ) {
			update_post_meta( $post_id, '_contact_read', '1' );
		}
	}
}
add_action( 'current_screen', 'rawlaw_contact_auto_mark_read' );

/* ─────────────────────────────────────────────────────────────────────────────
 * 4. ADMIN MENU UNREAD BADGE
 * ───────────────────────────────────────────────────────────────────────────── */

function rawlaw_contact_menu_count() {
	$unread = new WP_Query( array(
		'post_type'      => 'rawlaw_contact',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'     => '_contact_read',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => '_contact_read',
				'value'   => '0',
				'compare' => '=',
			),
		),
		'no_found_rows'  => true,
	) );

	$count = $unread->post_count;
	if ( $count > 0 ) {
		global $menu;
		foreach ( $menu as $key => $item ) {
			if ( isset( $item[2] ) && 'edit.php?post_type=rawlaw_contact' === $item[2] ) {
				$menu[ $key ][0] .= ' <span class="awaiting-mod count-' . $count . '"><span class="pending-count">' . absint( $count ) . '</span></span>';
				break;
			}
		}
	}
}
add_action( 'admin_menu', 'rawlaw_contact_menu_count', 20 );

/* ─────────────────────────────────────────────────────────────────────────────
 * 5. SERVER-SIDE VALIDATION PATTERNS (mirrored in JS)
 * ───────────────────────────────────────────────────────────────────────────── */

define( 'RAWLAW_CONTACT_SUBJECTS', array(
	'General Enquiry',
	'Advocate Registration',
	'Billing & Payments',
	'Technical Support',
	'Press & Media',
	'Legal Notice',
	'Other',
) );

/* ─────────────────────────────────────────────────────────────────────────────
 * 6. AJAX HANDLER
 * ───────────────────────────────────────────────────────────────────────────── */

function rawlaw_contact_form_submit() {
	// 1. Verify nonce.
	if (
		! isset( $_POST['nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'rawlaw_contact_nonce' )
	) {
		wp_send_json_error( array( 'message' => __( 'Security check failed. Please refresh the page and try again.', 'rawlaw' ) ), 403 );
	}

	// 2. Rate limit — max 3 submissions per IP per hour.
	$ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$rate_key = 'rawlaw_contact_rl_' . md5( $ip . wp_salt( 'auth' ) );
	$attempts = (int) get_transient( $rate_key );
	if ( $attempts >= 3 ) {
		wp_send_json_error( array( 'message' => __( 'Too many submissions. Please try again in an hour.', 'rawlaw' ) ), 429 );
	}

	// 3. Gather and sanitize raw input.
	$name    = isset( $_POST['contact_name'] )    ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) )        : '';
	$email   = isset( $_POST['contact_email'] )   ? sanitize_email( wp_unslash( $_POST['contact_email'] ) )            : '';
	$phone   = isset( $_POST['contact_phone'] )   ? sanitize_text_field( wp_unslash( $_POST['contact_phone'] ) )       : '';
	$subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) )     : '';
	$message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

	// 4. Server-side regex validation — mirrors the JS patterns exactly.
	$errors = array();

	if ( ! preg_match( '/^[a-zA-Z\s.\-\']{2,60}$/', $name ) ) {
		$errors['contact_name'] = __( 'Please enter a valid full name (2–60 letters, spaces, hyphens).', 'rawlaw' );
	}

	if ( ! preg_match( '/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/', $email ) ) {
		$errors['contact_email'] = __( 'Please enter a valid email address.', 'rawlaw' );
	}

	if ( '' !== $phone && ! preg_match( '/^(\+91[\-\s]?)?[6-9]\d{9}$/', $phone ) ) {
		$errors['contact_phone'] = __( 'Please enter a valid 10-digit Indian mobile number (e.g. 98765 43210).', 'rawlaw' );
	}

	if ( ! in_array( $subject, RAWLAW_CONTACT_SUBJECTS, true ) ) {
		$errors['contact_subject'] = __( 'Please select a valid subject from the list.', 'rawlaw' );
	}

	$msg_len = mb_strlen( $message );
	if ( $msg_len < 20 || $msg_len > 2000 ) {
		$errors['contact_message'] = $msg_len < 20
			? __( 'Message is too short — please write at least 20 characters.', 'rawlaw' )
			: __( 'Message is too long — please keep it under 2000 characters.', 'rawlaw' );
	}

	if ( ! empty( $errors ) ) {
		wp_send_json_error( array(
			'message' => __( 'Please correct the errors below and resubmit.', 'rawlaw' ),
			'fields'  => $errors,
		), 422 );
	}

	// 5. Persist as rawlaw_contact CPT post.
	$post_id = wp_insert_post( array(
		'post_title'  => sanitize_text_field( $name . ' — ' . $subject ),
		'post_status' => 'publish',
		'post_type'   => 'rawlaw_contact',
		'post_author' => 0,
	) );

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'message' => __( 'Submission failed due to a server error. Please try again.', 'rawlaw' ) ), 500 );
	}

	update_post_meta( $post_id, '_contact_email',        $email );
	update_post_meta( $post_id, '_contact_phone',        $phone );
	update_post_meta( $post_id, '_contact_subject',      $subject );
	update_post_meta( $post_id, '_contact_message',      $message );
	update_post_meta( $post_id, '_contact_ip_hash',      md5( $ip . wp_salt( 'auth' ) ) ); // Store hashed IP only — not raw, for privacy.
	update_post_meta( $post_id, '_contact_submitted_at', current_time( 'j F Y, g:i a' ) );
	update_post_meta( $post_id, '_contact_read',         '0' ); // Explicitly mark as unread.

	// 6. Increment rate-limit counter (resets after 1 hour).
	set_transient( $rate_key, $attempts + 1, HOUR_IN_SECONDS );

	// 7. Notify admin by email.
	$admin_email  = get_option( 'admin_email' );
	$subject_line = sprintf( '[RawLaw] New contact: %s', $subject );
	$body         = sprintf(
		"A new contact form submission has arrived.\n\nName:     %s\nEmail:    %s\nPhone:    %s\nSubject:  %s\n\nMessage:\n%s\n\n---\nView in WP Admin: %s",
		$name,
		$email,
		$phone ?: 'N/A',
		$subject,
		$message,
		admin_url( 'post.php?post=' . $post_id . '&action=edit' )
	);
	wp_mail( $admin_email, $subject_line, $body );

	wp_send_json_success( array(
		'message' => __( "Thank you! Your message has been received. We'll be in touch within 1–2 business days.", 'rawlaw' ),
	) );
}
add_action( 'wp_ajax_rawlaw_contact_submit',        'rawlaw_contact_form_submit' );
add_action( 'wp_ajax_nopriv_rawlaw_contact_submit', 'rawlaw_contact_form_submit' );

/* ─────────────────────────────────────────────────────────────────────────────
 * 7. LOCALIZE NONCE FOR THE CONTACT PAGE TEMPLATE
 * ───────────────────────────────────────────────────────────────────────────── */

function rawlaw_contact_localize() {
	if ( ! is_page_template( 'page-templates/contact.php' ) ) {
		return;
	}
	wp_localize_script( 'rawlaw-main', 'RawLawContact', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'rawlaw_contact_nonce' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'rawlaw_contact_localize', 20 );

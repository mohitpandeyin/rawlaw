<?php
/**
 * Lawyer profile meta boxes.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_lawyer_meta_box() {
	add_meta_box( 'rawlaw_lawyer_profile', __( 'Lawyer Profile', 'rawlaw' ), 'rawlaw_lawyer_meta_box_cb', 'lawyer', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'rawlaw_lawyer_meta_box' );

function rawlaw_lawyer_fields() {
	return array(
		'_rawlaw_designation'    => array( 'label' => __( 'Designation', 'rawlaw' ),         'type' => 'text', 'placeholder' => 'Senior Advocate' ),
		'_rawlaw_firm'           => array( 'label' => __( 'Firm / Chambers', 'rawlaw' ),     'type' => 'text' ),
		'_rawlaw_experience'     => array( 'label' => __( 'Years of experience', 'rawlaw' ), 'type' => 'number' ),
		'_rawlaw_bar_id'         => array( 'label' => __( 'Bar Council ID', 'rawlaw' ),      'type' => 'text' ),
		'_rawlaw_languages'      => array( 'label' => __( 'Languages (comma separated)', 'rawlaw' ), 'type' => 'text' ),
		'_rawlaw_email'          => array( 'label' => __( 'Public email', 'rawlaw' ),        'type' => 'email' ),
		'_rawlaw_phone'          => array( 'label' => __( 'Public phone', 'rawlaw' ),        'type' => 'text' ),
		'_rawlaw_website'        => array( 'label' => __( 'Website', 'rawlaw' ),             'type' => 'url' ),
		'_rawlaw_consultation'   => array( 'label' => __( 'Consultation fee (₹)', 'rawlaw' ),'type' => 'number' ),
		'_rawlaw_verified'       => array( 'label' => __( 'Verified by RawLaw', 'rawlaw' ),  'type' => 'checkbox' ),
		'_rawlaw_accepting'      => array( 'label' => __( 'Accepting new clients', 'rawlaw' ),'type' => 'checkbox' ),
	);
}

function rawlaw_lawyer_meta_box_cb( $post ) {
	wp_nonce_field( 'rawlaw_lawyer_save', 'rawlaw_lawyer_nonce' );
	echo '<div class="rawlaw-meta-grid" style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">';
	foreach ( rawlaw_lawyer_fields() as $key => $field ) {
		$val = get_post_meta( $post->ID, $key, true );
		echo '<p style="margin:0;display:flex;flex-direction:column;gap:6px;">';
		echo '<label for="' . esc_attr( $key ) . '"><strong>' . esc_html( $field['label'] ) . '</strong></label>';
		if ( 'checkbox' === $field['type'] ) {
			echo '<label><input type="checkbox" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="1" ' . checked( $val, '1', false ) . '> ' . esc_html__( 'Yes', 'rawlaw' ) . '</label>';
		} else {
			$ph = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
			printf(
				'<input type="%s" id="%s" name="%s" value="%s" placeholder="%s" class="widefat">',
				esc_attr( $field['type'] ),
				esc_attr( $key ),
				esc_attr( $key ),
				esc_attr( $val ),
				esc_attr( $ph )
			);
		}
		echo '</p>';
	}
	echo '</div>';
}

function rawlaw_lawyer_meta_save( $post_id ) {
	if ( ! isset( $_POST['rawlaw_lawyer_nonce'] ) || ! wp_verify_nonce( $_POST['rawlaw_lawyer_nonce'], 'rawlaw_lawyer_save' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	foreach ( rawlaw_lawyer_fields() as $key => $field ) {
		if ( 'checkbox' === $field['type'] ) {
			update_post_meta( $post_id, $key, isset( $_POST[ $key ] ) ? '1' : '' );
			continue;
		}
		if ( ! isset( $_POST[ $key ] ) ) { continue; }
		$raw = wp_unslash( $_POST[ $key ] );
		switch ( $field['type'] ) {
			case 'email':  $val = sanitize_email( $raw ); break;
			case 'url':    $val = esc_url_raw( $raw );    break;
			case 'number': $val = is_numeric( $raw ) ? $raw : ''; break;
			default:       $val = sanitize_text_field( $raw );
		}
		update_post_meta( $post_id, $key, $val );
	}
}
add_action( 'save_post_lawyer', 'rawlaw_lawyer_meta_save' );

/*--------------------------------------------------------------
 * Top News ticker — checkbox on regular posts
 *-------------------------------------------------------------*/
function rawlaw_top_news_meta_box() {
	add_meta_box(
		'rawlaw_top_news',
		__( 'Top News Ticker', 'rawlaw' ),
		'rawlaw_top_news_meta_cb',
		'post',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'rawlaw_top_news_meta_box' );

function rawlaw_top_news_meta_cb( $post ) {
	wp_nonce_field( 'rawlaw_top_news_save', 'rawlaw_top_news_nonce' );
	$checked = get_post_meta( $post->ID, '_rawlaw_top_news', true );
	?>
	<label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
		<input type="checkbox" name="_rawlaw_top_news" value="1" <?php checked( $checked, '1' ); ?>>
		<span><?php esc_html_e( 'Show in Top News ticker on homepage', 'rawlaw' ); ?></span>
	</label>
	<p class="description" style="margin-top:8px;">
		<?php esc_html_e( 'Enable this to feature the post in the scrolling ticker bar at the top of the homepage.', 'rawlaw' ); ?>
	</p>
	<?php
}

function rawlaw_top_news_meta_save( $post_id ) {
	if ( ! isset( $_POST['rawlaw_top_news_nonce'] ) || ! wp_verify_nonce( $_POST['rawlaw_top_news_nonce'], 'rawlaw_top_news_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

	$val = isset( $_POST['_rawlaw_top_news'] ) ? '1' : '';
	update_post_meta( $post_id, '_rawlaw_top_news', $val );
}
add_action( 'save_post_post', 'rawlaw_top_news_meta_save' );

/**
 * Add "Top News" column in admin post list for easy visibility.
 */
function rawlaw_top_news_column( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['rawlaw_top_news'] = __( 'Top News', 'rawlaw' );
		}
	}
	return $new;
}
add_filter( 'manage_post_posts_columns', 'rawlaw_top_news_column' );

function rawlaw_top_news_column_content( $column, $post_id ) {
	if ( 'rawlaw_top_news' === $column ) {
		echo get_post_meta( $post_id, '_rawlaw_top_news', true ) ? '<span style="color:var(--navy,#1A3F72);font-weight:700;">&#9733;</span>' : '&mdash;';
	}
}
add_action( 'manage_post_posts_custom_column', 'rawlaw_top_news_column_content', 10, 2 );

/*--------------------------------------------------------------
 * Legal requirement admin summary
 *-------------------------------------------------------------*/
function rawlaw_requirement_meta_box() {
	add_meta_box(
		'rawlaw_requirement_details',
		__( 'Requirement Details', 'rawlaw' ),
		'rawlaw_requirement_meta_box_cb',
		'legal_requirement',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'rawlaw_requirement_meta_box' );

function rawlaw_requirement_detail_fields() {
	return array(
		'_rawlaw_req_name'    => __( 'Name', 'rawlaw' ),
		'_rawlaw_req_email'   => __( 'Email', 'rawlaw' ),
		'_rawlaw_req_phone'   => __( 'Phone', 'rawlaw' ),
		'_rawlaw_req_city'    => __( 'City', 'rawlaw' ),
		'_rawlaw_req_area'    => __( 'Practice Area', 'rawlaw' ),
		'_rawlaw_req_urgency' => __( 'Urgency', 'rawlaw' ),
		'_rawlaw_req_mode'    => __( 'Preferred Mode', 'rawlaw' ),
		'_rawlaw_req_budget'  => __( 'Budget', 'rawlaw' ),
		'_rawlaw_req_source'  => __( 'Source', 'rawlaw' ),
	);
}

function rawlaw_requirement_meta_box_cb( $post ) {
	echo '<div class="rawlaw-meta-grid" style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px;">';
	foreach ( rawlaw_requirement_detail_fields() as $key => $label ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<p style="margin:0;display:flex;flex-direction:column;gap:4px;">';
		echo '<strong>' . esc_html( $label ) . '</strong>';
		echo '<span>' . esc_html( $value ? $value : '—' ) . '</span>';
		echo '</p>';
	}
	echo '</div>';
}

function rawlaw_requirement_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['rawlaw_req_contact'] = __( 'Contact', 'rawlaw' );
			$new['rawlaw_req_city']    = __( 'City', 'rawlaw' );
			$new['rawlaw_req_urgency'] = __( 'Urgency', 'rawlaw' );
		}
	}
	return $new;
}
add_filter( 'manage_legal_requirement_posts_columns', 'rawlaw_requirement_columns' );

function rawlaw_requirement_column_content( $column, $post_id ) {
	if ( 'rawlaw_req_contact' === $column ) {
		$name  = get_post_meta( $post_id, '_rawlaw_req_name', true );
		$email = get_post_meta( $post_id, '_rawlaw_req_email', true );
		$phone = get_post_meta( $post_id, '_rawlaw_req_phone', true );
		echo esc_html( trim( $name . ' ' . ( $email ? '(' . $email . ')' : '' ) ) );
		if ( $phone ) {
			echo '<br><small>' . esc_html( $phone ) . '</small>';
		}
	}
	if ( 'rawlaw_req_city' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_rawlaw_req_city', true ) ?: '—' );
	}
	if ( 'rawlaw_req_urgency' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_rawlaw_req_urgency', true ) ?: '—' );
	}
}
add_action( 'manage_legal_requirement_posts_custom_column', 'rawlaw_requirement_column_content', 10, 2 );

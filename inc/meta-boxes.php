<?php
/**
 * Meta boxes: Top News ticker.
 *
 * The lawyer-profile meta box and the Legal Requirement admin summary
 * that used to live in this file were both removed 2026-08-07, along
 * with the `lawyer` and `legal_requirement` CPTs — see docs/AUDIT.md.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

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

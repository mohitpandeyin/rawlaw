<?php
/**
 * Comments template.
 *
 * @package RawLaw
 */
if ( post_password_required() ) { return; }
?>
<section id="comments" class="comments" aria-labelledby="comments-title">
	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title" class="section__title">
			<?php
			$count = get_comments_number();
			printf( esc_html( _n( '%s comment', '%s comments', $count, 'rawlaw' ) ), number_format_i18n( $count ) );
			?>
		</h2>
		<ol class="comments__list">
			<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 48 ) ); ?>
		</ol>
		<?php the_comments_navigation( array(
			'prev_text' => __( '&larr; Older', 'rawlaw' ),
			'next_text' => __( 'Newer &rarr;', 'rawlaw' ),
		) ); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="comments__closed"><?php esc_html_e( 'Comments are closed.', 'rawlaw' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'class_form'         => 'comment-form',
		'title_reply_before' => '<h2 class="comments__reply-title">',
		'title_reply_after'  => '</h2>',
	) );
	?>
</section>

<?php
/**
 * Author bio block.
 *
 * @package RawLaw
 */
$author_id = get_the_author_meta( 'ID' );
?>
<aside class="author-bio" aria-labelledby="author-bio-heading">
	<div class="author-bio__avatar"><?php echo get_avatar( $author_id, 96 ); ?></div>
	<div class="author-bio__body">
		<p class="eyebrow"><?php esc_html_e( 'Written by', 'rawlaw' ); ?></p>
		<h2 id="author-bio-heading" class="author-bio__name">
			<a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>" rel="author"><?php echo esc_html( get_the_author() ); ?></a>
		</h2>
		<?php $desc = get_the_author_meta( 'description' ); if ( $desc ) : ?>
			<p class="author-bio__desc"><?php echo esc_html( $desc ); ?></p>
		<?php endif; ?>
		<a class="link-arrow" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
			<?php esc_html_e( 'View all articles', 'rawlaw' ); ?>
			<span aria-hidden="true">→</span>
		</a>
	</div>
</aside>

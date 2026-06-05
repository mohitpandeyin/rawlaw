<?php
/**
 * Featured article card — large hero variant.
 *
 * @package RawLaw
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card card--featured' ); ?> data-reveal>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'rawlaw-hero', array( 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async', 'alt' => '' ) ); ?>
		</a>
	<?php endif; ?>
	<div class="card__body">
		<?php rawlaw_category_eyebrow(); ?>
		<h2 class="card__title card__title--display"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<p class="card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 36 ) ); ?></p>
		<?php rawlaw_article_meta( array( 'show_avatar' => true ) ); ?>
	</div>
</article>

<?php
/**
 * Article card — default vertical card.
 *
 * @package RawLaw
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card card--article' ); ?> data-reveal>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'rawlaw-card', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?>
		</a>
	<?php endif; ?>
	<div class="card__body">
		<?php rawlaw_category_eyebrow(); ?>
		<h3 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( has_excerpt() ) : ?>
			<p class="card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
		<?php endif; ?>
		<?php rawlaw_article_meta( array( 'show_read' => true ) ); ?>
	</div>
</article>

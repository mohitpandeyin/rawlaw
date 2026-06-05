<?php
/**
 * Compact article card — horizontal, sidebar / list use.
 *
 * @package RawLaw
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card card--compact' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php the_post_thumbnail( 'rawlaw-compact', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?>
		</a>
	<?php endif; ?>
	<div class="card__body">
		<?php rawlaw_category_eyebrow(); ?>
		<h3 class="card__title card__title--sm"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="meta meta--compact">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			<span aria-hidden="true">·</span>
			<span><?php echo esc_html( rawlaw_reading_time() ); ?></span>
		</div>
	</div>
</article>

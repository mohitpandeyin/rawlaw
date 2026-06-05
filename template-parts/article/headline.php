<?php
/**
 * Headline-only list item — for "Trending" or numbered lists.
 *
 * @package RawLaw
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'headline' ); ?>>
	<div class="headline__body">
		<?php rawlaw_category_eyebrow(); ?>
		<h3 class="headline__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="meta meta--compact">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?> <?php esc_html_e( 'ago', 'rawlaw' ); ?></time>
		</div>
	</div>
</article>

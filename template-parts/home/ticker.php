<?php
/**
 * Top News Ticker — CSS-only marquee, AMP-compatible.
 *
 * @package RawLaw
 */

$ticker_q = new WP_Query( array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 6,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
	'meta_key'            => '_rawlaw_top_news',
	'meta_value'          => '1',
) );

// Fallback to latest posts if none are marked as Top News.
if ( ! $ticker_q->have_posts() ) {
	$ticker_q = new WP_Query( array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 6,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	) );
}

if ( ! $ticker_q->have_posts() ) {
	return;
}
?>
<div class="container ticker-wrap">
<div class="ticker" aria-label="<?php esc_attr_e( 'Top News', 'rawlaw' ); ?>">
	<span class="ticker__label"><?php esc_html_e( 'Top News', 'rawlaw' ); ?></span>
	<div class="ticker__track">
		<div class="ticker__marquee">
			<?php while ( $ticker_q->have_posts() ) : $ticker_q->the_post(); ?>
			<a class="ticker__item" href="<?php the_permalink(); ?>">
				<?php if ( has_post_thumbnail() ) : ?>
					<span class="ticker__thumb"><?php the_post_thumbnail( 'thumbnail' ); ?></span>
				<?php endif; ?>
				<span class="ticker__headline"><?php the_title(); ?></span>
				<span class="ticker__date">&bull; <?php echo esc_html( get_the_date() ); ?></span>
			</a>
			<?php endwhile; ?>
		</div>
		<div class="ticker__marquee" aria-hidden="true">
			<?php while ( $ticker_q->have_posts() ) : $ticker_q->the_post(); ?>
			<a class="ticker__item" href="<?php the_permalink(); ?>" tabindex="-1">
				<?php if ( has_post_thumbnail() ) : ?>
					<span class="ticker__thumb"><?php the_post_thumbnail( 'thumbnail' ); ?></span>
				<?php endif; ?>
				<span class="ticker__headline"><?php the_title(); ?></span>
				<span class="ticker__date">&bull; <?php echo esc_html( get_the_date() ); ?></span>
			</a>
			<?php endwhile; ?>
		</div>
	</div>
</div><!-- .ticker -->
</div><!-- .container -->
<?php wp_reset_postdata(); ?>

<?php
/**
 * Hero right column — Top News section.
 *
 * Displays 3-4 latest important legal articles to keep news visually prominent.
 *
 * @package RawLaw
 */

$news_q = new WP_Query( array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 5,
	'ignore_sticky_posts' => false,
	'no_found_rows'       => true,
) );

if ( ! $news_q->have_posts() ) {
	return;
}
?>

<div class="hero-news">
	<p class="hero-news__label"><?php esc_html_e( 'Top News', 'rawlaw' ); ?></p>

	<ul class="hero-news__list" role="list">
		<?php while ( $news_q->have_posts() ) : $news_q->the_post();
			$ago_label  = sprintf(
				/* translators: %s is a relative time value, e.g. 2 hours */
				__( '%s ago', 'rawlaw' ),
				human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) )
			);
		?>
			<li class="hero-news__item">
				<a class="hero-news__link" href="<?php the_permalink(); ?>">
					<span class="hero-news__title"><?php the_title(); ?></span>
					<span class="hero-news__age"><?php echo esc_html( $ago_label ); ?></span>
				</a>
			</li>
		<?php endwhile; ?>
	</ul>

	<a class="hero-news__see-more" href="<?php echo esc_url( home_url( '/news/' ) ); ?>">
		<?php esc_html_e( 'View all news', 'rawlaw' ); ?>
		<span aria-hidden="true">→</span>
	</a>
</div>

<?php wp_reset_postdata(); ?>

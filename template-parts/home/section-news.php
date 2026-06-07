<?php
/**
 * Section — Latest Legal News & Insights (newspaper-style editorial grid).
 *
 * Layout mirrors major news publications:
 * - Zone A (top): Two balanced feature stories + stacked briefs with thumbnails
 * - Zone B (middle): 4-column image stories with vertical column rules
 * - Zone C (bottom): Compact headline cards with thumbnails
 *
 * @package RawLaw
 */

if ( ! isset( $displayed_ids ) ) {
	$displayed_ids = array();
}

$news_q = new WP_Query( array(
	'post_type'           => 'post',
	'posts_per_page'      => 13,
	'post__not_in'        => $displayed_ids,
	'ignore_sticky_posts' => 1,
) );

if ( $news_q->have_posts() ) :
	$all_posts = array();
	while ( $news_q->have_posts() ) {
		$news_q->the_post();
		$displayed_ids[] = get_the_ID();
		$cats = get_the_category();
		$all_posts[] = array(
			'id'        => get_the_ID(),
			'title'     => get_the_title(),
			'permalink' => get_the_permalink(),
			'date'      => get_the_date( 'j M Y' ),
			'datetime'  => get_the_date( 'c' ),
			'cat'       => ! empty( $cats ) ? $cats[0] : null,
			'thumb'     => has_post_thumbnail() ? get_the_post_thumbnail( get_the_ID(), 'rawlaw-card', array( 'loading' => 'lazy', 'decoding' => 'async' ) ) : '',
		);
	}
	wp_reset_postdata();
?>
<section class="section section--news" aria-labelledby="news-heading" data-reveal>
	<div class="container">
		<header class="section__header section__header--newspaper">
			<h2 id="news-heading" class="section__title section__title--newspaper"><?php esc_html_e( 'News & Insights', 'rawlaw' ); ?></h2>
			<a class="link-arrow" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' ) ); ?>"><?php esc_html_e( 'View all', 'rawlaw' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</header>

		<?php // — Zone A: Two feature stories + stacked briefs — ?>
		<div class="np-zone np-zone--top" data-reveal-stagger>
			<div class="np-duo">
				<?php for ( $i = 0; $i <= 1; $i++ ) : if ( empty( $all_posts[ $i ] ) ) continue; $p = $all_posts[ $i ]; ?>
				<article class="np-feature">
					<?php if ( $p['thumb'] ) : ?>
						<a class="np-feature__media" href="<?php echo esc_url( $p['permalink'] ); ?>" aria-hidden="true" tabindex="-1">
							<?php echo $p['thumb']; ?>
						</a>
					<?php endif; ?>
					<?php if ( $p['cat'] ) : ?>
						<a class="np-cat" href="<?php echo esc_url( get_term_link( $p['cat'] ) ); ?>"><?php echo esc_html( $p['cat']->name ); ?></a>
					<?php endif; ?>
					<h3 class="np-feature__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
					<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
				</article>
				<?php endfor; ?>
			</div>

			<div class="np-stack">
				<?php for ( $i = 2; $i <= 4; $i++ ) : if ( empty( $all_posts[ $i ] ) ) continue; $p = $all_posts[ $i ]; ?>
				<article class="np-stack__item">
					<?php if ( $p['thumb'] ) : ?>
						<a class="np-stack__media" href="<?php echo esc_url( $p['permalink'] ); ?>" aria-hidden="true" tabindex="-1">
							<?php echo $p['thumb']; ?>
						</a>
					<?php endif; ?>
					<?php if ( $p['cat'] ) : ?>
						<a class="np-cat" href="<?php echo esc_url( get_term_link( $p['cat'] ) ); ?>"><?php echo esc_html( $p['cat']->name ); ?></a>
					<?php endif; ?>
					<h3 class="np-stack__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
					<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
				</article>
				<?php endfor; ?>
			</div>
		</div>

		<?php // — Zone B: 4-column image row — ?>
		<div class="np-zone np-zone--mid" data-reveal-stagger>
			<?php for ( $i = 5; $i <= 8; $i++ ) : if ( empty( $all_posts[ $i ] ) ) continue; $p = $all_posts[ $i ]; ?>
			<article class="np-col">
				<?php if ( $p['thumb'] ) : ?>
					<a class="np-col__media" href="<?php echo esc_url( $p['permalink'] ); ?>" aria-hidden="true" tabindex="-1">
						<?php echo $p['thumb']; ?>
					</a>
				<?php endif; ?>
				<?php if ( $p['cat'] ) : ?>
					<a class="np-cat" href="<?php echo esc_url( get_term_link( $p['cat'] ) ); ?>"><?php echo esc_html( $p['cat']->name ); ?></a>
				<?php endif; ?>
				<h3 class="np-col__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
				<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
			</article>
			<?php endfor; ?>
		</div>

		<?php // — Zone C: Compact headline cards with thumbnails (4-column) — ?>
		<div class="np-zone np-zone--bottom" data-reveal-stagger>
			<?php for ( $i = 9; $i <= 12; $i++ ) : if ( empty( $all_posts[ $i ] ) ) continue; $p = $all_posts[ $i ]; ?>
			<article class="np-text">
				<?php if ( $p['thumb'] ) : ?>
					<a class="np-text__media" href="<?php echo esc_url( $p['permalink'] ); ?>" aria-hidden="true" tabindex="-1">
						<?php echo $p['thumb']; ?>
					</a>
				<?php endif; ?>
				<?php if ( $p['cat'] ) : ?>
					<a class="np-cat" href="<?php echo esc_url( get_term_link( $p['cat'] ) ); ?>"><?php echo esc_html( $p['cat']->name ); ?></a>
				<?php endif; ?>
				<h3 class="np-text__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
				<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
			</article>
			<?php endfor; ?>
		</div>

		<div class="section__cta">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/news/' ) ); ?>">
				<?php esc_html_e( 'Read More News', 'rawlaw' ); ?>
			</a>
		</div>
	</div>
</section>
<?php endif;

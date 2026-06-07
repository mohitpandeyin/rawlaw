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
	'posts_per_page'      => 12,
	'post__not_in'        => $displayed_ids,
	'ignore_sticky_posts' => 1,
) );

if ( $news_q->have_posts() ) :
	$all_posts = array();
	while ( $news_q->have_posts() ) {
		$news_q->the_post();
		$displayed_ids[] = get_the_ID();
		$cats = get_the_category();
		$practice_areas = get_the_terms( get_the_ID(), 'practice_area' );
		$reading_time = function_exists( 'rawlaw_reading_time' ) ? rawlaw_reading_time( get_the_ID() ) : '';
		$is_new = ( time() - get_post_time( 'U' ) ) < DAY_IN_SECONDS;
		$all_posts[] = array(
			'id'           => get_the_ID(),
			'title'        => get_the_title(),
			'permalink'    => get_the_permalink(),
			'date'         => get_the_date( 'j M Y' ),
			'datetime'     => get_the_date( 'c' ),
			'cat'          => ! empty( $cats ) ? $cats[0] : null,
			'thumb'        => has_post_thumbnail() ? get_the_post_thumbnail( get_the_ID(), 'rawlaw-card', array( 'loading' => 'lazy', 'decoding' => 'async' ) ) : '',
			'reading_time' => $reading_time,
			'practice'     => ! empty( $practice_areas ) && ! is_wp_error( $practice_areas ) ? $practice_areas[0] : null,
			'is_new'       => $is_new,
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
							<?php if ( $p['is_new'] ) : ?><span class="np-badge np-badge--new"><?php esc_html_e( 'New', 'rawlaw' ); ?></span><?php endif; ?>
						</a>
					<?php endif; ?>
					<?php if ( $p['cat'] ) : ?>
						<a class="np-cat" href="<?php echo esc_url( get_term_link( $p['cat'] ) ); ?>"><?php echo esc_html( $p['cat']->name ); ?></a>
					<?php endif; ?>
					<h3 class="np-feature__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
					<div class="np-meta">
						<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
						<?php if ( $p['reading_time'] ) : ?><span class="np-read"><?php echo esc_html( $p['reading_time'] ); ?></span><?php endif; ?>
					</div>
					<?php if ( $p['practice'] ) : ?>
						<a class="np-crosslink" href="<?php echo esc_url( home_url( '/lawyers/?practice_area=' . $p['practice']->slug ) ); ?>">
							<?php printf( esc_html__( 'Find %s lawyers', 'rawlaw' ), esc_html( $p['practice']->name ) ); ?> <span aria-hidden="true">→</span>
						</a>
					<?php endif; ?>
				</article>
				<?php endfor; ?>
			</div>

			<div class="np-stack">
				<?php for ( $i = 2; $i <= 4; $i++ ) : if ( empty( $all_posts[ $i ] ) ) continue; $p = $all_posts[ $i ]; ?>
				<article class="np-stack__item">
					<?php if ( $p['thumb'] ) : ?>
						<a class="np-stack__media" href="<?php echo esc_url( $p['permalink'] ); ?>" aria-hidden="true" tabindex="-1">
							<?php echo $p['thumb']; ?>
							<?php if ( $p['is_new'] ) : ?><span class="np-badge np-badge--new np-badge--sm"><?php esc_html_e( 'New', 'rawlaw' ); ?></span><?php endif; ?>
						</a>
					<?php endif; ?>
					<div class="np-stack__body">
						<?php if ( $p['cat'] ) : ?>
							<a class="np-cat" href="<?php echo esc_url( get_term_link( $p['cat'] ) ); ?>"><?php echo esc_html( $p['cat']->name ); ?></a>
						<?php endif; ?>
						<h3 class="np-stack__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
						<div class="np-meta">
							<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
							<?php if ( $p['reading_time'] ) : ?><span class="np-read"><?php echo esc_html( $p['reading_time'] ); ?></span><?php endif; ?>
						</div>
					</div>
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
						<?php if ( $p['is_new'] ) : ?><span class="np-badge np-badge--new np-badge--sm"><?php esc_html_e( 'New', 'rawlaw' ); ?></span><?php endif; ?>
					</a>
				<?php endif; ?>
				<?php if ( $p['cat'] ) : ?>
					<a class="np-cat" href="<?php echo esc_url( get_term_link( $p['cat'] ) ); ?>"><?php echo esc_html( $p['cat']->name ); ?></a>
				<?php endif; ?>
				<h3 class="np-col__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
				<div class="np-meta np-meta--sm">
					<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
					<?php if ( $p['reading_time'] ) : ?><span class="np-read"><?php echo esc_html( $p['reading_time'] ); ?></span><?php endif; ?>
				</div>
			</article>
			<?php endfor; ?>
		</div>

		<?php // — Inline newsletter hook (Hooked UX: Investment phase) — ?>
		<div class="np-inline-hook" data-reveal>
			<p class="np-inline-hook__text"><?php esc_html_e( 'Get legal news that matters — delivered to your inbox.', 'rawlaw' ); ?></p>
			<a class="np-inline-hook__btn btn btn--ghost btn--sm" href="#newsletter-heading"><?php esc_html_e( 'Subscribe free', 'rawlaw' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</div>

		<?php // — Zone C: Compact headline cards with thumbnails — ?>
		<div class="np-zone np-zone--bottom" data-reveal-stagger>
			<?php for ( $i = 9; $i <= 11; $i++ ) : if ( empty( $all_posts[ $i ] ) ) continue; $p = $all_posts[ $i ]; ?>
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
				<div class="np-meta np-meta--sm">
					<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
					<?php if ( $p['reading_time'] ) : ?><span class="np-read"><?php echo esc_html( $p['reading_time'] ); ?></span><?php endif; ?>
				</div>
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

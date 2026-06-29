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

$rawlaw_posts_page = (int) get_option( 'page_for_posts' );
$rawlaw_news_url   = esc_url( $rawlaw_posts_page ? get_permalink( $rawlaw_posts_page ) : home_url( '/news/' ) );

$rawlaw_home_news_thumb = static function ( $post_id, $size = 'rawlaw-card' ) {
	$thumb_id = get_post_thumbnail_id( $post_id );
	if ( ! $thumb_id ) {
		return '';
	}

	$thumb_file = get_attached_file( $thumb_id );
	if ( $thumb_file && ! file_exists( $thumb_file ) ) {
		return '';
	}

	return get_the_post_thumbnail( $post_id, $size, array(
		'loading'  => 'lazy',
		'decoding' => 'async',
		'alt'      => '',
	) );
};

$news_q = new WP_Query( array(
	'post_type'           => 'post',
	'posts_per_page'      => 9,
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
			'thumb'     => $rawlaw_home_news_thumb( get_the_ID() ),
		);
	}
	wp_reset_postdata();
?>
<section class="section section--news" aria-labelledby="news-heading" data-reveal>
	<div class="container">
		<header class="section__header section__header--newspaper">
			<div>
				<p class="section__eyebrow"><?php esc_html_e( 'Legal news first', 'rawlaw' ); ?></p>
				<h2 id="news-heading" class="section__title section__title--newspaper"><?php esc_html_e( 'News & Judgments', 'rawlaw' ); ?></h2>
				<p class="section__sub section__sub--newspaper"><?php esc_html_e( 'Follow legal developments, court updates and practical explainers, then take the right next step when an issue affects you.', 'rawlaw' ); ?></p>
			</div>
			<a class="link-arrow" href="<?php echo $rawlaw_news_url; ?>"><?php esc_html_e( 'View all', 'rawlaw' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</header>

		<?php // — Screenshot-style mosaic: 2 large stories + spotlight + compact rows — ?>
		<div class="np-mosaic" data-reveal-stagger>
			<?php if ( ! empty( $all_posts[0] ) ) : $p = $all_posts[0]; ?>
			<article class="np-feature np-feature--a">
				<a class="np-feature__media" href="<?php echo esc_url( $p['permalink'] ); ?>" aria-hidden="true" tabindex="-1">
					<?php echo $p['thumb'] ? $p['thumb'] : '<span class="np-media-fallback">' . esc_html__( 'Legal update', 'rawlaw' ) . '</span>'; ?>
				</a>
				<?php if ( $p['cat'] ) : ?>
					<a class="np-cat" href="<?php echo esc_url( get_term_link( $p['cat'] ) ); ?>"><?php echo esc_html( $p['cat']->name ); ?></a>
				<?php endif; ?>
				<h3 class="np-feature__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
				<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
			</article>
			<?php endif; ?>

			<?php if ( ! empty( $all_posts[1] ) ) : $p = $all_posts[1]; ?>
			<article class="np-feature np-feature--b">
				<a class="np-feature__media" href="<?php echo esc_url( $p['permalink'] ); ?>" aria-hidden="true" tabindex="-1">
					<?php echo $p['thumb'] ? $p['thumb'] : '<span class="np-media-fallback">' . esc_html__( 'Legal update', 'rawlaw' ) . '</span>'; ?>
				</a>
				<?php if ( $p['cat'] ) : ?>
					<a class="np-cat" href="<?php echo esc_url( get_term_link( $p['cat'] ) ); ?>"><?php echo esc_html( $p['cat']->name ); ?></a>
				<?php endif; ?>
				<h3 class="np-feature__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
				<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
			</article>
			<?php endif; ?>

			<?php if ( ! empty( $all_posts[2] ) ) : $p = $all_posts[2]; ?>
			<article class="np-spotlight">
				<a class="np-spotlight__media" href="<?php echo esc_url( $p['permalink'] ); ?>" aria-hidden="true" tabindex="-1">
					<?php echo $p['thumb'] ? $p['thumb'] : '<span class="np-media-fallback">' . esc_html__( 'Legal update', 'rawlaw' ) . '</span>'; ?>
				</a>
				<p class="np-spotlight__label"><?php esc_html_e( 'Digest', 'rawlaw' ); ?></p>
				<h3 class="np-spotlight__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h3>
				<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
			</article>
			<?php endif; ?>

			<?php
			$brief_columns = array(
				array( 3, 4 ),
				array( 5, 6 ),
				array( 7, 8 ),
			);
			for ( $col = 0; $col < 3; $col++ ) :
			?>
			<div class="np-brief-col np-brief-col--<?php echo esc_attr( $col + 1 ); ?>">
				<?php foreach ( $brief_columns[ $col ] as $idx ) : if ( empty( $all_posts[ $idx ] ) ) continue; $p = $all_posts[ $idx ]; ?>
				<article class="np-brief">
					<a class="np-brief__media" href="<?php echo esc_url( $p['permalink'] ); ?>" aria-hidden="true" tabindex="-1">
						<?php echo $p['thumb'] ? $p['thumb'] : '<span class="np-media-fallback">' . esc_html__( 'Update', 'rawlaw' ) . '</span>'; ?>
					</a>
					<div class="np-brief__body">
						<h4 class="np-brief__title"><a href="<?php echo esc_url( $p['permalink'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a></h4>
						<time class="np-time" datetime="<?php echo esc_attr( $p['datetime'] ); ?>"><?php echo esc_html( $p['date'] ); ?></time>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
			<?php endfor; ?>
		</div>

		<div class="section__cta section__cta--bridge">
			<a class="btn btn--primary btn--lg" href="<?php echo $rawlaw_news_url; ?>">
				<?php esc_html_e( 'Read More News', 'rawlaw' ); ?>
			</a>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( home_url( '/#rawlaw-hero-query-wizard' ) ); ?>">
				<?php esc_html_e( 'Post a Legal Query', 'rawlaw' ); ?>
			</a>
			<p class="section__cta-note"><?php esc_html_e( 'Not sure whether you need a lawyer? Start with the issue; RawLaw connects it to services, lawyers, and next steps.', 'rawlaw' ); ?></p>
		</div>
	</div>
</section>
<?php endif;

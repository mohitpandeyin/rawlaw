<?php
/**
 * Section — Featured Lawyers (showcase cards with photo, meta, CTA).
 *
 * @package RawLaw
 */

// Try featured + verified lawyers first
$lawyers = new WP_Query( array(
	'post_type'      => 'lawyer',
	'posts_per_page' => 4,
	'meta_query'     => array(
		'relation' => 'AND',
		array( 'key' => '_rawlaw_verified', 'value' => '1' ),
		array( 'key' => '_rawlaw_featured', 'value' => '1' ),
	),
) );

if ( ! $lawyers->have_posts() ) {
	$lawyers = new WP_Query( array(
		'post_type'      => 'lawyer',
		'posts_per_page' => 4,
		'meta_key'       => '_rawlaw_verified',
		'meta_value'     => '1',
	) );
}

if ( ! $lawyers->have_posts() ) {
	$lawyers = new WP_Query( array(
		'post_type'      => 'lawyer',
		'posts_per_page' => 4,
	) );
}

if ( $lawyers->have_posts() ) : ?>
<section class="section section--advocates" aria-labelledby="advocates-heading" data-reveal>
	<div class="container">
		<header class="section__header">
			<div>
				<p class="section__eyebrow"><?php esc_html_e( 'Top Rated', 'rawlaw' ); ?></p>
				<h2 id="advocates-heading" class="section__title"><?php esc_html_e( 'Featured Lawyers', 'rawlaw' ); ?></h2>
			</div>
			<a class="link-arrow" href="<?php echo esc_url( get_post_type_archive_link( 'lawyer' ) ?: home_url( '/find-a-lawyer/' ) ); ?>"><?php esc_html_e( 'View all lawyers', 'rawlaw' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</header>

		<div class="grid grid--showcase" data-reveal-stagger>
			<?php while ( $lawyers->have_posts() ) : $lawyers->the_post();
				$lid        = get_the_ID();
				$is_verified = get_post_meta( $lid, '_rawlaw_verified', true );
				$is_featured = get_post_meta( $lid, '_rawlaw_featured', true );
				$experience  = get_post_meta( $lid, '_rawlaw_experience', true );
				$city_terms  = get_the_terms( $lid, 'lawyer_location' );
				$pa_terms    = get_the_terms( $lid, 'practice_area' );
				$rating_data = rawlaw_lawyer_rating( $lid );
				$city_name   = ( $city_terms && ! is_wp_error( $city_terms ) ) ? $city_terms[0]->name : '';
				$pa_names    = array();
				if ( $pa_terms && ! is_wp_error( $pa_terms ) ) {
					foreach ( array_slice( $pa_terms, 0, 3 ) as $pa ) {
						$pa_names[] = $pa->name;
					}
				}
			?>
			<div class="showcase-card">
				<div class="showcase-card__photo">
					<?php if ( has_post_thumbnail() ) :
						the_post_thumbnail( 'rawlaw-square', array( 'loading' => 'lazy', 'decoding' => 'async' ) );
					endif; ?>
					<?php if ( $is_featured ) : ?>
						<span class="showcase-card__badge"><?php esc_html_e( 'Top Rated', 'rawlaw' ); ?></span>
					<?php endif; ?>
					<?php if ( $is_verified ) : ?>
						<span class="showcase-card__verified"><?php rawlaw_icon( 'verified' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="showcase-card__body">
					<h3 class="showcase-card__name"><?php echo esc_html( 'Adv. ' . get_the_title() ); ?></h3>
					<?php if ( ! empty( $pa_names ) ) : ?>
						<p class="showcase-card__practice"><?php echo esc_html( implode( ' &middot; ', $pa_names ) ); ?></p>
					<?php endif; ?>
					<div class="showcase-card__meta">
						<?php if ( $city_name ) : ?>
							<span class="showcase-card__meta-item"><?php rawlaw_icon( 'pin' ); ?> <?php echo esc_html( $city_name ); ?></span>
						<?php endif; ?>
						<?php if ( $experience ) : ?>
							<span class="showcase-card__meta-item"><?php echo esc_html( $experience ); ?>+ <?php esc_html_e( 'yrs exp.', 'rawlaw' ); ?></span>
						<?php endif; ?>
						<?php if ( $rating_data ) : ?>
							<span class="showcase-card__meta-item showcase-card__rating">&#9733; <?php echo esc_html( $rating_data['avg'] ); ?></span>
						<?php endif; ?>
					</div>
				</div>
				<div class="showcase-card__cta">
					<a class="btn btn--ghost btn--sm" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View Profile', 'rawlaw' ); ?></a>
					<a class="btn btn--primary btn--sm" href="<?php the_permalink(); ?>?action=consult"><?php esc_html_e( 'Message', 'rawlaw' ); ?></a>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php endif; wp_reset_postdata();

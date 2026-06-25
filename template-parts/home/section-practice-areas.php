<?php
/**
 * Section — Practice Areas (topic cluster cards with article counts).
 *
 * Each card shows the practice area, article count, and lawyer count to signal
 * topical depth and supply — key for both UX trust and SEO entity architecture.
 *
 * @package RawLaw
 */

$services = array(
	array( 'icon' => 'lock',     'name' => __( 'Property Disputes', 'rawlaw' ),     'slug' => 'property' ),
	array( 'icon' => 'user',     'name' => __( 'Family Matters', 'rawlaw' ),         'slug' => 'family-law' ),
	array( 'icon' => 'verified', 'name' => __( 'Criminal Law', 'rawlaw' ),           'slug' => 'criminal-law' ),
	array( 'icon' => 'search',   'name' => __( 'Consumer Complaints', 'rawlaw' ),   'slug' => 'consumer' ),
	array( 'icon' => 'pin',      'name' => __( 'Labour Disputes', 'rawlaw' ),        'slug' => 'labour' ),
	array( 'icon' => 'globe',    'name' => __( 'Civil Litigation', 'rawlaw' ),       'slug' => 'civil' ),
	array( 'icon' => 'search',   'name' => __( 'Corporate & GST', 'rawlaw' ),        'slug' => 'corporate' ),
	array( 'icon' => 'clock',    'name' => __( 'Cheque Bounce', 'rawlaw' ),          'slug' => 'cheque-bounce' ),
);
?>
<section class="section section--services" aria-labelledby="services-heading" data-reveal>
	<div class="container">
		<header class="section__header">
			<div>
				<p class="section__eyebrow"><?php esc_html_e( 'Trending legal topics', 'rawlaw' ); ?></p>
				<h2 id="services-heading" class="section__title"><?php esc_html_e( 'Find the issue you need help with', 'rawlaw' ); ?></h2>
				<p class="section__sub"><?php esc_html_e( 'Start from a topic, read plain-language guidance, then compare verified lawyers when you are ready.', 'rawlaw' ); ?></p>
			</div>
			<a class="link-arrow" href="<?php echo esc_url( home_url( '/practice-areas/' ) ); ?>"><?php esc_html_e( 'Browse practice areas', 'rawlaw' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</header>

		<div class="services-grid" data-reveal-stagger>
			<?php foreach ( $services as $svc ) :
				$term        = get_term_by( 'slug', $svc['slug'], 'practice_area' );
				$link        = $term ? get_term_link( $term ) : home_url( '/practice-areas/' . $svc['slug'] . '/' );
				$post_count  = $term ? (int) $term->count : 0;
				$lawyer_q    = new WP_Query( array(
					'post_type'      => 'lawyer',
					'posts_per_page' => 1,
					'no_found_rows'  => false,
					'tax_query'      => $term ? array( array(
						'taxonomy' => 'practice_area',
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					) ) : array(),
				) );
				$lawyer_count = $term ? $lawyer_q->found_posts : 0;
				wp_reset_postdata();
			?>
				<a class="service-card service-card--cluster" href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( $svc['name'] ); ?>">
					<span class="service-card__icon" aria-hidden="true"><?php rawlaw_icon( $svc['icon'] ); ?></span>
					<h3 class="service-card__name"><?php echo esc_html( $svc['name'] ); ?></h3>
					<span class="service-card__action"><?php esc_html_e( 'Read guides and find help', 'rawlaw' ); ?></span>
					<div class="service-card__meta">
						<?php if ( $post_count > 0 ) : ?>
							<span><?php echo esc_html( $post_count ); ?> <?php esc_html_e( 'articles', 'rawlaw' ); ?></span>
						<?php endif; ?>
						<?php if ( $lawyer_count > 0 ) : ?>
							<span><?php echo esc_html( $lawyer_count ); ?>+ <?php esc_html_e( 'lawyers', 'rawlaw' ); ?></span>
						<?php endif; ?>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="section__cta section__cta--quiet">
			<a class="btn btn--ghost btn--lg" href="https://app.rawlaw.in">
				<?php esc_html_e( 'Describe your legal issue', 'rawlaw' ); ?>
			</a>
		</div>
	</div>
</section>

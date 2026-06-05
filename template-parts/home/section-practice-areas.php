<?php
/**
 * Section — Popular Legal Services (icon card grid).
 *
 * Services are now after news section, when users are engaged and ready to explore.
 * This follows conversion funnel logic: Build trust (news) → Show options (services) → Convert (lawyers/CTA)
 *
 * @package RawLaw
 */

$services = array(
	array( 'icon' => 'lock',      'name' => __( 'Property Disputes', 'rawlaw' ),       'slug' => 'property' ),
	array( 'icon' => 'user',      'name' => __( 'Family Matters', 'rawlaw' ),           'slug' => 'family-law' ),
	array( 'icon' => 'verified',  'name' => __( 'Criminal Law', 'rawlaw' ),             'slug' => 'criminal-law' ),
	array( 'icon' => 'shield-checkmark', 'name' => __( 'Consumer Complaints', 'rawlaw' ), 'slug' => 'consumer' ),
	array( 'icon' => 'pin',       'name' => __( 'Labour Disputes', 'rawlaw' ),          'slug' => 'labour' ),
	array( 'icon' => 'globe',     'name' => __( 'Civil Litigation', 'rawlaw' ),         'slug' => 'civil' ),
	array( 'icon' => 'search',    'name' => __( 'Corporate & GST', 'rawlaw' ),          'slug' => 'corporate' ),
	array( 'icon' => 'clock',     'name' => __( 'Cheque Bounce', 'rawlaw' ),            'slug' => 'cheque-bounce' ),
);
?>
<section class="section section--services" aria-labelledby="services-heading" data-reveal>
	<div class="container">
		<header class="section__header">
			<div>
				<p class="section__eyebrow"><?php esc_html_e( 'Explore', 'rawlaw' ); ?></p>
				<h2 id="services-heading" class="section__title"><?php esc_html_e( 'Popular Legal Services', 'rawlaw' ); ?></h2>
				<p class="section__sub"><?php esc_html_e( 'Find expert help for your specific legal needs.', 'rawlaw' ); ?></p>
			</div>
			<a class="link-arrow" href="<?php echo esc_url( home_url( '/practice-areas/' ) ); ?>"><?php esc_html_e( 'All Services', 'rawlaw' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</header>

		<div class="services-grid" data-reveal-stagger>
			<?php foreach ( $services as $svc ) :
				$term = get_term_by( 'slug', $svc['slug'], 'practice_area' );
				$link = $term ? get_term_link( $term ) : home_url( '/practice-areas/' . $svc['slug'] . '/' );
			?>
				<a class="service-card" href="<?php echo esc_url( $link ); ?>" title="<?php echo esc_attr( $svc['name'] ); ?>">
					<span class="service-card__icon" aria-hidden="true"><?php rawlaw_icon( $svc['icon'] ); ?></span>
					<h3 class="service-card__name"><?php echo esc_html( $svc['name'] ); ?></h3>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

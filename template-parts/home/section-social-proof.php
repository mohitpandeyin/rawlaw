<?php
/**
 * Section — Trust proof: decision checkpoints.
 *
 * Placed after the How It Works section to convert intent into trust.
 *
 * @package RawLaw
 */

$stats = array(
	array( 'value' => __( 'Verified', 'rawlaw' ), 'label' => __( 'Profile checks', 'rawlaw' ) ),
	array( 'value' => __( 'Private',  'rawlaw' ), 'label' => __( 'Legal queries', 'rawlaw' ) ),
	array( 'value' => __( 'Compare',  'rawlaw' ), 'label' => __( 'Before consulting', 'rawlaw' ) ),
	array( 'value' => __( 'Focused',  'rawlaw' ), 'label' => __( 'India legal guidance', 'rawlaw' ) ),
);

$trust_points = array(
	array(
		'title' => __( 'Verification before visibility', 'rawlaw' ),
		'desc'  => __( 'See verification status, practice areas, city and experience before contacting a lawyer.', 'rawlaw' ),
	),
	array(
		'title' => __( 'Choice without pressure', 'rawlaw' ),
		'desc'  => __( 'Read guidance, compare lawyers, or post a query without being pushed into payment too early.', 'rawlaw' ),
	),
	array(
		'title' => __( 'Private by default', 'rawlaw' ),
		'desc'  => __( 'Keep sensitive legal details inside the workspace with moderation and audit trails for important actions.', 'rawlaw' ),
	),
);
?>
<section class="section section--social-proof" aria-labelledby="sp-heading" data-reveal>
	<div class="container">

		<ul class="sp-stats" aria-label="<?php esc_attr_e( 'Platform trust signals', 'rawlaw' ); ?>">
			<?php foreach ( $stats as $stat ) : ?>
			<li class="sp-stat">
				<strong class="sp-stat__value"><?php echo esc_html( $stat['value'] ); ?></strong>
				<span class="sp-stat__label"><?php echo esc_html( $stat['label'] ); ?></span>
			</li>
			<?php endforeach; ?>
		</ul>

		<header class="section__header section__header--centered sp-header">
			<p class="section__eyebrow"><?php esc_html_e( 'Trust by design', 'rawlaw' ); ?></p>
			<h2 id="sp-heading" class="section__title"><?php esc_html_e( 'Why people can trust RawLaw.', 'rawlaw' ); ?></h2>
			<p class="section__sub"><?php esc_html_e( 'Legal help is high trust. RawLaw makes verification, privacy and comparison visible before anyone pays or shares sensitive details.', 'rawlaw' ); ?></p>
		</header>

		<div class="sp-testimonials" data-reveal-stagger>
			<?php foreach ( $trust_points as $point ) : ?>
			<blockquote class="sp-testimonial">
				<span class="sp-testimonial__mark" aria-hidden="true"><?php rawlaw_icon( 'shield-checkmark' ); ?></span>
				<h3 class="sp-testimonial__name"><?php echo esc_html( $point['title'] ); ?></h3>
				<p class="sp-testimonial__quote"><?php echo esc_html( $point['desc'] ); ?></p>
				<footer>
					<cite>
						<span class="sp-testimonial__detail"><?php esc_html_e( 'Designed for legal-service trust', 'rawlaw' ); ?></span>
					</cite>
				</footer>
			</blockquote>
			<?php endforeach; ?>
		</div>

	</div>
</section>

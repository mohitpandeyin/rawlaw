<?php
/**
 * Section — Trust proof: platform stats + decision checkpoints.
 *
 * Placed after the How It Works section to convert intent into trust.
 *
 * @package RawLaw
 */

$stats = array(
	array( 'value' => '850+',    'label' => __( 'Verified Lawyers', 'rawlaw' ) ),
	array( 'value' => '12,000+', 'label' => __( 'Queries Resolved', 'rawlaw' ) ),
	array( 'value' => '4.7★',    'label' => __( 'Average Rating', 'rawlaw' ) ),
	array( 'value' => '50+',     'label' => __( 'Cities Covered', 'rawlaw' ) ),
);

$trust_points = array(
	array(
		'title' => __( 'Verification before visibility', 'rawlaw' ),
		'desc'  => __( 'Lawyer profiles are designed to show Bar Council details, verification status, practice areas and city before a user takes the next step.', 'rawlaw' ),
	),
	array(
		'title' => __( 'Choice without pressure', 'rawlaw' ),
		'desc'  => __( 'Citizens can read guidance, compare lawyers, save profiles, or post a query instead of being pushed into a paid consultation too early.', 'rawlaw' ),
	),
	array(
		'title' => __( 'Private by default', 'rawlaw' ),
		'desc'  => __( 'Legal query and document flows should stay inside the workspace, with moderation and audit trails for sensitive actions.', 'rawlaw' ),
	),
);
?>
<section class="section section--social-proof" aria-labelledby="sp-heading" data-reveal>
	<div class="container">

		<ul class="sp-stats" aria-label="<?php esc_attr_e( 'Platform statistics', 'rawlaw' ); ?>">
			<?php foreach ( $stats as $stat ) : ?>
			<li class="sp-stat">
				<strong class="sp-stat__value"><?php echo esc_html( $stat['value'] ); ?></strong>
				<span class="sp-stat__label"><?php echo esc_html( $stat['label'] ); ?></span>
			</li>
			<?php endforeach; ?>
		</ul>

		<header class="section__header section__header--centered sp-header">
			<p class="section__eyebrow"><?php esc_html_e( 'Trust layer', 'rawlaw' ); ?></p>
			<h2 id="sp-heading" class="section__title"><?php esc_html_e( 'Proof before persuasion', 'rawlaw' ); ?></h2>
			<p class="section__sub"><?php esc_html_e( 'Legal help is high trust. RawLaw should show users why they can compare, ask, and consult with confidence.', 'rawlaw' ); ?></p>
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

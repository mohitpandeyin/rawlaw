<?php
/**
 * Section — Social Proof: platform stats + client testimonials.
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

$testimonials = array(
	array(
		'quote'  => __( 'I posted my query about a property dispute at night and had three bids by morning. The lawyer I chose was excellent and resolved the issue in two hearings.', 'rawlaw' ),
		'name'   => __( 'Rajesh M.', 'rawlaw' ),
		'detail' => __( 'Property Dispute, Pune', 'rawlaw' ),
	),
	array(
		'quote'  => __( 'As someone unfamiliar with legal processes, RawLaw made everything simple. The verified badge on lawyers gave me confidence I was in safe hands.', 'rawlaw' ),
		'name'   => __( 'Priya S.', 'rawlaw' ),
		'detail' => __( 'Consumer Complaint, Delhi', 'rawlaw' ),
	),
	array(
		'quote'  => __( 'The transparency of seeing multiple bids and lawyer profiles before deciding is something I have never experienced anywhere else. Highly recommended.', 'rawlaw' ),
		'name'   => __( 'Anand K.', 'rawlaw' ),
		'detail' => __( 'Employment Dispute, Bengaluru', 'rawlaw' ),
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
			<p class="section__eyebrow"><?php esc_html_e( 'Testimonials', 'rawlaw' ); ?></p>
			<h2 id="sp-heading" class="section__title"><?php esc_html_e( 'Trusted by Thousands Across India', 'rawlaw' ); ?></h2>
		</header>

		<div class="sp-testimonials" data-reveal-stagger>
			<?php foreach ( $testimonials as $t ) : ?>
			<blockquote class="sp-testimonial">
				<svg class="sp-testimonial__mark" aria-hidden="true" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 8C6.686 8 4 10.686 4 14C4 17.314 6.686 20 10 20V24C10 24 4 22 4 14C4 10.686 2 8 2 8H10ZM22 8C18.686 8 16 10.686 16 14C16 17.314 18.686 20 22 20V24C22 24 16 22 16 14C16 10.686 14 8 14 8H22Z" fill="currentColor"/></svg>
				<p class="sp-testimonial__quote"><?php echo esc_html( $t['quote'] ); ?></p>
				<footer>
					<cite>
						<strong class="sp-testimonial__name"><?php echo esc_html( $t['name'] ); ?></strong>
						<span class="sp-testimonial__detail"><?php echo esc_html( $t['detail'] ); ?></span>
					</cite>
				</footer>
			</blockquote>
			<?php endforeach; ?>
		</div>

	</div>
</section>

<?php
/**
 * Section — Trust proof: decision checkpoints.
 *
 * The `ul.sp-stats` chip row that used to open this section was removed
 * 2026-08-08: all four chips ("Verified", "Private", "Compare",
 * "Focused") already appear verbatim in the hero features marquee
 * (`inc/homepage-settings.php` -> `features`), and three of the four are
 * restated by the trust cards immediately below them in this very
 * section. Moving the row would only relocate that duplication, so it
 * went entirely, and the section now closes on a real action instead.
 *
 * @package RawLaw
 */

// Kept in sync with the For Advocates section rather than hardcoded, so
// the advocate signup URL stays editable in one place (Homepage settings).
$advocate_url = rawlaw_home_get( 'advocates.primary_url', 'https://app.rawlaw.in/register/lawyer' );

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

		<div class="sp-actions">
			<button class="btn btn--primary btn--lg" type="button" data-query-modal-open>
				<?php esc_html_e( 'Get support', 'rawlaw' ); ?>
			</button>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( $advocate_url ); ?>" target="_blank" rel="noopener">
				<?php esc_html_e( 'Join as lawyer', 'rawlaw' ); ?>
			</a>
		</div>

	</div>
</section>

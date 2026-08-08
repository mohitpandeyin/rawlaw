<?php
/**
 * Section — Trending Legal Topics.
 *
 * Each card opens the homepage query modal pre-filled with the matching
 * legal domain, instead of linking to a `/practice-area/<slug>/` term
 * archive. Those archives do not exist — there are zero published
 * `practice_area` terms, so every card here previously 404'd, as did the
 * "Browse practice areas" link that used to sit in this header (removed
 * for the same reason). See docs/AUDIT.md 2026-08-08.
 *
 * `preset` must match an <option> value in the modal's category select
 * (`template-parts/home/hero-query-modal.php`): the JS only applies the
 * value when a matching option exists, so a typo silently no-ops rather
 * than erroring. Values are kept consistent with the hero chips in
 * `inc/homepage-settings.php`.
 *
 * Cards are <button>, matching the hero chips — the query wizard is a
 * JS flow end to end, so there is no meaningful no-JS anchor fallback to
 * preserve here.
 *
 * @package RawLaw
 */

$services = array(
	array(
		'icon'    => 'lock',
		'name'    => __( 'Property Disputes', 'rawlaw' ),
		'slug'    => 'property',
		'preset'  => 'civil-law',
		'details' => __( 'I need help with a property dispute — ownership, possession, tenancy or registration.', 'rawlaw' ),
	),
	array(
		'icon'    => 'user',
		'name'    => __( 'Family Matters', 'rawlaw' ),
		'slug'    => 'family-law',
		'preset'  => 'family-law',
		'details' => __( 'I need advice on divorce, maintenance, custody, or a related family matter.', 'rawlaw' ),
	),
	array(
		'icon'    => 'verified',
		'name'    => __( 'Criminal Law', 'rawlaw' ),
		'slug'    => 'criminal-law',
		'preset'  => 'criminal-law',
		'details' => __( 'I need legal help with a criminal matter — FIR, bail, investigation or trial.', 'rawlaw' ),
	),
	array(
		'icon'    => 'search',
		'name'    => __( 'Consumer Complaints', 'rawlaw' ),
		'slug'    => 'consumer',
		'preset'  => 'other',
		'details' => __( 'I want to file or respond to a consumer complaint.', 'rawlaw' ),
	),
	array(
		'icon'    => 'pin',
		'name'    => __( 'Labour Disputes', 'rawlaw' ),
		'slug'    => 'labour',
		'preset'  => 'labour-law',
		'details' => __( 'I need help with an employment or labour dispute — termination, unpaid dues or workplace issues.', 'rawlaw' ),
	),
	array(
		'icon'    => 'globe',
		'name'    => __( 'Civil Litigation', 'rawlaw' ),
		'slug'    => 'civil',
		'preset'  => 'civil-law',
		'details' => __( 'I need help with a civil suit, legal notice or ongoing litigation.', 'rawlaw' ),
	),
	array(
		'icon'    => 'search',
		'name'    => __( 'Corporate & GST', 'rawlaw' ),
		'slug'    => 'corporate',
		'preset'  => 'corporate-law',
		'details' => __( 'I need help with a corporate, contract, compliance or GST matter.', 'rawlaw' ),
	),
	array(
		'icon'    => 'clock',
		'name'    => __( 'Cheque Bounce', 'rawlaw' ),
		'slug'    => 'cheque-bounce',
		'preset'  => 'criminal-law',
		'details' => __( 'I need help with a cheque bounce notice or Section 138 matter.', 'rawlaw' ),
	),
);
?>
<section class="section section--services" aria-labelledby="services-heading" data-reveal>
	<div class="container">
		<header class="section__header">
			<div>
				<p class="section__eyebrow"><?php esc_html_e( 'Trending legal topics', 'rawlaw' ); ?></p>
				<h2 id="services-heading" class="section__title"><?php esc_html_e( 'Find the issue you need help with', 'rawlaw' ); ?></h2>
				<p class="section__sub"><?php esc_html_e( 'Pick the topic closest to your matter — RawLaw opens the query form with that context already filled in.', 'rawlaw' ); ?></p>
			</div>
		</header>

		<div class="services-grid" data-reveal-stagger>
			<?php foreach ( $services as $svc ) :
				$term       = get_term_by( 'slug', $svc['slug'], 'practice_area' );
				$post_count = $term ? (int) $term->count : 0;
			?>
				<button
					type="button"
					class="service-card service-card--cluster"
					data-query-preset
					data-preset-area="<?php echo esc_attr( $svc['preset'] ); ?>"
					data-preset-title="<?php echo esc_attr( $svc['name'] ); ?>"
					data-preset-details="<?php echo esc_attr( $svc['details'] ); ?>"
				>
					<span class="service-card__icon" aria-hidden="true"><?php rawlaw_icon( $svc['icon'] ); ?></span>
					<span class="service-card__name"><?php echo esc_html( $svc['name'] ); ?></span>
					<span class="service-card__action"><?php esc_html_e( 'Describe your issue', 'rawlaw' ); ?></span>
					<?php if ( $post_count > 0 ) : ?>
						<span class="service-card__meta">
							<span><?php echo esc_html( $post_count ); ?> <?php esc_html_e( 'articles', 'rawlaw' ); ?></span>
						</span>
					<?php endif; ?>
				</button>
			<?php endforeach; ?>
		</div>

		<div class="section__cta section__cta--quiet">
			<button class="btn btn--ghost btn--lg" type="button" data-query-modal-open>
				<?php esc_html_e( 'Describe your legal issue', 'rawlaw' ); ?>
			</button>
		</div>
	</div>
</section>

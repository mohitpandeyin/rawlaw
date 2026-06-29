<?php
/**
 * Section — For Advocates supply acquisition.
 *
 * @package RawLaw
 */

$services_url = esc_url( home_url( '/services-for-advocates/' ) );
?>
<section id="for-advocates" class="section section--for-advocates" aria-labelledby="advocates-growth-heading" data-reveal>
	<div class="container advocate-growth">
		<div class="advocate-growth__content">
			<p class="section__eyebrow"><?php esc_html_e( 'For advocates', 'rawlaw' ); ?></p>
			<h2 id="advocates-growth-heading" class="section__title"><?php esc_html_e( 'Build visibility where legal intent starts.', 'rawlaw' ); ?></h2>
			<p class="advocate-growth__text">
				<?php esc_html_e( 'RawLaw is built around legal news, citizen queries and verified lawyer discovery. Create a profile, show your practice areas, and earn trust before a client reaches out.', 'rawlaw' ); ?>
			</p>
			<div class="advocate-growth__actions">
				<a class="btn btn--primary btn--lg" href="https://app.rawlaw.in/register/lawyer" target="_blank" rel="noopener">
					<?php esc_html_e( 'Join as Advocate', 'rawlaw' ); ?>
				</a>
				<a class="btn btn--ghost btn--lg" href="<?php echo $services_url; ?>">
					<?php esc_html_e( 'View Advocate Services', 'rawlaw' ); ?>
				</a>
			</div>
		</div>

		<ul class="advocate-growth__list" aria-label="<?php esc_attr_e( 'Advocate benefits', 'rawlaw' ); ?>">
			<li>
				<strong><?php esc_html_e( 'Profile visibility', 'rawlaw' ); ?></strong>
				<span><?php esc_html_e( 'Appear in discovery paths shaped by city, court, practice area and legal issue.', 'rawlaw' ); ?></span>
			</li>
			<li>
				<strong><?php esc_html_e( 'Relevant query opportunities', 'rawlaw' ); ?></strong>
				<span><?php esc_html_e( 'Receive legal requirements from people already describing a real issue.', 'rawlaw' ); ?></span>
			</li>
			<li>
				<strong><?php esc_html_e( 'Verification badge', 'rawlaw' ); ?></strong>
				<span><?php esc_html_e( 'Make Bar Council details and profile checks visible before conversation starts.', 'rawlaw' ); ?></span>
			</li>
			<li>
				<strong><?php esc_html_e( 'Content-led authority', 'rawlaw' ); ?></strong>
				<span><?php esc_html_e( 'Use explainers, updates and answers to build trust without cold selling.', 'rawlaw' ); ?></span>
			</li>
		</ul>
	</div>
</section>

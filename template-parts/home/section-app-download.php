<?php
/**
 * Section — App Download (CTA with phone mockup, features, badges, QR).
 *
 * @package RawLaw
 */
?>
<section class="section section--app" aria-labelledby="app-heading" data-reveal>
	<div class="container">
		<div class="app-section">
			<div class="app-section__inner">

				<div class="app-section__phone" aria-hidden="true">
					<span class="app-section__phone-screen">&#x1F4F1;</span>
					<span><?php esc_html_e( 'RawLaw.in', 'rawlaw' ); ?></span>
					<small><?php esc_html_e( 'Legal help, anytime, anywhere.', 'rawlaw' ); ?></small>
				</div>

				<div class="app-section__content">
					<span class="app-section__eyebrow"><?php esc_html_e( 'Mobile App', 'rawlaw' ); ?></span>
					<h2 id="app-heading" class="app-section__title">
						<?php esc_html_e( 'Download the', 'rawlaw' ); ?> <em><?php esc_html_e( 'RawLaw.in', 'rawlaw' ); ?></em> <?php esc_html_e( 'App', 'rawlaw' ); ?>
					</h2>
					<p class="app-section__desc"><?php esc_html_e( 'Legal help in your pocket. Consult, track and manage your cases on the go.', 'rawlaw' ); ?></p>

					<div class="app-section__badges">
						<a class="app-badge" href="https://play.google.com/store/apps/details?id=in.rawlaw.app" target="_blank" rel="noopener">
							<span class="app-badge__icon" aria-hidden="true">&#x25B6;</span>
							<span class="app-badge__text">
								<small><?php esc_html_e( 'GET IT ON', 'rawlaw' ); ?></small>
								<strong><?php esc_html_e( 'Google Play', 'rawlaw' ); ?></strong>
							</span>
						</a>
						<a class="app-badge" href="https://apps.apple.com/in/app/rawlaw/id0000000000" target="_blank" rel="noopener">
							<span class="app-badge__icon" aria-hidden="true">&#xF8FF;</span>
							<span class="app-badge__text">
								<small><?php esc_html_e( 'Download on the', 'rawlaw' ); ?></small>
								<strong><?php esc_html_e( 'App Store', 'rawlaw' ); ?></strong>
							</span>
						</a>
					</div>

					<ul class="app-section__features">
						<li><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Chat with Lawyers', 'rawlaw' ); ?></li>
						<li><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Case & Document Tracking', 'rawlaw' ); ?></li>
						<li><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Secure Consultations', 'rawlaw' ); ?></li>
						<li><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Legal Updates & Alerts', 'rawlaw' ); ?></li>
					</ul>
				</div>

				<div class="app-section__qr">
					<div class="app-section__qr-box" aria-label="<?php esc_attr_e( 'QR Code', 'rawlaw' ); ?>">
						QR
					</div>
					<span class="app-section__qr-text"><?php esc_html_e( 'Scan to Download', 'rawlaw' ); ?></span>
				</div>

			</div>
		</div>
	</div>
</section>

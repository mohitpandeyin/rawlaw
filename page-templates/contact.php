<?php
/**
 * Template Name: Contact Us
 * Template Post Type: page
 *
 * Contact page — two-column layout with validated AJAX form and info cards.
 *
 * @package RawLaw
 */

get_header();

$subjects = array(
	'General Enquiry',
	'Advocate Registration',
	'Billing & Payments',
	'Technical Support',
	'Press & Media',
	'Legal Notice',
	'Other',
);
?>

<div class="contact-page">

	<!-- ── Hero ──────────────────────────────────────────────────────────── -->
	<section class="contact-hero" data-reveal>
		<div class="container">
			<p class="contact-hero__eyebrow"><?php esc_html_e( 'Contact', 'rawlaw' ); ?></p>
			<h1 class="contact-hero__title"><?php esc_html_e( 'Get in Touch', 'rawlaw' ); ?></h1>
			<p class="contact-hero__sub"><?php esc_html_e( 'Have a question, a business enquiry, or need support? We\'d love to hear from you.', 'rawlaw' ); ?></p>
		</div>
	</section>

	<!-- ── Body ──────────────────────────────────────────────────────────── -->
	<section class="contact-body" data-reveal>
		<div class="contact-body__inner container">

			<!-- Form card ──────────────────────────────────────────────── -->
			<div class="contact-form-wrap">
				<div class="contact-card">
					<h2 class="contact-card__heading"><?php esc_html_e( 'Send us a message', 'rawlaw' ); ?></h2>

					<div id="contact-global-error" class="contact-form__global-error" role="alert" hidden></div>

					<form id="rawlaw-contact-form" class="contact-form" novalidate autocomplete="on">

						<!-- Name ─────────────────────────────────────── -->
						<div class="contact-form__field">
							<label class="contact-form__label" for="contact_name">
								<?php esc_html_e( 'Full Name', 'rawlaw' ); ?>
								<span class="contact-form__required" aria-hidden="true">*</span>
							</label>
							<input
								type="text"
								id="contact_name"
								name="contact_name"
								class="contact-form__input"
								placeholder="<?php esc_attr_e( 'e.g. Priya Sharma', 'rawlaw' ); ?>"
								required
								maxlength="60"
								autocomplete="name"
								aria-describedby="err-contact_name"
							>
							<span id="err-contact_name" class="contact-form__error" role="alert" hidden></span>
						</div>

						<!-- Email ────────────────────────────────────── -->
						<div class="contact-form__field">
							<label class="contact-form__label" for="contact_email">
								<?php esc_html_e( 'Email Address', 'rawlaw' ); ?>
								<span class="contact-form__required" aria-hidden="true">*</span>
							</label>
							<input
								type="email"
								id="contact_email"
								name="contact_email"
								class="contact-form__input"
								placeholder="you@example.com"
								required
								autocomplete="email"
								aria-describedby="err-contact_email"
							>
							<span id="err-contact_email" class="contact-form__error" role="alert" hidden></span>
						</div>

						<!-- Phone (optional) ─────────────────────────── -->
						<div class="contact-form__field">
							<label class="contact-form__label" for="contact_phone">
								<?php esc_html_e( 'Phone Number', 'rawlaw' ); ?>
								<span class="contact-form__optional">(<?php esc_html_e( 'optional', 'rawlaw' ); ?>)</span>
							</label>
							<input
								type="tel"
								id="contact_phone"
								name="contact_phone"
								class="contact-form__input"
								placeholder="+91 98765 43210"
								autocomplete="tel"
								aria-describedby="err-contact_phone"
							>
							<span id="err-contact_phone" class="contact-form__error" role="alert" hidden></span>
						</div>

						<!-- Subject (select) ─────────────────────────── -->
						<div class="contact-form__field">
							<label class="contact-form__label" for="contact_subject">
								<?php esc_html_e( 'Subject', 'rawlaw' ); ?>
								<span class="contact-form__required" aria-hidden="true">*</span>
							</label>
							<div class="contact-form__select-wrap">
								<select
									id="contact_subject"
									name="contact_subject"
									class="contact-form__select"
									required
									aria-describedby="err-contact_subject"
								>
									<option value="" disabled selected><?php esc_html_e( 'Select a subject…', 'rawlaw' ); ?></option>
									<?php foreach ( $subjects as $s ) : ?>
										<option value="<?php echo esc_attr( $s ); ?>"><?php echo esc_html( $s ); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<span id="err-contact_subject" class="contact-form__error" role="alert" hidden></span>
						</div>

						<!-- Message ──────────────────────────────────── -->
						<div class="contact-form__field">
							<label class="contact-form__label" for="contact_message">
								<?php esc_html_e( 'Message', 'rawlaw' ); ?>
								<span class="contact-form__required" aria-hidden="true">*</span>
							</label>
							<textarea
								id="contact_message"
								name="contact_message"
								class="contact-form__textarea"
								placeholder="<?php esc_attr_e( 'Describe your query or concern in detail…', 'rawlaw' ); ?>"
								rows="6"
								required
								maxlength="2000"
								aria-describedby="err-contact_message contact-message-count"
							></textarea>
							<div class="contact-form__field-footer">
								<span id="err-contact_message" class="contact-form__error" role="alert" hidden></span>
								<span id="contact-message-count" class="contact-form__char-count" aria-live="polite">0 / 2000</span>
							</div>
						</div>

						<!-- Submit ───────────────────────────────────── -->
						<button type="submit" class="btn btn--primary contact-form__submit">
							<?php esc_html_e( 'Send Message', 'rawlaw' ); ?>
						</button>

					</form>
				</div><!-- /.contact-card -->
			</div><!-- /.contact-form-wrap -->

			<!-- Info sidebar ───────────────────────────────────────────── -->
			<aside class="contact-info" aria-label="<?php esc_attr_e( 'Contact information', 'rawlaw' ); ?>">

				<div class="contact-info-card">
					<div class="contact-info-card__icon" aria-hidden="true">
						<?php rawlaw_icon( 'drafts' ); ?>
					</div>
					<h3 class="contact-info-card__title"><?php esc_html_e( 'Email Us', 'rawlaw' ); ?></h3>
					<p class="contact-info-card__body">
						<?php esc_html_e( 'General:', 'rawlaw' ); ?> <a href="mailto:hello@rawlaw.in">hello@rawlaw.in</a><br>
						<?php esc_html_e( 'Support:', 'rawlaw' ); ?> <a href="mailto:support@rawlaw.in">support@rawlaw.in</a><br>
						<?php esc_html_e( 'Grievance:', 'rawlaw' ); ?> <a href="mailto:grievance@rawlaw.in">grievance@rawlaw.in</a>
					</p>
				</div>

				<div class="contact-info-card">
					<div class="contact-info-card__icon" aria-hidden="true">
						<?php rawlaw_icon( 'clock' ); ?>
					</div>
					<h3 class="contact-info-card__title"><?php esc_html_e( 'Response Time', 'rawlaw' ); ?></h3>
					<p class="contact-info-card__body">
						<?php esc_html_e( 'We respond to all queries within', 'rawlaw' ); ?>
						<strong><?php esc_html_e( '1–2 business days', 'rawlaw' ); ?></strong>.<br>
						<?php esc_html_e( 'Grievances acknowledged within', 'rawlaw' ); ?>
						<strong><?php esc_html_e( '24 hours', 'rawlaw' ); ?></strong>.
					</p>
				</div>

				<div class="contact-info-card">
					<div class="contact-info-card__icon" aria-hidden="true">
						<?php rawlaw_icon( 'pin' ); ?>
					</div>
					<h3 class="contact-info-card__title"><?php esc_html_e( 'Based In', 'rawlaw' ); ?></h3>
					<p class="contact-info-card__body">
						<?php esc_html_e( 'New Delhi, India', 'rawlaw' ); ?>
					</p>
				</div>

			</aside><!-- /.contact-info -->

		</div><!-- /.contact-body__inner -->
	</section>

</div><!-- /.contact-page -->

<?php get_footer(); ?>

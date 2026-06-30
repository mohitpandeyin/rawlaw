<?php
/**
 * Hero query modal — client-side handoff for app.rawlaw.in signup.
 *
 * @package RawLaw
 */

$app_signup_url = esc_url( 'https://app.rawlaw.in/register/client' );

$practice_areas = get_terms( array(
	'taxonomy'   => 'practice_area',
	'hide_empty' => false,
	'number'     => 50,
	'orderby'    => 'name',
) );

$fallback_areas = array(
	'banking-finance'     => __( 'Banking / Finance', 'rawlaw' ),
	'family-law'          => __( 'Family Law', 'rawlaw' ),
	'criminal-law'        => __( 'Criminal Law', 'rawlaw' ),
	'property'            => __( 'Property', 'rawlaw' ),
	'consumer-protection' => __( 'Consumer Protection', 'rawlaw' ),
	'corporate'           => __( 'Business / Contracts', 'rawlaw' ),
);

$popular = array(
	array(
		'label'   => __( 'Bail', 'rawlaw' ),
		'area'    => 'criminal-law',
		'details' => __( 'I need legal help for bail or an urgent criminal matter.', 'rawlaw' ),
	),
	array(
		'label'   => __( 'Divorce', 'rawlaw' ),
		'area'    => 'family-law',
		'details' => __( 'I need advice on divorce, maintenance, custody, or a related family matter.', 'rawlaw' ),
	),
	array(
		'label'   => __( 'RERA', 'rawlaw' ),
		'area'    => 'property',
		'details' => __( 'I need help with a builder delay, RERA complaint, or property dispute.', 'rawlaw' ),
	),
	array(
		'label'   => __( 'Cheque Bounce', 'rawlaw' ),
		'area'    => 'criminal-law',
		'details' => __( 'I need help with a cheque bounce notice or Section 138 matter.', 'rawlaw' ),
	),
	array(
		'label'   => __( 'Consumer Complaint', 'rawlaw' ),
		'area'    => 'consumer-protection',
		'details' => __( 'I want to file or respond to a consumer complaint.', 'rawlaw' ),
	),
);
?>

<div class="hero-wizard-modal" id="rawlaw-query-modal" data-query-modal hidden>
	<div class="hero-wizard-modal__backdrop" data-query-modal-close></div>
	<section class="hero-wizard-modal__panel" role="dialog" aria-modal="true" aria-labelledby="rawlaw-query-modal-title" tabindex="-1">
		<header class="hero-wizard-modal__header">
			<div>
				<p class="hero-wizard-modal__eyebrow"><?php esc_html_e( 'Post a query', 'rawlaw' ); ?></p>
				<h2 id="rawlaw-query-modal-title"><?php esc_html_e( 'Share your legal requirement', 'rawlaw' ); ?></h2>
				<p><?php esc_html_e( 'Share the essentials now. Complete signup next to track updates and upload documents securely.', 'rawlaw' ); ?></p>
			</div>
			<button class="icon-btn hero-wizard-modal__close" type="button" data-query-modal-close aria-label="<?php esc_attr_e( 'Close query form', 'rawlaw' ); ?>">
				<span aria-hidden="true">&times;</span>
			</button>
		</header>

		<form id="rawlaw-hero-query-wizard" class="hero-query-wizard" action="<?php echo $app_signup_url; ?>" method="get" novalidate data-query-wizard>
			<p class="hero-wizard__error" data-wizard-error hidden></p>

			<div class="hero-wizard__presets" aria-label="<?php esc_attr_e( 'Popular legal issues', 'rawlaw' ); ?>">
				<span class="hero__chips-label"><?php esc_html_e( 'Popular:', 'rawlaw' ); ?></span>
				<?php foreach ( $popular as $item ) : ?>
					<button class="hero__chip" type="button" data-query-preset data-preset-area="<?php echo esc_attr( $item['area'] ); ?>" data-preset-details="<?php echo esc_attr( $item['details'] ); ?>">
						<?php echo esc_html( $item['label'] ); ?>
					</button>
				<?php endforeach; ?>
			</div>

			<div class="hero-wizard__section">
				<label class="hero-wizard__textarea hero-wizard__textarea--title">
					<span><?php esc_html_e( 'Query / Case Title *', 'rawlaw' ); ?></span>
					<input type="text" name="title" maxlength="140" required data-wizard-title placeholder="<?php esc_attr_e( 'e.g., Notice received from bank under SARFAESI Act, need counsel', 'rawlaw' ); ?>">
					<small><?php esc_html_e( 'A short title that summarizes your immediate legal hurdle.', 'rawlaw' ); ?></small>
				</label>

				<div class="hero-wizard__modal-grid hero-wizard__modal-grid--two">
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'Legal Domain / Category *', 'rawlaw' ); ?></span>
						<select name="category" required data-wizard-area>
							<option value=""><?php esc_html_e( 'Select legal domain', 'rawlaw' ); ?></option>
							<?php if ( ! empty( $practice_areas ) && ! is_wp_error( $practice_areas ) ) : ?>
								<?php foreach ( $practice_areas as $pa ) : ?>
									<option value="<?php echo esc_attr( $pa->slug ); ?>"><?php echo esc_html( $pa->name ); ?></option>
								<?php endforeach; ?>
							<?php else : ?>
								<?php foreach ( $fallback_areas as $slug => $label ) : ?>
									<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</label>
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'Urgency Level *', 'rawlaw' ); ?></span>
						<select name="urgency" required>
							<option value="normal"><?php esc_html_e( 'Normal (Standard case)', 'rawlaw' ); ?></option>
							<option value="immediate"><?php esc_html_e( 'Immediate (within 24h)', 'rawlaw' ); ?></option>
							<option value="week"><?php esc_html_e( 'This week', 'rawlaw' ); ?></option>
							<option value="planning"><?php esc_html_e( 'Just planning', 'rawlaw' ); ?></option>
						</select>
					</label>
				</div>

				<label class="hero-wizard__textarea">
					<span><?php esc_html_e( 'Detailed Legal Description *', 'rawlaw' ); ?></span>
					<textarea name="description" rows="7" minlength="40" maxlength="1800" required data-wizard-details placeholder="<?php esc_attr_e( 'Describe the facts, timeline of events, active court notices, parties involved, and the specific resolution or advice you are seeking...', 'rawlaw' ); ?>"></textarea>
					<small><?php esc_html_e( 'Do not share sensitive bank credentials. Describe active summons, dates, and terms clearly.', 'rawlaw' ); ?></small>
				</label>
			</div>

			<div class="hero-wizard__section">
				<h3 class="hero-wizard__section-title"><?php esc_html_e( 'Location & Language Preferences', 'rawlaw' ); ?></h3>
				<div class="hero-wizard__modal-grid">
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'State Jurisdiction *', 'rawlaw' ); ?></span>
						<input type="text" name="state" maxlength="80" required placeholder="<?php esc_attr_e( 'e.g., Maharashtra', 'rawlaw' ); ?>">
					</label>
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'City Jurisdiction *', 'rawlaw' ); ?></span>
						<input type="text" name="city" maxlength="80" required placeholder="<?php esc_attr_e( 'e.g., Mumbai', 'rawlaw' ); ?>">
					</label>
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'Consultation Language', 'rawlaw' ); ?></span>
						<select name="language">
							<option value="English"><?php esc_html_e( 'English', 'rawlaw' ); ?></option>
							<option value="Hindi"><?php esc_html_e( 'Hindi', 'rawlaw' ); ?></option>
							<option value="Marathi"><?php esc_html_e( 'Marathi', 'rawlaw' ); ?></option>
							<option value="Tamil"><?php esc_html_e( 'Tamil', 'rawlaw' ); ?></option>
							<option value="Telugu"><?php esc_html_e( 'Telugu', 'rawlaw' ); ?></option>
							<option value="Kannada"><?php esc_html_e( 'Kannada', 'rawlaw' ); ?></option>
							<option value="Bengali"><?php esc_html_e( 'Bengali', 'rawlaw' ); ?></option>
						</select>
					</label>
				</div>
			</div>

			<div class="hero-wizard__section">
				<h3 class="hero-wizard__section-title"><?php esc_html_e( 'Budget Preference', 'rawlaw' ); ?></h3>
				<label class="hero-wizard__compact-field">
					<span><?php esc_html_e( 'Allocated Budget (₹)', 'rawlaw' ); ?></span>
					<input type="text" name="budget" maxlength="40" inputmode="numeric" placeholder="<?php esc_attr_e( 'Leave blank for Negotiable', 'rawlaw' ); ?>">
					<small><?php esc_html_e( 'Giving a ballpark budget helps screen relevant legal proposals.', 'rawlaw' ); ?></small>
				</label>
			</div>

			<div class="hero-wizard__section">
				<h3 class="hero-wizard__section-title"><?php esc_html_e( 'Attach Summons / Case Documents', 'rawlaw' ); ?></h3>
				<div class="hero-wizard__document-note" aria-label="<?php esc_attr_e( 'Document upload note', 'rawlaw' ); ?>">
					<?php rawlaw_icon( 'lock' ); ?>
					<div>
						<strong><?php esc_html_e( 'Upload documents after signup', 'rawlaw' ); ?></strong>
						<p><?php esc_html_e( 'For privacy, summons, notices and case documents are uploaded securely inside your RawLaw dashboard after you complete signup.', 'rawlaw' ); ?></p>
					</div>
				</div>
			</div>

			<div class="hero-wizard__actions">
				<button type="submit" class="hero__finder-btn"><?php esc_html_e( 'Submit Query', 'rawlaw' ); ?></button>
			</div>
		</form>

		<div class="hero-wizard__success" data-query-success hidden>
			<span class="hero-wizard__success-badge" aria-hidden="true"><?php rawlaw_icon( 'verified' ); ?></span>
			<p class="hero-wizard__success-kicker"><?php esc_html_e( 'Query received', 'rawlaw' ); ?></p>
			<h3><?php esc_html_e( 'Your query has been submitted successfully.', 'rawlaw' ); ?></h3>
			<p><?php esc_html_e( 'Please complete signup process to check updates on it.', 'rawlaw' ); ?></p>
			<a class="hero__finder-btn" href="<?php echo $app_signup_url; ?>">
				<?php esc_html_e( 'Complete Signup', 'rawlaw' ); ?>
				<svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
			</a>
		</div>
	</section>
</div>

<?php
/**
 * Hero — minimal legal assistance intake with top news on right.
 *
 * Left column: essential headline, one intake field, one assistance CTA.
 * Right column: Top News section with important legal articles.
 *
 * @package RawLaw
 */

$submit_action   = esc_url( admin_url( 'admin-post.php' ) );
$fallback_action = esc_url( rawlaw_get_post_requirement_url() );
$status          = isset( $_GET['requirement'] ) ? sanitize_key( wp_unslash( $_GET['requirement'] ) ) : '';

$practice_areas = get_terms( array(
	'taxonomy'   => 'practice_area',
	'hide_empty' => false,
	'number'     => 50,
	'orderby'    => 'name',
) );

$fallback_areas = array(
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

<div class="hero__inner">
	<!-- Left: content -->
	<div class="hero__left">
		<header class="hero__lede">
			<h1 class="hero__headline">
				<span class="hero__headline-line"><?php esc_html_e( 'Understand the law.', 'rawlaw' ); ?></span>
				<span class="hero__headline-accent"><?php esc_html_e( 'Find verified legal help.', 'rawlaw' ); ?></span>
			</h1>
			<p class="hero__subtitle">
				<?php esc_html_e( 'Tell us what happened. We will ask for a few details next so relevant verified advocates can respond.', 'rawlaw' ); ?>
			</p>
		</header>

		<?php if ( 'sent' === $status ) : ?>
			<div class="hero-wizard__flash hero-wizard__flash--success" role="status">
				<?php rawlaw_icon( 'verified' ); ?>
				<span><?php esc_html_e( 'Your query has been submitted. We will use the details to connect you with relevant verified advocates.', 'rawlaw' ); ?></span>
			</div>
		<?php elseif ( 'invalid' === $status ) : ?>
			<div class="hero-wizard__flash hero-wizard__flash--error" role="alert">
				<?php rawlaw_icon( 'lock' ); ?>
				<span><?php esc_html_e( 'Please share your name, email or phone, a brief description, and consent before submitting.', 'rawlaw' ); ?></span>
			</div>
		<?php elseif ( 'error' === $status ) : ?>
			<div class="hero-wizard__flash hero-wizard__flash--error" role="alert">
				<?php rawlaw_icon( 'lock' ); ?>
				<span><?php esc_html_e( 'We could not submit your query. Please try again.', 'rawlaw' ); ?></span>
			</div>
		<?php endif; ?>

		<form class="hero__finder hero-intake" action="<?php echo $fallback_action; ?>" method="get" data-query-modal-trigger>
			<div class="hero__finder-row">
				<label class="hero__finder-field">
					<span class="hero__finder-icon" aria-hidden="true"><?php rawlaw_icon( 'chat' ); ?></span>
					<span class="hero__finder-label"><?php esc_html_e( 'Legal issue', 'rawlaw' ); ?></span>
					<input
						class="hero__finder-input"
						type="text"
						name="intent"
						data-hero-query-intent
						placeholder="<?php esc_attr_e( 'e.g. Builder delayed possession, need legal notice...', 'rawlaw' ); ?>"
						autocomplete="off"
					>
				</label>
				<button class="hero__finder-btn" type="submit">
					<?php esc_html_e( 'Get Assistance', 'rawlaw' ); ?>
					<svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
				</button>
			</div>
		</form>

		<div class="hero__quick-actions">
			<div class="hero__chips" aria-label="<?php esc_attr_e( 'Popular legal issues', 'rawlaw' ); ?>">
				<span class="hero__chips-label"><?php esc_html_e( 'Popular:', 'rawlaw' ); ?></span>
				<?php foreach ( $popular as $item ) : ?>
					<button class="hero__chip" type="button" data-query-preset data-preset-area="<?php echo esc_attr( $item['area'] ); ?>" data-preset-details="<?php echo esc_attr( $item['details'] ); ?>">
						<?php echo esc_html( $item['label'] ); ?>
					</button>
				<?php endforeach; ?>
			</div>
			<p class="hero__alt">
				<?php esc_html_e( 'Are you a lawyer?', 'rawlaw' ); ?>
				<a href="https://app.rawlaw.in/register/lawyer" target="_blank" rel="noopener">
					<?php esc_html_e( 'Register as an advocate', 'rawlaw' ); ?>
					<span aria-hidden="true">&rarr;</span>
				</a>
			</p>
		</div>
	</div>

	<!-- Right: Top News -->
	<div class="hero__right">
		<?php get_template_part( 'template-parts/home/hero-top-news' ); ?>
	</div>
</div>

<div class="hero-wizard-modal" id="rawlaw-query-modal" data-query-modal hidden>
	<div class="hero-wizard-modal__backdrop" data-query-modal-close></div>
	<section class="hero-wizard-modal__panel" role="dialog" aria-modal="true" aria-labelledby="rawlaw-query-modal-title" tabindex="-1">
		<header class="hero-wizard-modal__header">
			<div>
				<p class="hero-wizard-modal__eyebrow"><?php esc_html_e( 'Get legal assistance', 'rawlaw' ); ?></p>
				<h2 id="rawlaw-query-modal-title"><?php esc_html_e( 'Share the details of your legal issue', 'rawlaw' ); ?></h2>
				<p><?php esc_html_e( 'This helps RawLaw understand the matter, location and urgency before connecting you with relevant verified advocates.', 'rawlaw' ); ?></p>
			</div>
			<button class="icon-btn hero-wizard-modal__close" type="button" data-query-modal-close aria-label="<?php esc_attr_e( 'Close query form', 'rawlaw' ); ?>">
				<span aria-hidden="true">&times;</span>
			</button>
		</header>

		<form id="rawlaw-hero-query-wizard" class="hero-query-wizard" action="<?php echo $submit_action; ?>" method="post" novalidate data-query-wizard>
			<input type="hidden" name="action" value="rawlaw_post_requirement">
			<input type="hidden" name="source" value="homepage_hero_modal">
			<?php wp_nonce_field( 'rawlaw_post_requirement', 'rawlaw_req_nonce' ); ?>
			<div class="hero-wizard__honeypot" aria-hidden="true">
				<label>Website <input type="text" name="rl_website" tabindex="-1" autocomplete="off"></label>
			</div>

			<p class="hero-wizard__error" data-wizard-error hidden></p>

			<div class="hero-wizard__section">
				<h3 class="hero-wizard__section-title"><?php esc_html_e( 'Matter details', 'rawlaw' ); ?></h3>
				<div class="hero-wizard__modal-grid">
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'Issue type', 'rawlaw' ); ?></span>
						<select name="area" data-wizard-area>
							<option value=""><?php esc_html_e( 'Select issue type', 'rawlaw' ); ?></option>
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
						<span><?php esc_html_e( 'City', 'rawlaw' ); ?></span>
						<input type="text" name="city" maxlength="60" placeholder="<?php esc_attr_e( 'e.g. Delhi', 'rawlaw' ); ?>" autocomplete="address-level2">
					</label>
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'Urgency', 'rawlaw' ); ?></span>
						<select name="urgency">
							<option value=""><?php esc_html_e( 'Select urgency', 'rawlaw' ); ?></option>
							<option value="immediate"><?php esc_html_e( 'Immediate — within 24h', 'rawlaw' ); ?></option>
							<option value="week"><?php esc_html_e( 'This week', 'rawlaw' ); ?></option>
							<option value="month"><?php esc_html_e( 'This month', 'rawlaw' ); ?></option>
							<option value="planning"><?php esc_html_e( 'Just planning', 'rawlaw' ); ?></option>
						</select>
					</label>
				</div>
				<div class="hero__chips" aria-label="<?php esc_attr_e( 'Popular legal searches', 'rawlaw' ); ?>">
					<span class="hero__chips-label"><?php esc_html_e( 'Popular:', 'rawlaw' ); ?></span>
					<?php foreach ( $popular as $item ) : ?>
						<button class="hero__chip" type="button" data-query-preset data-preset-area="<?php echo esc_attr( $item['area'] ); ?>" data-preset-details="<?php echo esc_attr( $item['details'] ); ?>">
							<?php echo esc_html( $item['label'] ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="hero-wizard__section">
				<label class="hero-wizard__textarea">
					<span><?php esc_html_e( 'Describe your legal problem', 'rawlaw' ); ?></span>
					<textarea name="details" rows="4" minlength="20" maxlength="2000" required data-wizard-details placeholder="<?php esc_attr_e( 'Example: My builder delayed possession for two years and I need to send a legal notice.', 'rawlaw' ); ?>"></textarea>
				</label>
			</div>

			<div class="hero-wizard__section">
				<h3 class="hero-wizard__section-title"><?php esc_html_e( 'Contact details', 'rawlaw' ); ?></h3>
				<div class="hero-wizard__contact-grid">
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'Full name', 'rawlaw' ); ?></span>
						<input type="text" name="name" maxlength="80" autocomplete="name" required>
					</label>
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'Email', 'rawlaw' ); ?></span>
						<input type="email" name="email" maxlength="120" autocomplete="email" placeholder="<?php esc_attr_e( 'Email or phone required', 'rawlaw' ); ?>">
					</label>
					<label class="hero-wizard__compact-field">
						<span><?php esc_html_e( 'Phone', 'rawlaw' ); ?></span>
						<input type="tel" name="phone" maxlength="20" autocomplete="tel" placeholder="<?php esc_attr_e( '10-digit mobile', 'rawlaw' ); ?>">
					</label>
				</div>
				<label class="hero-wizard__consent">
					<input type="checkbox" name="consent" value="1" required>
					<span><?php esc_html_e( 'I agree that RawLaw may save this query and share relevant details with verified advocates for response.', 'rawlaw' ); ?></span>
				</label>
				<div class="hero-wizard__actions">
					<button type="submit" class="hero__finder-btn"><?php esc_html_e( 'Submit Query', 'rawlaw' ); ?></button>
				</div>
			</div>
		</form>
	</section>
</div>

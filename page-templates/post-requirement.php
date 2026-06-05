<?php
/**
 * Template Name: Post a Legal Requirement
 * Template Post Type: page
 *
 * Form for citizens to describe their legal matter when a free-text search
 * doesn't confidently match a practice area. Designed to feel like the
 * second step of the homepage hero — calm, plainspoken, no jargon.
 *
 * Design intent (see docs/skills/lean-ux, cro-methodology, microinteractions):
 *   - One form, one job: capture enough to let a verified advocate respond.
 *   - Progressive disclosure: only the minimum required is starred.
 *   - Live status flags via `?requirement=sent|invalid|error` for clear feedback.
 *   - Pre-fills from the hero handoff (`?intent=…&city=…`) so the visitor
 *     never has to retype.
 *   - Honeypot + nonce + private CPT storage — no third-party deps.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$intent_raw = isset( $_GET['intent'] ) ? sanitize_text_field( wp_unslash( $_GET['intent'] ) ) : '';
$city_raw   = isset( $_GET['city'] )   ? sanitize_text_field( wp_unslash( $_GET['city'] ) )   : '';
$status     = isset( $_GET['requirement'] ) ? sanitize_key( $_GET['requirement'] ) : '';

$practice_areas = get_terms( array(
	'taxonomy'   => 'practice_area',
	'hide_empty' => false,
	'number'     => 50,
	'orderby'    => 'name',
) );
?>

<section class="req-hero">
	<div class="container req-hero__inner">
		<p class="req-hero__eyebrow"><?php esc_html_e( 'Post a legal requirement', 'rawlaw' ); ?></p>
		<h1 class="req-hero__title">
			<?php esc_html_e( 'Tell us what you need.', 'rawlaw' ); ?>
			<em><?php esc_html_e( 'Verified advocates will respond.', 'rawlaw' ); ?></em>
		</h1>
		<p class="req-hero__lead">
			<?php esc_html_e( 'Describe your matter in plain English or your preferred language. We’ll share it only with relevant verified advocates. You stay in control — review responses, then choose who to speak with.', 'rawlaw' ); ?>
		</p>

		<ol class="req-steps" aria-label="<?php esc_attr_e( 'How posting works', 'rawlaw' ); ?>">
			<li><span class="req-steps__num">01</span><?php esc_html_e( 'Describe your matter — it takes about 60 seconds.', 'rawlaw' ); ?></li>
			<li><span class="req-steps__num">02</span><?php esc_html_e( 'Verified advocates in your area review and respond.', 'rawlaw' ); ?></li>
			<li><span class="req-steps__num">03</span><?php esc_html_e( 'Compare proposals. Talk to the ones you like. No obligation.', 'rawlaw' ); ?></li>
		</ol>
	</div>
</section>

<section class="req-form-wrap">
	<div class="container req-form-shell">

		<?php if ( 'sent' === $status ) : ?>
			<div class="req-flash req-flash--success" role="status">
				<?php rawlaw_icon( 'verified' ); ?>
				<div>
					<strong><?php esc_html_e( 'Your requirement is in.', 'rawlaw' ); ?></strong>
					<p><?php esc_html_e( 'Relevant verified advocates will be in touch shortly. Meanwhile, browse profiles below to message anyone directly.', 'rawlaw' ); ?></p>
					<a class="link-arrow" href="<?php echo esc_url( get_post_type_archive_link( 'lawyer' ) ?: home_url( '/' ) ); ?>">
						<?php esc_html_e( 'Browse verified lawyers', 'rawlaw' ); ?> <span aria-hidden="true">→</span>
					</a>
				</div>
			</div>
		<?php elseif ( 'invalid' === $status ) : ?>
			<div class="req-flash req-flash--error" role="alert">
				<?php rawlaw_icon( 'lock' ); ?>
				<div>
					<strong><?php esc_html_e( 'Something’s missing.', 'rawlaw' ); ?></strong>
					<p><?php esc_html_e( 'Please share your name, a working email, a description of at least 20 characters, and confirm consent.', 'rawlaw' ); ?></p>
				</div>
			</div>
		<?php elseif ( 'error' === $status ) : ?>
			<div class="req-flash req-flash--error" role="alert">
				<strong><?php esc_html_e( 'We couldn’t save your requirement.', 'rawlaw' ); ?></strong>
				<p><?php esc_html_e( 'Please try again, or contact support if the issue persists.', 'rawlaw' ); ?></p>
			</div>
		<?php endif; ?>

		<form class="req-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
			<input type="hidden" name="action" value="rawlaw_post_requirement">
			<?php wp_nonce_field( 'rawlaw_post_requirement', 'rawlaw_req_nonce' ); ?>

			<!-- Honeypot: bots fill this, humans don't see it -->
			<div class="req-form__honeypot" aria-hidden="true">
				<label>Website <input type="text" name="rl_website" tabindex="-1" autocomplete="off"></label>
			</div>

			<fieldset class="req-form__group">
				<legend class="req-form__legend"><?php esc_html_e( 'Your legal matter', 'rawlaw' ); ?></legend>

				<label class="req-form__field req-form__field--wide">
					<span class="req-form__label"><?php esc_html_e( 'Describe what you need help with', 'rawlaw' ); ?> <em>*</em></span>
					<textarea name="details" rows="6" minlength="20" maxlength="2000" required placeholder="<?php esc_attr_e( 'e.g. “My builder has delayed possession of my flat in Pune by 2 years. I want to issue a legal notice and explore consumer court options.”', 'rawlaw' ); ?>"><?php echo esc_textarea( $intent_raw ); ?></textarea>
					<span class="req-form__hint"><?php esc_html_e( '20–2000 characters. The more specific you are, the better the responses.', 'rawlaw' ); ?></span>
				</label>

				<div class="req-form__row">
					<label class="req-form__field">
						<span class="req-form__label"><?php esc_html_e( 'Practice area', 'rawlaw' ); ?></span>
						<select name="area">
							<option value=""><?php esc_html_e( 'Not sure — help me decide', 'rawlaw' ); ?></option>
							<?php if ( ! empty( $practice_areas ) && ! is_wp_error( $practice_areas ) ) :
								foreach ( $practice_areas as $pa ) : ?>
									<option value="<?php echo esc_attr( $pa->slug ); ?>"><?php echo esc_html( $pa->name ); ?></option>
								<?php endforeach;
							endif; ?>
						</select>
					</label>

					<label class="req-form__field">
						<span class="req-form__label"><?php esc_html_e( 'City', 'rawlaw' ); ?></span>
						<input type="text" name="city" value="<?php echo esc_attr( $city_raw ); ?>" maxlength="60" placeholder="<?php esc_attr_e( 'e.g. Mumbai', 'rawlaw' ); ?>">
					</label>
				</div>

				<div class="req-form__row">
					<label class="req-form__field">
						<span class="req-form__label"><?php esc_html_e( 'How urgent is this?', 'rawlaw' ); ?></span>
						<select name="urgency">
							<option value=""><?php esc_html_e( 'Select', 'rawlaw' ); ?></option>
							<option value="immediate"><?php esc_html_e( 'Immediate — within 24h', 'rawlaw' ); ?></option>
							<option value="week"><?php esc_html_e( 'This week', 'rawlaw' ); ?></option>
							<option value="month"><?php esc_html_e( 'This month', 'rawlaw' ); ?></option>
							<option value="planning"><?php esc_html_e( 'Just planning', 'rawlaw' ); ?></option>
						</select>
					</label>

					<label class="req-form__field">
						<span class="req-form__label"><?php esc_html_e( 'Preferred consultation', 'rawlaw' ); ?></span>
						<select name="mode">
							<option value=""><?php esc_html_e( 'No preference', 'rawlaw' ); ?></option>
							<option value="video"><?php esc_html_e( 'Video call', 'rawlaw' ); ?></option>
							<option value="phone"><?php esc_html_e( 'Phone', 'rawlaw' ); ?></option>
							<option value="in_person"><?php esc_html_e( 'In-person', 'rawlaw' ); ?></option>
							<option value="chat"><?php esc_html_e( 'Chat / email', 'rawlaw' ); ?></option>
						</select>
					</label>

					<label class="req-form__field">
						<span class="req-form__label"><?php esc_html_e( 'Budget (₹)', 'rawlaw' ); ?></span>
						<select name="budget">
							<option value=""><?php esc_html_e( 'Not sure', 'rawlaw' ); ?></option>
							<option value="0-2000"><?php esc_html_e( 'Under ₹2,000', 'rawlaw' ); ?></option>
							<option value="2000-5000">₹2,000 – ₹5,000</option>
							<option value="5000-15000">₹5,000 – ₹15,000</option>
							<option value="15000-50000">₹15,000 – ₹50,000</option>
							<option value="50000+"><?php esc_html_e( '₹50,000+', 'rawlaw' ); ?></option>
						</select>
					</label>
				</div>
			</fieldset>

			<fieldset class="req-form__group">
				<legend class="req-form__legend"><?php esc_html_e( 'How advocates can reach you', 'rawlaw' ); ?></legend>

				<div class="req-form__row">
					<label class="req-form__field">
						<span class="req-form__label"><?php esc_html_e( 'Full name', 'rawlaw' ); ?> <em>*</em></span>
						<input type="text" name="name" required maxlength="80" autocomplete="name">
					</label>

					<label class="req-form__field">
						<span class="req-form__label"><?php esc_html_e( 'Email', 'rawlaw' ); ?> <em>*</em></span>
						<input type="email" name="email" required maxlength="120" autocomplete="email">
					</label>

					<label class="req-form__field">
						<span class="req-form__label"><?php esc_html_e( 'Phone', 'rawlaw' ); ?></span>
						<input type="tel" name="phone" maxlength="20" autocomplete="tel" placeholder="<?php esc_attr_e( 'Optional', 'rawlaw' ); ?>">
					</label>
				</div>

				<label class="req-form__consent">
					<input type="checkbox" name="consent" value="1" required>
					<span><?php
						printf(
							/* translators: 1: terms link, 2: privacy link */
							esc_html__( 'I agree to RawLaw’s %1$s and %2$s. I understand that my requirement may be shared with verified advocates so they can respond.', 'rawlaw' ),
							'<a href="' . esc_url( home_url( '/terms/' ) ) . '">' . esc_html__( 'Terms', 'rawlaw' ) . '</a>',
							'<a href="' . esc_url( home_url( '/privacy/' ) ) . '">' . esc_html__( 'Privacy Policy', 'rawlaw' ) . '</a>'
						); ?>
					</span>
				</label>
			</fieldset>

			<div class="req-form__submit-row">
				<button type="submit" class="btn btn--primary btn--lg">
					<?php esc_html_e( 'Post my requirement', 'rawlaw' ); ?>
					<svg aria-hidden="true" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
				</button>
				<p class="req-form__assurance">
					<?php rawlaw_icon( 'lock' ); ?>
					<?php esc_html_e( 'Confidential. No spam. No obligation.', 'rawlaw' ); ?>
				</p>
			</div>
		</form>

	</div>
</section>

<?php get_footer(); ?>

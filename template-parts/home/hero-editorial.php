<?php
/**
 * Hero — minimal legal assistance intake with top news on right.
 *
 * Left column: essential headline, one intake field, one assistance CTA.
 * Right column: Top News section with important legal articles.
 *
 * @package RawLaw
 */

$fallback_action = esc_url( 'https://app.rawlaw.in/register/client' );

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

<?php
/**
 * Section — Know Your Rights (issue-based cards).
 *
 * Two-column layout: issue cards + onboarding infographic.
 *
 * @package RawLaw
 */

$issues = array(
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>',
		'color' => 'lavender',
		'title' => __( 'I am going through a divorce', 'rawlaw' ),
		'sub'   => __( 'Family law · Maintenance · Custody', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/family-law/' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>',
		'color' => 'peach',
		'title' => __( 'I need bail for someone', 'rawlaw' ),
		'sub'   => __( 'Criminal law · Bail application', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/criminal-law/' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>',
		'color' => 'mint',
		'title' => __( 'My landlord is threatening eviction', 'rawlaw' ),
		'sub'   => __( 'Property · Tenancy rights', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/property/' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>',
		'color' => 'sky',
		'title' => __( 'I received a legal notice', 'rawlaw' ),
		'sub'   => __( 'Civil law · Reply and next steps', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/civil/' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z"/></svg>',
		'color' => 'peach',
		'title' => __( 'I want to file a consumer complaint', 'rawlaw' ),
		'sub'   => __( 'Consumer protection · E-filing', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/consumer/' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>',
		'color' => 'mint',
		'title' => __( 'I need to register property', 'rawlaw' ),
		'sub'   => __( 'Property · Registration process', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/property/' ),
	),
);

$kyr_steps = array(
	array(
		'num'   => '1',
		'title' => __( 'Describe your issue', 'rawlaw' ),
		'desc'  => __( 'In plain language — no legal jargon needed.', 'rawlaw' ),
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/></svg>',
	),
	array(
		'num'   => '2',
		'title' => __( 'Browse matched advocates', 'rawlaw' ),
		'desc'  => __( 'Compare profiles, experience and fees.', 'rawlaw' ),
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 9H18.75M15 12H18.75M15 15H18.75M4.5 19.5H19.5C20.743 19.5 21.75 18.493 21.75 17.25V6.75C21.75 5.507 20.743 4.5 19.5 4.5H4.5C3.257 4.5 2.25 5.507 2.25 6.75V17.25C2.25 18.493 3.257 19.5 4.5 19.5ZM10.5 9.375a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-1.169.324A6.721 6.721 0 0 1 8.625 16.5a6.72 6.72 0 0 1-1.169-.324 3.375 3.375 0 0 1 5.438 0Z"/></svg>',
	),
	array(
		'num'   => '3',
		'title' => __( 'Resolve with clarity', 'rawlaw' ),
		'desc'  => __( 'Consult privately and take the right step.', 'rawlaw' ),
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>',
	),
);
?>
<section class="section section--alt section--know-your-rights" aria-labelledby="kyr-heading" data-reveal>
	<div class="container">
		<header class="kyr-header">
			<p class="section__eyebrow"><?php esc_html_e( 'Know your rights', 'rawlaw' ); ?></p>
			<h2 id="kyr-heading" class="section__title"><?php esc_html_e( 'Not sure where to start?', 'rawlaw' ); ?></h2>
			<p class="section__sub"><?php esc_html_e( 'Tell us what happened, and we will help you understand your rights and find the right advocate.', 'rawlaw' ); ?></p>
		</header>

		<div class="kyr-layout">

			<?php // ── Left column: issue cards ── ?>
			<div class="kyr-left" data-reveal-stagger>
				<div class="grid grid--issues">
					<?php foreach ( $issues as $issue ) : ?>
					<a class="issue-card" href="<?php echo esc_url( $issue['url'] ); ?>">
						<span class="issue-card__icon issue-card__icon--<?php echo esc_attr( $issue['color'] ); ?>">
							<?php echo $issue['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
						<div class="issue-card__text">
							<h3 class="issue-card__title"><?php echo esc_html( $issue['title'] ); ?></h3>
							<p class="issue-card__sub"><?php echo esc_html( $issue['sub'] ); ?></p>
						</div>
					</a>
					<?php endforeach; ?>
				</div>
			</div>

			<?php // ── Right column: onboarding infographic ── ?>
			<aside class="kyr-right" aria-label="<?php esc_attr_e( 'How RawLaw works', 'rawlaw' ); ?>">
				<div class="kyr-infographic">
					<p class="kyr-infographic__label"><?php esc_html_e( 'How RawLaw works', 'rawlaw' ); ?></p>

					<ol class="kyr-steps" role="list">
						<?php foreach ( $kyr_steps as $step ) : ?>
						<li class="kyr-step">
							<div class="kyr-step__num" aria-hidden="true"><?php echo esc_html( $step['num'] ); ?></div>
							<div class="kyr-step__icon" aria-hidden="true">
								<?php echo $step['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<div class="kyr-step__body">
								<strong><?php echo esc_html( $step['title'] ); ?></strong>
								<span><?php echo esc_html( $step['desc'] ); ?></span>
							</div>
						</li>
						<?php endforeach; ?>
					</ol>

					<div class="kyr-infographic__trust">
						<?php rawlaw_icon( 'verified' ); ?>
						<span><?php esc_html_e( 'Trusted by thousands of users across India', 'rawlaw' ); ?></span>
					</div>
				</div>
			</aside>

		</div>
	</div>
</section>

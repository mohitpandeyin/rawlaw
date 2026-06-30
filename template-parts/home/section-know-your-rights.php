<?php
/**
 * Section — Know Your Rights (issue-based rotating guidance).
 *
 * Two-column layout: active issue cards + related visual panel.
 *
 * @package RawLaw
 */

$hero_query_url = home_url( '/#rawlaw-hero-query-wizard' );
$asset_base     = trailingslashit( get_template_directory_uri() ) . 'assets/media/home/';

$issues = array(
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>',
		'color' => 'lavender',
		'title' => __( 'I am going through a divorce', 'rawlaw' ),
		'sub'   => __( 'Family law · Maintenance · Custody', 'rawlaw' ),
		'url'   => $hero_query_url,
		'area'  => 'family-law',
		'details' => __( 'I need advice on divorce, maintenance, custody, or a related family matter.', 'rawlaw' ),
		'image' => $asset_base . 'kyr-family.svg',
		'visual_title' => __( 'Family matter intake', 'rawlaw' ),
		'visual_desc'  => __( 'Turn maintenance, custody, separation or settlement questions into a structured legal request.', 'rawlaw' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>',
		'color' => 'peach',
		'title' => __( 'I need bail for someone', 'rawlaw' ),
		'sub'   => __( 'Criminal law · Bail application', 'rawlaw' ),
		'url'   => $hero_query_url,
		'area'  => 'criminal-law',
		'details' => __( 'I need legal help for bail or an urgent criminal matter.', 'rawlaw' ),
		'image' => $asset_base . 'kyr-bail.svg',
		'visual_title' => __( 'Urgent criminal help', 'rawlaw' ),
		'visual_desc'  => __( 'Capture urgency, court context and city so the matter can be understood quickly.', 'rawlaw' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>',
		'color' => 'mint',
		'title' => __( 'My landlord is threatening eviction', 'rawlaw' ),
		'sub'   => __( 'Property · Tenancy rights', 'rawlaw' ),
		'url'   => $hero_query_url,
		'area'  => 'property',
		'details' => __( 'My landlord is threatening eviction and I need to understand my tenancy rights.', 'rawlaw' ),
		'image' => $asset_base . 'kyr-tenancy.svg',
		'visual_title' => __( 'Tenancy rights clarity', 'rawlaw' ),
		'visual_desc'  => __( 'Explain rent, notice, possession and landlord issues in a format advocates can assess.', 'rawlaw' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>',
		'color' => 'sky',
		'title' => __( 'I received a legal notice', 'rawlaw' ),
		'sub'   => __( 'Civil law · Reply and next steps', 'rawlaw' ),
		'url'   => $hero_query_url,
		'area'  => '',
		'details' => __( 'I received a legal notice and need help understanding the reply and next steps.', 'rawlaw' ),
		'image' => $asset_base . 'kyr-notice.svg',
		'visual_title' => __( 'Notice reply planning', 'rawlaw' ),
		'visual_desc'  => __( 'Summarize deadlines, sender details and response needs before sharing documents after signup.', 'rawlaw' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z"/></svg>',
		'color' => 'peach',
		'title' => __( 'I want to file a consumer complaint', 'rawlaw' ),
		'sub'   => __( 'Consumer protection · E-filing', 'rawlaw' ),
		'url'   => $hero_query_url,
		'area'  => 'consumer-protection',
		'details' => __( 'I want to file a consumer complaint and need guidance on the process.', 'rawlaw' ),
		'image' => $asset_base . 'kyr-consumer.svg',
		'visual_title' => __( 'Consumer dispute support', 'rawlaw' ),
		'visual_desc'  => __( 'Organize purchase details, complaint history and requested remedy for a stronger first brief.', 'rawlaw' ),
	),
	array(
		'svg'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>',
		'color' => 'mint',
		'title' => __( 'I need to register property', 'rawlaw' ),
		'sub'   => __( 'Property · Registration process', 'rawlaw' ),
		'url'   => $hero_query_url,
		'area'  => 'property',
		'details' => __( 'I need help with property registration, documents, or next legal steps.', 'rawlaw' ),
		'image' => $asset_base . 'kyr-property.svg',
		'visual_title' => __( 'Property document review', 'rawlaw' ),
		'visual_desc'  => __( 'Clarify registry, title, stamp duty or document questions before moving to a consultation.', 'rawlaw' ),
	),
);
?>
<section class="section section--alt section--know-your-rights" aria-labelledby="kyr-heading" data-reveal>
	<div class="container">
		<header class="kyr-header">
			<p class="section__eyebrow"><?php esc_html_e( 'Know your rights', 'rawlaw' ); ?></p>
			<h2 id="kyr-heading" class="section__title"><?php esc_html_e( 'Not sure what your legal issue is called?', 'rawlaw' ); ?></h2>
			<p class="section__sub"><?php esc_html_e( 'Choose the situation closest to yours. RawLaw pre-fills the query wizard so you can explain the matter faster.', 'rawlaw' ); ?></p>
		</header>

		<div class="kyr-layout">

			<?php // Left column: rotating issue cards. ?>
			<div class="kyr-left" data-reveal-stagger>
				<div class="grid grid--issues" data-kyr-rotator>
					<?php foreach ( $issues as $index => $issue ) : ?>
					<a
						class="issue-card<?php echo 0 === $index ? ' is-active' : ''; ?>"
						href="<?php echo esc_url( $issue['url'] ); ?>"
						data-query-preset
						data-kyr-item
						data-kyr-index="<?php echo esc_attr( (string) $index ); ?>"
						data-preset-area="<?php echo esc_attr( $issue['area'] ); ?>"
						data-preset-title="<?php echo esc_attr( $issue['title'] ); ?>"
						data-preset-details="<?php echo esc_attr( $issue['details'] ); ?>"
						aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"
					>
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

			<?php // Right column: issue-matched visual panel. ?>
			<aside class="kyr-visual" aria-label="<?php esc_attr_e( 'Issue guidance preview', 'rawlaw' ); ?>" data-kyr-visuals>
				<?php foreach ( $issues as $index => $issue ) : ?>
				<figure class="kyr-visual__item<?php echo 0 === $index ? ' is-active' : ''; ?>" data-kyr-visual="<?php echo esc_attr( (string) $index ); ?>" <?php echo 0 === $index ? '' : 'hidden'; ?>>
					<div class="kyr-visual__media">
						<img src="<?php echo esc_url( $issue['image'] ); ?>" alt="" loading="lazy" decoding="async">
					</div>
					<figcaption class="kyr-visual__body">
						<span class="kyr-visual__eyebrow"><?php esc_html_e( 'Guided issue setup', 'rawlaw' ); ?></span>
						<strong><?php echo esc_html( $issue['visual_title'] ); ?></strong>
						<p><?php echo esc_html( $issue['visual_desc'] ); ?></p>
					</figcaption>
				</figure>
				<?php endforeach; ?>
				<div class="kyr-visual__trust">
					<?php rawlaw_icon( 'verified' ); ?>
					<span><?php esc_html_e( 'Pick the closest issue and RawLaw carries the context into the query form.', 'rawlaw' ); ?></span>
				</div>
			</aside>

		</div>
	</div>
</section>

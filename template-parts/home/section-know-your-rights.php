<?php
/**
 * Section — Know Your Rights (issue-based cards).
 *
 * @package RawLaw
 */

$issues = array(
	array(
		'icon'  => '👨‍👩‍👧',
		'title' => __( 'I am going through a divorce', 'rawlaw' ),
		'sub'   => __( 'Family law - Maintenance - Custody', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/family-law/' ),
	),
	array(
		'icon'  => '🔓',
		'title' => __( 'I need bail for someone', 'rawlaw' ),
		'sub'   => __( 'Criminal law - Bail application', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/criminal-law/' ),
	),
	array(
		'icon'  => '🏠',
		'title' => __( 'My landlord is threatening eviction', 'rawlaw' ),
		'sub'   => __( 'Property &middot; Tenancy rights', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/property/' ),
	),
	array(
		'icon'  => '📄',
		'title' => __( 'I received a legal notice', 'rawlaw' ),
		'sub'   => __( 'Civil law - Reply and next steps', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/civil/' ),
	),
	array(
		'icon'  => '🛡️',
		'title' => __( 'I want to file a consumer complaint', 'rawlaw' ),
		'sub'   => __( 'Consumer protection - E-filing', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/consumer/' ),
	),
	array(
		'icon'  => '🏗️',
		'title' => __( 'I need to register property', 'rawlaw' ),
		'sub'   => __( 'Property - Registration process', 'rawlaw' ),
		'url'   => home_url( '/practice-areas/property/' ),
	),
);
?>
<section class="section section--alt section--know-your-rights" aria-labelledby="kyr-heading" data-reveal>
	<div class="container">
		<header class="section__header section__header--centered">
			<p class="section__eyebrow"><?php esc_html_e( 'Know your rights', 'rawlaw' ); ?></p>
			<h2 id="kyr-heading" class="section__title"><?php esc_html_e( 'Not sure where to start?', 'rawlaw' ); ?></h2>
			<p class="section__sub"><?php esc_html_e( 'Tell us what happened, and we will help you understand your rights and find the right advocate.', 'rawlaw' ); ?></p>
		</header>

		<div class="grid grid--issues" data-reveal-stagger>
			<?php foreach ( $issues as $issue ) : ?>
				<a class="issue-card" href="<?php echo esc_url( $issue['url'] ); ?>">
					<span class="issue-card__icon" aria-hidden="true"><?php echo $issue['icon']; ?></span>
					<div class="issue-card__text">
						<h3 class="issue-card__title"><?php echo esc_html( $issue['title'] ); ?></h3>
						<p class="issue-card__sub"><?php echo esc_html( $issue['sub'] ); ?></p>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

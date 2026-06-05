<?php
/**
 * Section — How RawLaw.in Works (4-step flow).
 *
 * @package RawLaw
 */

$steps = array(
	array( 'icon' => 'drafts',  'num' => '1', 'title' => __( 'Describe Your Issue', 'rawlaw' ), 'desc' => __( 'Tell us your legal problem in a few simple steps.', 'rawlaw' ) ),
	array( 'icon' => 'user',    'num' => '2', 'title' => __( 'Get Matched', 'rawlaw' ),          'desc' => __( 'We connect you with the right lawyer for your case.', 'rawlaw' ) ),
	array( 'icon' => 'chat',    'num' => '3', 'title' => __( 'Consult Securely', 'rawlaw' ),     'desc' => __( 'Discuss your case privately and get expert advice.', 'rawlaw' ) ),
	array( 'icon' => 'shield-checkmark', 'num' => '4', 'title' => __( 'Resolve Confidently', 'rawlaw' ), 'desc' => __( 'Take the next step with clarity and legal support.', 'rawlaw' ) ),
);
?>
<section class="section section--alt section--how-it-works" aria-labelledby="hiw-heading" data-reveal>
	<div class="container">
		<header class="section__header section__header--centered">
			<p class="section__eyebrow"><?php esc_html_e( 'How it works', 'rawlaw' ); ?></p>
			<h2 id="hiw-heading" class="section__title"><?php esc_html_e( 'How', 'rawlaw' ); ?> <span style="color:var(--navy)">RawLaw.in</span> <?php esc_html_e( 'Works', 'rawlaw' ); ?></h2>
		</header>

		<div class="how-it-works" data-reveal-stagger>
			<?php foreach ( $steps as $step ) : ?>
			<div class="how-step">
				<div class="how-step__icon">
					<span class="how-step__num" aria-hidden="true"><?php echo esc_html( $step['num'] ); ?></span>
					<span class="how-step__icon-svg" aria-hidden="true"><?php rawlaw_icon( $step['icon'] ); ?></span>
				</div>
				<div class="how-step__text">
					<h3 class="how-step__title"><?php echo esc_html( $step['title'] ); ?></h3>
					<p class="how-step__desc"><?php echo esc_html( $step['desc'] ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

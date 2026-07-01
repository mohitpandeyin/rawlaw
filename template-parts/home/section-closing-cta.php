<?php
/**
 * Section — Closing CTA (pre-footer).
 *
 * @package RawLaw
 */
$closing = rawlaw_home_get( 'closing', array() );
?>
<section class="section section--closing-cta" aria-labelledby="cta-heading" data-reveal>
	<div class="container closing-cta">
		<h2 id="cta-heading" class="section__title"><?php echo esc_html( $closing['title'] ); ?></h2>
		<p class="closing-cta__text"><?php echo esc_html( $closing['text'] ); ?></p>
		<div class="closing-cta__actions">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( home_url( '/#rawlaw-hero-query-wizard' ) ); ?>"><?php echo esc_html( $closing['primary_cta'] ); ?></a>
			<a class="btn btn--ghost btn--lg" href="<?php echo esc_url( $closing['secondary_url'] ); ?>"><?php echo esc_html( $closing['secondary_cta'] ); ?></a>
		</div>
	</div>
</section>

<?php
/**
 * Section — Closing CTA (pre-footer).
 *
 * @package RawLaw
 */

$lawyers_url = esc_url( get_post_type_archive_link( 'lawyer' ) ?: home_url( '/find-a-lawyer/' ) );
?>
<section class="section section--closing-cta" aria-labelledby="cta-heading" data-reveal>
	<div class="container closing-cta">
		<h2 id="cta-heading" class="section__title"><?php esc_html_e( 'Your rights matter. Do not navigate the law alone.', 'rawlaw' ); ?></h2>
		<p class="closing-cta__text"><?php esc_html_e( 'Start with the issue, understand your options, then connect with verified advocates when you are ready.', 'rawlaw' ); ?></p>
		<div class="closing-cta__actions">
			<a class="btn btn--primary btn--lg" href="https://app.rawlaw.in/register/client"><?php esc_html_e( 'Post Free Query', 'rawlaw' ); ?></a>
			<a class="btn btn--ghost btn--lg" href="<?php echo $lawyers_url; ?>"><?php esc_html_e( 'Browse Verified Lawyers', 'rawlaw' ); ?></a>
		</div>
	</div>
</section>

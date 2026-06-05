<?php
/**
 * Newsletter signup block.
 *
 * @package RawLaw
 */
$action = get_theme_mod( 'rawlaw_newsletter_action' );
?>
<section class="newsletter" aria-labelledby="newsletter-heading" data-reveal>
	<div class="newsletter__inner">
		<div class="newsletter__copy">
			<p class="eyebrow"><?php esc_html_e( 'The RawLaw Brief', 'rawlaw' ); ?></p>
			<h2 id="newsletter-heading" class="newsletter__title"><?php esc_html_e( 'India’s most important legal news, in your inbox.', 'rawlaw' ); ?></h2>
			<p class="newsletter__sub"><?php esc_html_e( 'Curated judgments, policy analysis and editorial commentary. Every weekday morning.', 'rawlaw' ); ?></p>
		</div>
		<form class="newsletter__form" action="<?php echo esc_url( $action ?: '#' ); ?>" method="post" <?php if ( rawlaw_is_amp() && $action ) { echo 'action-xhr="' . esc_url( $action ) . '"'; } ?> target="_top" novalidate>
			<label for="newsletter-email" class="screen-reader-text"><?php esc_html_e( 'Email address', 'rawlaw' ); ?></label>
			<input id="newsletter-email" type="email" name="EMAIL" required placeholder="<?php esc_attr_e( 'Your work email', 'rawlaw' ); ?>" autocomplete="email">
			<button type="submit" class="btn btn--ghost"><?php esc_html_e( 'Subscribe', 'rawlaw' ); ?></button>
		</form>
		<p class="newsletter__note"><?php esc_html_e( 'No spam. Unsubscribe in one click.', 'rawlaw' ); ?></p>
	</div>
</section>

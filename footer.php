<?php
/**
 * The footer.
 *
 * @package RawLaw
 */
?>
</main>

<?php
$footer_posts_page  = (int) get_option( 'page_for_posts' );
$footer_news_url    = esc_url( $footer_posts_page ? get_permalink( $footer_posts_page ) : home_url( '/news/' ) );
$footer_content     = rawlaw_home_get( 'footer', array() );
?>

<footer class="site-footer" role="contentinfo">
	<div class="container">

		<div class="site-footer__top">
			<div class="site-footer__brand">
				<a class="site-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'RawLaw.in — Home', 'rawlaw' ); ?>">
					<img class="site-logo site-logo--mono" src="<?php echo esc_url( RAWLAW_URI . 'assets/media/rawlaw-logo-mono.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="332" height="84">
				</a>
				<p class="site-footer__about"><?php echo esc_html( $footer_content['about'] ); ?></p>

				<ul class="site-footer__trust" aria-label="<?php esc_attr_e( 'Trust signals', 'rawlaw' ); ?>">
					<li class="site-footer__trust-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4.5 12.75l6 6 9-13.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> <?php echo esc_html( $footer_content['trust_1'] ); ?></li>
					<li class="site-footer__trust-item"><?php rawlaw_icon( 'lock' ); ?> <?php echo esc_html( $footer_content['trust_2'] ); ?></li>
				</ul>

				<p class="site-footer__fine-print"><?php echo esc_html( $footer_content['fine_print'] ); ?></p>
			</div>

			<nav class="site-footer__links" aria-label="<?php esc_attr_e( 'Footer navigation', 'rawlaw' ); ?>">
				<div class="site-footer__group">
					<h2 class="site-footer__heading"><?php esc_html_e( 'Explore', 'rawlaw' ); ?></h2>
					<ul>
						<li><a href="<?php echo $footer_news_url; ?>"><?php esc_html_e( 'Legal News', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/#rawlaw-hero-query-wizard' ) ); ?>"><?php esc_html_e( 'Post Query', 'rawlaw' ); ?></a></li>
					</ul>
				</div>

				<div class="site-footer__group">
					<h2 class="site-footer__heading"><?php esc_html_e( 'For Advocates', 'rawlaw' ); ?></h2>
					<ul>
						<li><a href="https://app.rawlaw.in/register/lawyer" target="_blank" rel="noopener"><?php esc_html_e( 'Join as Advocate', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/services-for-advocates/' ) ); ?>"><?php esc_html_e( 'Advocate Services', 'rawlaw' ); ?></a></li>
					</ul>
				</div>

				<div class="site-footer__group">
					<h2 class="site-footer__heading"><?php esc_html_e( 'Company', 'rawlaw' ); ?></h2>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'rawlaw' ); ?></a></li>
					</ul>
				</div>
			</nav>
		</div>

		<div class="site-footer__bottom">
			<p class="site-footer__copy">&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php echo esc_html( $footer_content['copy'] ); ?></p>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

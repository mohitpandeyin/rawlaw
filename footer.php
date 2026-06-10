<?php
/**
 * The footer.
 *
 * @package RawLaw
 */
?>
</main>

<footer class="site-footer" role="contentinfo">
	<div class="container">

		<div class="site-footer__top">
			<div class="site-footer__brand">
				<a class="site-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'RawLaw.in — Home', 'rawlaw' ); ?>">
					<img class="site-logo site-logo--mono" src="<?php echo esc_url( RAWLAW_URI . 'assets/media/rawlaw-logo-mono.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="332" height="84">
				</a>
				<p class="site-footer__about"><?php esc_html_e( 'Understand your legal problem, follow important legal developments and explore the right legal support.', 'rawlaw' ); ?></p>
				<?php get_template_part( 'template-parts/components/socials' ); ?>

				<ul class="site-footer__trust" aria-label="<?php esc_attr_e( 'Trust signals', 'rawlaw' ); ?>">
					<li class="site-footer__trust-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4.5 12.75l6 6 9-13.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> <?php esc_html_e( 'Legal updates and practical insights', 'rawlaw' ); ?></li>
					<li class="site-footer__trust-item"><?php rawlaw_icon( 'lock' ); ?> <?php esc_html_e( 'Share your query privately', 'rawlaw' ); ?></li>
				</ul>

				<p class="site-footer__fine-print"><?php esc_html_e( 'Made with clarity, trust and access.', 'rawlaw' ); ?></p>
			</div>

			<nav class="site-footer__links" aria-label="<?php esc_attr_e( 'Footer navigation', 'rawlaw' ); ?>">
				<div class="site-footer__group">
					<h2 class="site-footer__heading"><?php esc_html_e( 'Navigate', 'rawlaw' ); ?></h2>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>"><?php esc_html_e( 'Legal News', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/find-lawyer/' ) ); ?>"><?php esc_html_e( 'Find Lawyers', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/legal-services/' ) ); ?>"><?php esc_html_e( 'Legal Services', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/resources/' ) ); ?>"><?php esc_html_e( 'Resources', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Us', 'rawlaw' ); ?></a></li>
					</ul>
				</div>

				<div class="site-footer__group">
					<h2 class="site-footer__heading"><?php esc_html_e( 'Legal Resources', 'rawlaw' ); ?></h2>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/bare-acts/' ) ); ?>"><?php esc_html_e( 'Bare Acts', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/judgments/' ) ); ?>"><?php esc_html_e( 'Judgments', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/legal-articles/' ) ); ?>"><?php esc_html_e( 'Legal Articles', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/legal-dictionary/' ) ); ?>"><?php esc_html_e( 'Legal Dictionary', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/forms/' ) ); ?>"><?php esc_html_e( 'Forms & Templates', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/updates/' ) ); ?>"><?php esc_html_e( 'Legal Updates', 'rawlaw' ); ?></a></li>
					</ul>
				</div>

				<div class="site-footer__group">
					<h2 class="site-footer__heading"><?php esc_html_e( 'For Users', 'rawlaw' ); ?></h2>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/ask-a-legal-question/' ) ); ?>"><?php esc_html_e( 'Ask a Legal Question', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/how-it-works/' ) ); ?>"><?php esc_html_e( 'How It Works', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>"><?php esc_html_e( 'Pricing', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/help/' ) ); ?>"><?php esc_html_e( 'Help Center', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms of Use', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'rawlaw' ); ?></a></li>
					</ul>
				</div>

				<div class="site-footer__group">
					<h2 class="site-footer__heading"><?php esc_html_e( 'For Lawyers', 'rawlaw' ); ?></h2>
					<ul>
						<li><a href="<?php echo esc_url( home_url( '/list-your-practice/' ) ); ?>"><?php esc_html_e( 'Join as a Lawyer', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/lawyer-dashboard/' ) ); ?>"><?php esc_html_e( 'Lawyer Dashboard', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/grow-your-practice/' ) ); ?>"><?php esc_html_e( 'Grow Your Practice', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/verified-lawyers/' ) ); ?>"><?php esc_html_e( 'Verified Lawyers', 'rawlaw' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/lawyer-support/' ) ); ?>"><?php esc_html_e( 'Lawyer Support', 'rawlaw' ); ?></a></li>
					</ul>
				</div>
			</nav>
		</div>

		<div class="site-footer__bottom">
			<p class="site-footer__copy">&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Independent legal journalism and discovery platform for India.', 'rawlaw' ); ?></p>
			<nav class="site-footer__nav" aria-label="<?php esc_attr_e( 'Legal footer links', 'rawlaw' ); ?>">
				<ul class="menu menu--footer">
					<li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'rawlaw' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'DPDP Privacy Policy', 'rawlaw' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'rawlaw' ); ?></a></li>
				</ul>
			</nav>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

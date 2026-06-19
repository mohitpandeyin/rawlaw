<?php
/**
 * Template Name: Privacy Policy
 * Template Post Type: page
 *
 * Legal page — clean editorial layout with table of contents sidebar.
 *
 * @package RawLaw
 */

get_header();
$updated = get_post_meta( get_the_ID(), '_rawlaw_last_updated', true ) ?: get_the_modified_date( 'j F Y' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'legal-page' ); ?> aria-labelledby="legal-page-title">

	<!-- Page header -->
	<header class="legal-page__header" data-reveal>
		<div class="container">
			<p class="legal-page__eyebrow"><?php esc_html_e( 'Legal', 'rawlaw' ); ?></p>
			<h1 id="legal-page-title" class="legal-page__title"><?php the_title(); ?></h1>
			<p class="legal-page__meta">
				<?php
				printf(
					/* translators: %s: last updated date */
					esc_html__( 'Last updated: %s', 'rawlaw' ),
					'<time datetime="' . esc_attr( get_the_modified_date( 'Y-m-d' ) ) . '">' . esc_html( $updated ) . '</time>'
				);
				?>
			</p>
		</div>
	</header>

	<!-- Body -->
	<div class="legal-page__body container" data-reveal>
		<aside class="legal-page__toc" aria-label="<?php esc_attr_e( 'Table of contents', 'rawlaw' ); ?>">
			<div class="legal-toc">
				<p class="legal-toc__heading"><?php esc_html_e( 'Contents', 'rawlaw' ); ?></p>
				<nav>
					<ol class="legal-toc__list">
						<li><a href="#pp-intro"><?php esc_html_e( '1. Introduction', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-collect"><?php esc_html_e( '2. Information We Collect', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-use"><?php esc_html_e( '3. How We Use Your Information', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-share"><?php esc_html_e( '4. Sharing of Information', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-cookies"><?php esc_html_e( '5. Cookies & Tracking', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-storage"><?php esc_html_e( '6. Data Storage & Security', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-retention"><?php esc_html_e( '7. Data Retention', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-rights"><?php esc_html_e( '8. Your Rights', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-children"><?php esc_html_e( '9. Children\'s Privacy', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-links"><?php esc_html_e( '10. Third-Party Links', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-changes"><?php esc_html_e( '11. Changes to this Policy', 'rawlaw' ); ?></a></li>
						<li><a href="#pp-contact"><?php esc_html_e( '12. Contact Us', 'rawlaw' ); ?></a></li>
					</ol>
				</nav>
			</div>
		</aside>

		<div class="legal-page__content prose">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
			endif;
			?>
		</div>
	</div>

	<!-- CTA strip -->
	<div class="legal-page__cta" data-reveal>
		<div class="container">
			<p><?php esc_html_e( 'Have concerns about your data? We are here to help.', 'rawlaw' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'rawlaw' ); ?></a>
		</div>
	</div>

</article>

<?php get_footer(); ?>

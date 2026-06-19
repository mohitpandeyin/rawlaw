<?php
/**
 * Template Name: Terms & Conditions
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
			<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rawlaw' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rawlaw' ); ?></a>
				<span aria-hidden="true">/</span>
				<span aria-current="page"><?php the_title(); ?></span>
			</nav>
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
						<li><a href="#terms-acceptance"><?php esc_html_e( '1. Acceptance of Terms', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-services"><?php esc_html_e( '2. Description of Services', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-eligibility"><?php esc_html_e( '3. Eligibility', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-accounts"><?php esc_html_e( '4. User Accounts', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-conduct"><?php esc_html_e( '5. User Conduct', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-lawyers"><?php esc_html_e( '6. Lawyer Listings', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-payments"><?php esc_html_e( '7. Payments & Fees', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-ip"><?php esc_html_e( '8. Intellectual Property', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-disclaimer"><?php esc_html_e( '9. Disclaimer', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-liability"><?php esc_html_e( '10. Limitation of Liability', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-termination"><?php esc_html_e( '11. Termination', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-governing"><?php esc_html_e( '12. Governing Law', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-grievance"><?php esc_html_e( '13. Grievance Officer', 'rawlaw' ); ?></a></li>
						<li><a href="#terms-contact"><?php esc_html_e( '14. Contact Us', 'rawlaw' ); ?></a></li>
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
			<p><?php esc_html_e( 'Questions about our terms? We are here to help.', 'rawlaw' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'rawlaw' ); ?></a>
		</div>
	</div>

</article>

<?php get_footer(); ?>

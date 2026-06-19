<?php
/**
 * Template Name: Refund Policy
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
						<li><a href="#rp-overview"><?php esc_html_e( '1. Overview', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-cancel"><?php esc_html_e( '2. How to Cancel', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-marketplace"><?php esc_html_e( '3. Marketplace Queries', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-subscription"><?php esc_html_e( '4. Subscription Plans', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-litigation"><?php esc_html_e( '5. Litigation Support Services', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-eligibility"><?php esc_html_e( '6. Eligibility for Refund', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-process"><?php esc_html_e( '7. Refund Process', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-timeline"><?php esc_html_e( '8. Refund Timeline', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-non-refundable"><?php esc_html_e( '9. Non-Refundable Items', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-disputes"><?php esc_html_e( '10. Disputes', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-grievance"><?php esc_html_e( '11. Grievance Officer', 'rawlaw' ); ?></a></li>
						<li><a href="#rp-contact"><?php esc_html_e( '12. Contact Us', 'rawlaw' ); ?></a></li>
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
			<p><?php esc_html_e( 'Need help with a refund request? Our support team is ready.', 'rawlaw' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Support', 'rawlaw' ); ?></a>
		</div>
	</div>

</article>

<?php get_footer(); ?>

<?php
/**
 * Homepage — startup landing page for India's legal marketplace.
 *
 * Section order (optimized for legal intent -> trusted action):
 *   S1  Skip-link / header / utility bar (via get_header)
 *   S2  Hero — query wizard + top news + trust strip
 *   S3  Problem Cards — issue-based guidance
 *   S4  How Citizens Use RawLaw — conversion funnel
 *   S5  For Advocates — verified supply acquisition
 *   S6  News & Judgments — editorial authority
 *   S7  FAQ — reassurance before final CTA
 *   S8  Closing CTA — final conversion push
 *   S9  Footer (via get_footer)
 *
 * Rationale: RawLaw is early-stage, so the page should make the citizen
 * action clear first, then recruit advocates without letting news compete
 * with the primary conversion moment.
 *
 * @package RawLaw
 */

get_header();

$displayed_ids = array();

/*--------------------------------------------------------------
 * S2 — Hero: split layout (left: post-query wizard, right: top news)
 *-------------------------------------------------------------*/
?>
<section class="hero hero--finder" data-reveal>
	<div class="hero__decor" aria-hidden="true">
		<span class="hero__decor-orb hero__decor-orb--a"></span>
		<span class="hero__decor-orb hero__decor-orb--b"></span>
		<span class="hero__decor-grid"></span>
	</div>
	<div class="container">
		<?php get_template_part( 'template-parts/home/hero-editorial' ); ?>
	</div>
	<?php get_template_part( 'template-parts/home/section-features' ); ?>
</section>

<?php
/*--------------------------------------------------------------
 * S3 — Problem Cards (issue-based guidance)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-know-your-rights' );

/*--------------------------------------------------------------
 * S4 — How Citizens Use RawLaw (conversion funnel)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-how-it-works' );

/*--------------------------------------------------------------
 * S5 — For Advocates (supply acquisition)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-for-advocates' );

/*--------------------------------------------------------------
 * S6 — Latest Legal News & Insights (editorial trust driver)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-news' );

/*--------------------------------------------------------------
 * S7 — Judgment Digest
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-judgments' );

/*--------------------------------------------------------------
 * S8 — FAQ (SEO rich results + user reassurance pre-CTA)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-faq' );

/*--------------------------------------------------------------
 * S9 — Closing CTA (final conversion push)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-closing-cta' );

get_footer(); ?>

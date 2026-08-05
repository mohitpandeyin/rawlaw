<?php
/**
 * Homepage — startup landing page for India's legal marketplace.
 *
 * Section order (optimized for legal intent -> trusted action):
 *   S1  Skip-link / header / utility bar (via get_header)
 *   S2  Hero — query wizard + top news + trust strip
 *   S3  How Citizens Use RawLaw — conversion funnel
 *   S3b Trust bar, practice areas, featured lawyers — RAWLAW_MARKETPLACE_LIVE only (0.10 / T-7)
 *   S4  Know Your Rights — issue-based guidance
 *   S5  News & Judgments — editorial authority
 *   S5b Social proof / trust-by-design — no data dependency (T-7)
 *   S6  For Advocates — verified supply acquisition
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
	<div class="hero__ticker">
		<?php get_template_part( 'template-parts/home/ticker', null, array( 'count' => 6 ) ); ?>
	</div>
	<div class="container">
		<?php get_template_part( 'template-parts/home/hero-editorial' ); ?>
	</div>
	<?php get_template_part( 'template-parts/home/section-features' ); ?>
</section>
<?php get_template_part( 'template-parts/home/hero-query-modal' ); ?>

<?php
/*--------------------------------------------------------------
 * S3 — How Citizens Use RawLaw (conversion funnel)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-how-it-works' );

/*--------------------------------------------------------------
 * S3b — Trust bar, practice areas, featured lawyers (T-7).
 * These need real marketplace data to not look broken (0 lawyers,
 * 0 practice-area terms today), so they key off the same toggle as
 * the /find-a-lawyer/ gate (0.10) and switch on together automatically.
 *-------------------------------------------------------------*/
if ( rawlaw_marketplace_is_live() ) {
	get_template_part( 'template-parts/home/trust-bar' );
	get_template_part( 'template-parts/home/section-practice-areas' );
	get_template_part( 'template-parts/home/section-advocates' );
}

/*--------------------------------------------------------------
 * S4 — Know Your Rights (issue-based guidance)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-know-your-rights' );

/*--------------------------------------------------------------
 * S5 — Latest Legal News & Insights (editorial trust driver)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-news' );

/*--------------------------------------------------------------
 * S5b — Social proof / trust-by-design (T-7). No data dependency —
 * generic platform trust copy, safe to run regardless of 0.10.
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-social-proof' );

/*--------------------------------------------------------------
 * S6 — For Advocates (supply acquisition)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-for-advocates' );

/*--------------------------------------------------------------
 * S7 — FAQ (SEO rich results + user reassurance pre-CTA)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-faq' );

/*--------------------------------------------------------------
 * S8 — Closing CTA (final conversion push)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-closing-cta' );

get_footer(); ?>

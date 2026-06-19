<?php
/**
 * Homepage — award-winning landing page for India's legal marketplace.
 *
 * Section order (optimized for user intent & engagement):
 *   S1  Skip-link / header / utility bar (via get_header)
 *   S2  Hero — headline + search + trust + features bar
 *   S3  Latest Legal News — editorial content (trust driver, 12-card grid)
 *   S4  Popular Legal Services — action items (users ready to explore)
 *   S5  How RawLaw.in Works — conversion funnel (4-step)
 *   S6  Featured Lawyers — showcase cards with photos
 *   S7  Judgment Digest — curated legal content
 *   S8  Know Your Rights — issue-based guidance
 *   S9  Closing CTA — final conversion push
 *   S10 Footer (via get_footer)
 *
 * Rationale: Editorial content builds trust early, then service discovery, then conversion funnel.
 * This follows user intent: Discover (via news) → Explore (via services) → Commit (via lawyer/CTA)
 *
 * @package RawLaw
 */

get_header();

$displayed_ids = array();

/*--------------------------------------------------------------
 * S2 — Hero: split layout (left: content, right: top news)
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
 * S3 — Popular Legal Services (immediately after hero for quick navigation)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-practice-areas' );

/*--------------------------------------------------------------
 * S4 — Know Your Rights (issue-based guidance)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-know-your-rights' );

/*--------------------------------------------------------------
 * S5 — Latest Legal News & Insights (editorial content)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-news' );

/*--------------------------------------------------------------
 * S6 — How RawLaw.in Works (conversion funnel)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-how-it-works' );

/*--------------------------------------------------------------
 * S7 — Social Proof: stats + testimonials (reinforce trust post-funnel)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-social-proof' );

/*--------------------------------------------------------------
 * S8 — Featured Lawyers
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-advocates' );

/*--------------------------------------------------------------
 * S9 — Judgment Digest
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-judgments' );

/*--------------------------------------------------------------
 * S10 — FAQ (SEO rich results + user reassurance pre-CTA)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-faq' );

/*--------------------------------------------------------------
 * S11 — Closing CTA (final conversion push)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-closing-cta' );

get_footer(); ?>

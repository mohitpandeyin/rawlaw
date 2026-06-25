<?php
/**
 * Homepage — award-winning landing page for India's legal marketplace.
 *
 * Section order (optimized for editorial trust -> legal action):
 *   S1  Skip-link / header / utility bar (via get_header)
 *   S2  Hero — headline + search + trust + features bar
 *   S3  Latest Legal News — editorial content and trust driver
 *   S4  Trending Legal Topics — practice-area/service discovery
 *   S5  Know Your Rights — issue-based guidance
 *   S6  How RawLaw.in Works — conversion funnel
 *   S7  Social Proof — trust reinforcement
 *   S8  Featured Lawyers — verified supply preview
 *   S9  Judgment Digest — additional authority layer
 *   S10 FAQ — reassurance before final CTA
 *   S11 Closing CTA — final conversion push
 *   S12 Footer (via get_footer)
 *
 * Rationale: RawLaw's strongest path is content-led trust. The page should
 * move from news and legal understanding to topic/service discovery, then
 * verified help, consultation, and review loops.
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
 * S3 — Latest Legal News & Insights (editorial trust driver)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-news' );

/*--------------------------------------------------------------
 * S4 — Trending Legal Topics / Popular Legal Services
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-practice-areas' );

/*--------------------------------------------------------------
 * S5 — Know Your Rights (issue-based guidance)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-know-your-rights' );

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

<?php
/**
 * Homepage.
 *
 * Section order (set by product 2026-08-08):
 *   S1  Header / utility bar (via get_header)
 *   S2  Hero — query intake + top-news ticker
 *   S3  How Citizens Use RawLaw — conversion funnel
 *   S4  News & Judgments — editorial authority
 *   S5  Know Your Rights — issue-based guidance
 *   S6  Trust by design — social proof, no data dependency
 *   S7  For Advocates — supply acquisition
 *   S8  Trending Legal Topics — query-intent picker
 *   S9  FAQ — reassurance before the final CTA
 *   S10 Closing CTA
 *   S11 Footer (via get_footer)
 *
 * Rationale: editorial proof (news) now sits directly under the funnel
 * explanation, so the strongest evidence that RawLaw is a real, active
 * publication lands before the softer trust and acquisition blocks. The
 * topic picker moved down to sit beside the FAQ and closing CTA, where a
 * visitor who has read everything and still needs to act can start a
 * query.
 *
 * `template-parts/home/trust-bar.php` was dropped from this page on the
 * same pass: with the lawyer CPT gone it could only render one lonely
 * "N+ Articles Published" stat, which reads as a broken strip rather than
 * a trust signal. The part still exists if it is ever worth reviving with
 * real numbers behind it.
 *
 * @package RawLaw
 */

get_header();

$displayed_ids = array();

/*--------------------------------------------------------------
 * S2 — Hero: query intake + top news ticker
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
 * S4 — Latest Legal News & Insights (editorial trust driver)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-news' );

/*--------------------------------------------------------------
 * S5 — Know Your Rights (issue-based guidance)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-know-your-rights' );

/*--------------------------------------------------------------
 * S6 — Trust by design (social proof)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-social-proof' );

/*--------------------------------------------------------------
 * S7 — For Advocates (supply acquisition)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-for-advocates' );

/*--------------------------------------------------------------
 * S8 — Trending Legal Topics (query-intent picker)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-practice-areas' );

/*--------------------------------------------------------------
 * S9 — FAQ (SEO rich results + user reassurance pre-CTA)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-faq' );

/*--------------------------------------------------------------
 * S10 — Closing CTA (final conversion push)
 *-------------------------------------------------------------*/
get_template_part( 'template-parts/home/section-closing-cta' );

get_footer(); ?>

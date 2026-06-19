<?php
/**
 * Hero — minimal left-aligned search with top news on right.
 *
 * Left column: essential headline, single search input, popular chips, trust signals.
 * Right column: Top News section with important legal articles.
 *
 * @package RawLaw
 */

$action = esc_url( home_url( '/' ) );

$popular = array(
	array( 'label' => __( 'Bail',               'rawlaw' ), 'q' => 'bail' ),
	array( 'label' => __( 'Divorce',            'rawlaw' ), 'q' => 'divorce' ),
	array( 'label' => __( 'RERA',               'rawlaw' ), 'q' => 'rera complaint' ),
	array( 'label' => __( 'Cheque Bounce',      'rawlaw' ), 'q' => 'cheque bounce' ),
	array( 'label' => __( 'Consumer Complaint', 'rawlaw' ), 'q' => 'consumer complaint' ),
);

?>

<div class="hero__inner">
	<!-- Left: content -->
	<div class="hero__left">
		<header class="hero__lede">
			<h1 class="hero__headline">
				<span class="hero__headline-line"><?php esc_html_e( 'India\'s Most Trusted', 'rawlaw' ); ?></span>
				<span class="hero__headline-accent"><?php esc_html_e( 'Legal Platform.', 'rawlaw' ); ?></span>
			</h1>
			<p class="hero__subtitle">
				<?php esc_html_e( 'Get the right legal help or connect with top lawyers. Simple, fast and reliable.', 'rawlaw' ); ?>
			</p>
		</header>

		<div class="hero__ctas">
			<a class="btn btn--primary btn--lg" href="https://app.rawlaw.in/register/client">
				<?php esc_html_e( 'Post Free Query', 'rawlaw' ); ?>
				<svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
			</a>
			<a class="btn btn--ghost btn--lg" href="https://app.rawlaw.in/register/lawyer">
				<?php esc_html_e( 'Register as Lawyer', 'rawlaw' ); ?>
			</a>
		</div>
	</div>

	<!-- Right: Top News -->
	<div class="hero__right">
		<?php get_template_part( 'template-parts/home/hero-top-news' ); ?>
	</div>
</div>

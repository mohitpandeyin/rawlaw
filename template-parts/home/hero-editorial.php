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
				<span class="hero__headline-line"><?php esc_html_e( 'Understand the law.', 'rawlaw' ); ?></span>
				<span class="hero__headline-accent"><?php esc_html_e( 'Find verified legal help.', 'rawlaw' ); ?></span>
			</h1>
			<p class="hero__subtitle">
				<?php esc_html_e( 'Search legal news, guides, services and lawyers. When your issue needs action, post a query and compare verified advocates.', 'rawlaw' ); ?>
			</p>
		</header>

		<form class="hero__finder" action="<?php echo esc_url( $action ); ?>" method="get" role="search">
			<div class="hero__finder-row">
				<label class="hero__finder-field">
					<span class="hero__finder-icon" aria-hidden="true"><?php rawlaw_icon( 'search' ); ?></span>
					<span class="hero__finder-label"><?php esc_html_e( 'Search legal issue', 'rawlaw' ); ?></span>
					<input
						class="hero__finder-input"
						type="search"
						name="s"
						value="<?php echo esc_attr( get_search_query() ); ?>"
						placeholder="<?php esc_attr_e( 'Search divorce, bail, property dispute...', 'rawlaw' ); ?>"
						autocomplete="off"
					>
				</label>
				<button class="hero__finder-btn" type="submit">
					<?php esc_html_e( 'Search RawLaw', 'rawlaw' ); ?>
				<svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
				</button>
			</div>

			<div class="hero__chips" aria-label="<?php esc_attr_e( 'Popular legal searches', 'rawlaw' ); ?>">
				<span class="hero__chips-label"><?php esc_html_e( 'Popular:', 'rawlaw' ); ?></span>
				<?php foreach ( $popular as $item ) : ?>
					<a class="hero__chip" href="<?php echo esc_url( add_query_arg( 's', $item['q'], $action ) ); ?>">
						<?php echo esc_html( $item['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</form>

		<p class="hero__alt">
			<?php esc_html_e( 'Need a lawyer to review your situation?', 'rawlaw' ); ?>
			<a href="https://app.rawlaw.in/register/client"><?php esc_html_e( 'Post a free query', 'rawlaw' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</p>

		<ul class="hero__trust-stats" aria-label="<?php esc_attr_e( 'Platform stats', 'rawlaw' ); ?>">
			<li class="hero__trust-stat">
				<strong>850+</strong>
				<span><?php esc_html_e( 'Verified Lawyers', 'rawlaw' ); ?></span>
			</li>
			<li class="hero__trust-stat" aria-hidden="true"></li>
			<li class="hero__trust-stat">
				<strong>12,000+</strong>
				<span><?php esc_html_e( 'Queries Resolved', 'rawlaw' ); ?></span>
			</li>
			<li class="hero__trust-stat" aria-hidden="true"></li>
			<li class="hero__trust-stat">
				<strong>4.7&#9733;</strong>
				<span><?php esc_html_e( 'Average Rating', 'rawlaw' ); ?></span>
			</li>
		</ul>
	</div>

	<!-- Right: Top News -->
	<div class="hero__right">
		<?php get_template_part( 'template-parts/home/hero-top-news' ); ?>
	</div>
</div>

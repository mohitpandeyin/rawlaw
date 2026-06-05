<?php
/**
 * 404 — return to the editorial floor gracefully.
 *
 * @package RawLaw
 */
get_header(); ?>

<section class="error-404">
	<div class="container container--prose">
		<p class="eyebrow">404</p>
		<h1 class="error-404__title"><?php esc_html_e( 'This page could not be found.', 'rawlaw' ); ?></h1>
		<p class="error-404__sub"><?php esc_html_e( 'The link may be broken, or the article may have been moved. Try searching for what you were looking for.', 'rawlaw' ); ?></p>
		<?php get_search_form(); ?>
		<div class="error-404__cta">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to homepage', 'rawlaw' ); ?></a>
			<a class="btn btn--ghost" href="https://app.rawlaw.in/register/client"><?php esc_html_e( 'Post Free Query', 'rawlaw' ); ?></a>
		</div>
	</div>

	<?php
	$recent = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3 ) );
	if ( $recent->have_posts() ) : ?>
		<div class="container">
			<h2 class="section__title"><?php esc_html_e( 'Latest articles', 'rawlaw' ); ?></h2>
			<div class="grid grid--3">
				<?php while ( $recent->have_posts() ) : $recent->the_post(); get_template_part( 'template-parts/article/card' ); endwhile; ?>
			</div>
		</div>
	<?php endif; wp_reset_postdata(); ?>
</section>

<?php get_footer(); ?>

<?php
/**
 * Search results — combined posts + lawyers.
 *
 * @package RawLaw
 */
get_header(); ?>

<section class="archive archive--search">
	<div class="container">
		<header class="archive__header">
			<p class="eyebrow"><?php esc_html_e( 'Search', 'rawlaw' ); ?></p>
			<h1 class="archive__title">
				<?php /* translators: %s: search query */ printf( esc_html__( 'Results for “%s”', 'rawlaw' ), esc_html( get_search_query() ) ); ?>
			</h1>
			<?php get_search_form(); ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="search-results">
				<?php while ( have_posts() ) : the_post(); ?>
					<article <?php post_class( 'search-result' ); ?>>
						<p class="search-result__type">
							<?php $pt = get_post_type_object( get_post_type() ); echo esc_html( $pt ? $pt->labels->singular_name : '' ); ?>
						</p>
						<h2 class="search-result__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="search-result__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 36 ) ); ?></p>
						<p class="search-result__url"><?php echo esc_url( get_permalink() ); ?></p>
					</article>
				<?php endwhile; ?>
			</div>
			<?php rawlaw_pagination(); ?>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'No results matched your search. Try a different query.', 'rawlaw' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

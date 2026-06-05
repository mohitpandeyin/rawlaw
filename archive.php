<?php
/**
 * Default archive — categories, tags, dates.
 *
 * @package RawLaw
 */
get_header(); ?>

<section class="archive">
	<div class="container">
		<header class="archive__header">
			<?php
			the_archive_title( '<h1 class="archive__title">', '</h1>' );
			the_archive_description( '<p class="archive__desc">', '</p>' );
			?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/article/card' ); endwhile; ?>
			</div>
			<?php rawlaw_pagination(); ?>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'No articles found in this section yet.', 'rawlaw' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

<?php
/**
 * Default index — used as fallback for blog/posts page.
 *
 * @package RawLaw
 */
get_header(); ?>

<section class="archive">
	<div class="container">
		<header class="archive__header">
			<h1 class="archive__title"><?php
				if ( is_home() && ! is_front_page() ) { single_post_title(); }
				else { esc_html_e( 'Latest from RawLaw', 'rawlaw' ); }
			?></h1>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/article/card' ); endwhile; ?>
			</div>
			<?php rawlaw_pagination(); ?>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'Nothing to show here yet.', 'rawlaw' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

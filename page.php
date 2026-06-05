<?php
/**
 * Default page template.
 *
 * @package RawLaw
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'page' ); ?>>
	<header class="page__header">
		<div class="container container--prose">
			<h1 class="page__title"><?php the_title(); ?></h1>
		</div>
	</header>
	<div class="container container--prose">
		<div class="prose"><?php the_content(); ?></div>
		<?php wp_link_pages( array(
			'before' => '<nav class="post-pages" aria-label="' . esc_attr__( 'Page', 'rawlaw' ) . '">' . esc_html__( 'Pages:', 'rawlaw' ),
			'after'  => '</nav>',
		) ); ?>
	</div>
</article>
<?php endwhile; ?>

<?php get_footer(); ?>

<?php
/**
 * Tag archive.
 *
 * @package RawLaw
 */
get_header(); ?>

<section class="archive archive--tag">
	<div class="container">
		<header class="archive__header">
			<p class="eyebrow"><?php esc_html_e( 'Topic', 'rawlaw' ); ?></p>
			<h1 class="archive__title">#<?php single_tag_title(); ?></h1>
			<?php if ( tag_description() ) : ?>
				<div class="archive__desc"><?php echo wp_kses_post( tag_description() ); ?></div>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/article/card' ); endwhile; ?>
			</div>
			<?php rawlaw_pagination(); ?>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'No content tagged yet.', 'rawlaw' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

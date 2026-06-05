<?php
/**
 * Author archive.
 *
 * @package RawLaw
 */
get_header();
$author    = get_queried_object();
$author_id = $author->ID;
?>

<section class="author-archive">
	<div class="container">
		<header class="author-archive__hero">
			<div class="author-archive__avatar"><?php echo get_avatar( $author_id, 160 ); ?></div>
			<div class="author-archive__intro">
				<p class="eyebrow"><?php esc_html_e( 'Contributor', 'rawlaw' ); ?></p>
				<h1 class="author-archive__name"><?php echo esc_html( $author->display_name ); ?></h1>
				<?php $desc = get_the_author_meta( 'description', $author_id ); if ( $desc ) : ?>
					<p class="author-archive__bio"><?php echo esc_html( $desc ); ?></p>
				<?php endif; ?>
				<?php $url = get_the_author_meta( 'user_url', $author_id ); if ( $url ) : ?>
					<a class="link-arrow" href="<?php echo esc_url( $url ); ?>" rel="noopener"><?php esc_html_e( 'Website', 'rawlaw' ); ?> <span aria-hidden="true">→</span></a>
				<?php endif; ?>
			</div>
		</header>

		<h2 class="section__title"><?php printf( esc_html__( 'Articles by %s', 'rawlaw' ), esc_html( $author->display_name ) ); ?></h2>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/article/card' ); endwhile; ?>
			</div>
			<?php rawlaw_pagination(); ?>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

<?php
/**
 * Category archive — featured story + grid + child taxonomy chips.
 *
 * @package RawLaw
 */
get_header();
$cat = get_queried_object();
$children = get_terms( array( 'taxonomy' => 'category', 'parent' => $cat->term_id, 'hide_empty' => true ) );
?>

<section class="archive archive--category">
	<div class="container">
		<header class="archive__header archive__header--category">
			<p class="eyebrow"><?php esc_html_e( 'Section', 'rawlaw' ); ?></p>
			<h1 class="archive__title"><?php single_cat_title(); ?></h1>
			<?php if ( $cat->description ) : ?>
				<p class="archive__desc"><?php echo esc_html( $cat->description ); ?></p>
			<?php endif; ?>
			<?php if ( $children ) : ?>
				<ul class="chip-list">
					<?php foreach ( $children as $child ) : ?>
						<li><a class="chip" href="<?php echo esc_url( get_term_link( $child ) ); ?>"><?php echo esc_html( $child->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="cat-archive">
				<?php
				$first = true;
				while ( have_posts() ) : the_post();
					if ( $first ) {
						get_template_part( 'template-parts/article/card-featured' );
						echo '<div class="cat-archive__rest grid grid--3">';
						$first = false;
					} else {
						get_template_part( 'template-parts/article/card' );
					}
				endwhile;
				if ( ! $first ) echo '</div>';
				?>
			</div>
			<?php rawlaw_pagination(); ?>
		<?php else : ?>
			<p class="empty"><?php esc_html_e( 'No articles in this section yet.', 'rawlaw' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

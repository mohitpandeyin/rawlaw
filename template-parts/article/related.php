<?php
/**
 * Related articles block — by primary category, fallback to tags.
 *
 * @package RawLaw
 */
$post_id = get_the_ID();
$args = array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'post__not_in'        => array( $post_id ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

$cat = rawlaw_primary_category( $post_id );
if ( $cat ) { $args['cat'] = $cat->term_id; }

$related = new WP_Query( $args );
if ( ! $related->have_posts() ) {
	$tags = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );
	if ( $tags ) {
		unset( $args['cat'] );
		$args['tag__in'] = $tags;
		$related = new WP_Query( $args );
	}
}

if ( $related->have_posts() ) : ?>
<section class="related" aria-labelledby="related-heading">
	<div class="container">
		<h2 id="related-heading" class="section__title"><?php esc_html_e( 'Related reading', 'rawlaw' ); ?></h2>
		<div class="grid grid--3">
			<?php while ( $related->have_posts() ) : $related->the_post(); get_template_part( 'template-parts/article/card' ); endwhile; ?>
		</div>
	</div>
</section>
<?php endif; wp_reset_postdata(); ?>

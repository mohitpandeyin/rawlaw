<?php
/**
 * Single judgment.
 *
 * @package RawLaw
 */
get_header(); while ( have_posts() ) : the_post();
	$courts = get_the_terms( get_the_ID(), 'court' );
	$practice = get_the_terms( get_the_ID(), 'practice_area' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'article article--judgment' ); ?>>
	<header class="article__header">
		<div class="container container--prose">
			<p class="eyebrow"><?php esc_html_e( 'Judgment', 'rawlaw' ); ?><?php if ( $courts && ! is_wp_error( $courts ) ) echo ' · ' . esc_html( $courts[0]->name ); ?></p>
			<h1 class="article__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p class="article__dek"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
			<div class="meta">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</div>
		</div>
	</header>
	<div class="container container--prose">
		<div class="prose"><?php the_content(); ?></div>
		<?php if ( $practice && ! is_wp_error( $practice ) ) : ?>
			<ul class="tag-list">
				<?php foreach ( $practice as $t ) : ?>
					<li><a class="tag" href="<?php echo esc_url( get_term_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</article>
<?php endwhile; get_footer(); ?>

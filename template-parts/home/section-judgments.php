<?php
/**
 * Section — Judgment Digest.
 *
 * @package RawLaw
 */

$judgments = new WP_Query( array(
	'post_type'      => 'judgment',
	'posts_per_page' => 6,
) );

if ( $judgments->have_posts() ) : ?>
<section class="section section--judgments" aria-labelledby="jd-heading" data-reveal>
	<div class="container">
		<header class="section__header">
			<div>
				<p class="section__eyebrow"><?php esc_html_e( 'In the courts', 'rawlaw' ); ?></p>
				<h2 id="jd-heading" class="section__title"><?php esc_html_e( 'Judgment Digest', 'rawlaw' ); ?></h2>
			</div>
			<a class="link-arrow" href="<?php echo esc_url( get_post_type_archive_link( 'judgment' ) ?: home_url( '/judgments/' ) ); ?>"><?php esc_html_e( 'Browse all judgments', 'rawlaw' ); ?> <span aria-hidden="true">→</span></a>
		</header>

		<div class="judgment-list">
			<?php while ( $judgments->have_posts() ) : $judgments->the_post();
				$courts = get_the_terms( get_the_ID(), 'court' );
			?>
				<article class="judgment" data-reveal>
					<div class="judgment__meta">
						<?php if ( $courts && ! is_wp_error( $courts ) ) : ?>
							<span class="badge badge--court"><?php echo esc_html( $courts[0]->name ); ?></span>
						<?php endif; ?>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					</div>
					<h3 class="judgment__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="judgment__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></p>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php endif; wp_reset_postdata();

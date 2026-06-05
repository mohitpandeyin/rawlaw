<?php
/**
 * Judgments archive.
 *
 * @package RawLaw
 */
get_header(); ?>

<section class="archive archive--judgments">
	<div class="container">
		<header class="archive__header">
			<p class="eyebrow"><?php esc_html_e( 'Editorial archive', 'rawlaw' ); ?></p>
			<h1 class="archive__title"><?php esc_html_e( 'Judgments', 'rawlaw' ); ?></h1>
			<p class="archive__desc"><?php esc_html_e( 'Important judgments from the Supreme Court of India, High Courts and tribunals — summarised, indexed and searchable.', 'rawlaw' ); ?></p>
		</header>
		<?php if ( have_posts() ) : ?>
			<div class="judgment-list judgment-list--full">
				<?php while ( have_posts() ) : the_post();
					$courts = get_the_terms( get_the_ID(), 'court' ); ?>
					<article class="judgment" data-reveal>
						<div class="judgment__meta">
							<?php if ( $courts && ! is_wp_error( $courts ) ) : ?>
								<span class="badge badge--court"><?php echo esc_html( $courts[0]->name ); ?></span>
							<?php endif; ?>
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						</div>
						<h2 class="judgment__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="judgment__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 36 ) ); ?></p>
					</article>
				<?php endwhile; ?>
			</div>
			<?php rawlaw_pagination(); ?>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

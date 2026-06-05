<?php
/**
 * Lawyer archive — Find a Lawyer marketplace listing.
 *
 * @package RawLaw
 */
get_header();
$total = $GLOBALS['wp_query']->found_posts;

// Smart-search handoff from the homepage hero.
$q_context = isset( $_GET['q'] )    ? sanitize_text_field( wp_unslash( $_GET['q'] ) )    : '';
$practice  = isset( $_GET['practice'] ) ? sanitize_title( wp_unslash( $_GET['practice'] ) ) : '';
$city_ctx  = isset( $_GET['city'] ) ? sanitize_text_field( wp_unslash( $_GET['city'] ) ) : '';
$practice_term = $practice ? get_term_by( 'slug', $practice, 'practice_area' ) : null;
$post_req_url  = function_exists( 'rawlaw_get_post_requirement_url' ) ? rawlaw_get_post_requirement_url() : home_url( '/post-a-requirement/' );
?>

<section class="marketplace marketplace--archive">
	<div class="container">
		<header class="marketplace__hero" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'RawLaw Marketplace', 'rawlaw' ); ?></p>
			<h1 class="marketplace__title"><?php esc_html_e( 'Find a Lawyer', 'rawlaw' ); ?></h1>
			<p class="marketplace__sub">
				<?php esc_html_e( 'Connect with verified advocates across India — by practice area, location and experience. Independent reviews. Transparent pricing.', 'rawlaw' ); ?>
			</p>

			<?php if ( $q_context || $practice_term || $city_ctx ) : ?>
				<div class="marketplace__handoff" role="status">
					<p class="marketplace__handoff-text">
						<?php esc_html_e( 'Showing results for', 'rawlaw' ); ?>
						<?php if ( $practice_term ) : ?>
							<strong><?php echo esc_html( $practice_term->name ); ?></strong><?php if ( $city_ctx ) : ?> · <strong><?php echo esc_html( $city_ctx ); ?></strong><?php endif; ?>
						<?php elseif ( $q_context ) : ?>
							“<strong><?php echo esc_html( $q_context ); ?></strong>”<?php if ( $city_ctx ) : ?> · <strong><?php echo esc_html( $city_ctx ); ?></strong><?php endif; ?>
						<?php elseif ( $city_ctx ) : ?>
							<strong><?php echo esc_html( $city_ctx ); ?></strong>
						<?php endif; ?>
					</p>
					<a class="marketplace__handoff-link" href="<?php echo esc_url( add_query_arg( array( 'intent' => $q_context, 'city' => $city_ctx ), $post_req_url ) ); ?>">
						<?php esc_html_e( 'Can’t find the right fit? Post a requirement', 'rawlaw' ); ?>
						<span aria-hidden="true">→</span>
					</a>
				</div>
			<?php endif; ?>

			<form class="marketplace__search" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'lawyer' ) ); ?>">
				<label for="market-search" class="screen-reader-text"><?php esc_html_e( 'Search lawyers', 'rawlaw' ); ?></label>
				<input id="market-search" name="s" type="search" placeholder="<?php esc_attr_e( 'Search by name, specialty or city', 'rawlaw' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<input type="hidden" name="post_type" value="lawyer">
				<button type="submit" class="btn btn--primary"><?php esc_html_e( 'Search', 'rawlaw' ); ?></button>
			</form>
		</header>

		<div class="marketplace__layout">
			<?php get_template_part( 'template-parts/lawyer/filters' ); ?>

			<div class="marketplace__results">
				<div class="marketplace__results-head">
					<p class="muted"><?php printf( esc_html( _n( '%s lawyer', '%s lawyers', $total, 'rawlaw' ) ), number_format_i18n( $total ) ); ?></p>
					<form id="sort-form" method="get" class="sort">
						<?php foreach ( $_GET as $k => $v ) :
							if ( 'sort' === $k ) continue;
							if ( is_array( $v ) ) {
								foreach ( $v as $vv ) printf( '<input type="hidden" name="%s[]" value="%s">', esc_attr( $k ), esc_attr( $vv ) );
							} else {
								printf( '<input type="hidden" name="%s" value="%s">', esc_attr( $k ), esc_attr( $v ) );
							}
						endforeach; ?>
						<label for="sort-by"><?php esc_html_e( 'Sort by', 'rawlaw' ); ?></label>
						<select id="sort-by" name="sort" <?php echo rawlaw_is_amp() ? 'on="change:sort-form.submit"' : 'onchange="this.form.submit()"'; ?>>
							<option value=""><?php esc_html_e( 'Most recent', 'rawlaw' ); ?></option>
							<option value="experience" <?php selected( ( $_GET['sort'] ?? '' ), 'experience' ); ?>><?php esc_html_e( 'Most experienced', 'rawlaw' ); ?></option>
						</select>
					</form>
				</div>

				<?php if ( have_posts() ) : ?>
					<div class="grid grid--2 grid--lawyers">
						<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/lawyer/card' ); endwhile; ?>
					</div>
					<?php rawlaw_pagination(); ?>
				<?php else : ?>
					<div class="marketplace__empty">
						<p class="empty"><?php esc_html_e( 'No verified advocates match your search yet.', 'rawlaw' ); ?></p>
						<a class="btn btn--primary btn--lg" href="<?php echo esc_url( add_query_arg( array( 'intent' => $q_context, 'city' => $city_ctx ), $post_req_url ) ); ?>">
							<?php esc_html_e( 'Post your requirement instead', 'rawlaw' ); ?>
							<svg aria-hidden="true" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
						</a>
						<p class="muted" style="margin-top:8px;font-size:13px;"><?php esc_html_e( 'Verified advocates will respond within 24 hours.', 'rawlaw' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

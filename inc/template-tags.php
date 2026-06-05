<?php
/**
 * Reusable template helpers.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Estimated reading time.
 */
function rawlaw_reading_time( $post_id = null ) {
	$post = get_post( $post_id );
	if ( ! $post ) { return ''; }
	$word_count = str_word_count( wp_strip_all_tags( $post->post_content ) );
	$minutes    = max( 1, (int) ceil( $word_count / 220 ) );
	/* translators: %d: minutes. */
	return sprintf( _n( '%d min read', '%d min read', $minutes, 'rawlaw' ), $minutes );
}

/**
 * Primary category for a post (Yoast/SEO compatible, falls back to first).
 */
function rawlaw_primary_category( $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	$primary = get_post_meta( $post_id, '_yoast_wpseo_primary_category', true );
	if ( $primary ) {
		$term = get_term( (int) $primary, 'category' );
		if ( $term && ! is_wp_error( $term ) ) { return $term; }
	}
	$cats = get_the_category( $post_id );
	return $cats ? $cats[0] : null;
}

/**
 * Output a category eyebrow link.
 */
function rawlaw_category_eyebrow( $post_id = null ) {
	$term = rawlaw_primary_category( $post_id );
	if ( ! $term ) { return; }
	printf(
		'<a class="eyebrow" href="%s">%s</a>',
		esc_url( get_term_link( $term ) ),
		esc_html( $term->name )
	);
}

/**
 * Article meta: byline + date + read time.
 */
function rawlaw_article_meta( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'show_avatar' => false,
		'show_read'   => true,
		'show_date'   => true,
	) );

	echo '<div class="meta">';
	if ( $args['show_avatar'] ) {
		printf( '<span class="meta__avatar">%s</span>', get_avatar( get_the_author_meta( 'ID' ), 32 ) );
	}
	printf(
		'<a class="meta__author" href="%s" rel="author">%s</a>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);
	if ( $args['show_date'] ) {
		printf(
			'<time class="meta__date" datetime="%s">%s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
	}
	if ( $args['show_read'] ) {
		printf( '<span class="meta__read">%s</span>', esc_html( rawlaw_reading_time() ) );
	}
	echo '</div>';
}

/**
 * Render an SVG icon from /assets/icons/.
 */
function rawlaw_icon( $name, $class = '' ) {
	$file = RAWLAW_DIR . 'assets/icons/' . sanitize_file_name( $name ) . '.svg';
	if ( ! file_exists( $file ) ) { return; }
	$svg = file_get_contents( $file );
	if ( $class ) {
		$svg = preg_replace( '/<svg/', '<svg class="' . esc_attr( $class ) . '"', $svg, 1 );
	}
	echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Output the SVG logo.
 *
 * @param string $variant 'mark' for header (no tagline) or 'full' for footer (with tagline).
 */
function rawlaw_logo( $variant = 'mark' ) {
	$name = 'full' === $variant ? 'logo' : 'logo-mark';
	rawlaw_icon( $name, 'site-logo site-logo--' . $variant );
}

/**
 * Verified marketplace badge.
 */
function rawlaw_verified_badge( $lawyer_id ) {
	if ( get_post_meta( $lawyer_id, '_rawlaw_verified', true ) ) {
		echo '<span class="badge badge--verified" title="' . esc_attr__( 'Verified by RawLaw', 'rawlaw' ) . '">';
		rawlaw_icon( 'verified' );
		echo '<span>' . esc_html__( 'Verified', 'rawlaw' ) . '</span></span>';
	}
}

/**
 * Average rating helper for lawyer reviews (stored as comments).
 */
function rawlaw_lawyer_rating( $post_id ) {
	$comments = get_comments( array(
		'post_id' => $post_id,
		'status'  => 'approve',
		'type'    => 'review',
	) );
	if ( empty( $comments ) ) { return null; }
	$total = 0;
	foreach ( $comments as $c ) {
		$total += (float) get_comment_meta( $c->comment_ID, 'rating', true );
	}
	$avg = $total / count( $comments );
	return array( 'avg' => round( $avg, 1 ), 'count' => count( $comments ) );
}

/**
 * Render numeric pagination.
 */
function rawlaw_pagination() {
	$pages = paginate_links( array(
		'type'      => 'array',
		'prev_text' => '&larr; ' . __( 'Previous', 'rawlaw' ),
		'next_text' => __( 'Next', 'rawlaw' ) . ' &rarr;',
	) );
	if ( ! $pages ) { return; }
	echo '<nav class="pagination" aria-label="' . esc_attr__( 'Pagination', 'rawlaw' ) . '"><ul>';
	foreach ( $pages as $page ) { echo '<li>' . $page . '</li>'; } // phpcs:ignore
	echo '</ul></nav>';
}

/**
 * Auto-generate a heading-based table of contents from the post content.
 *
 * @param string $content Post content (raw HTML).
 * @return array { html, content_with_ids } - returns modified content & TOC HTML, or empty if too short.
 */
function rawlaw_build_toc( $content ) {
	if ( ! $content || ! preg_match_all( '/<h([2-3])([^>]*)>(.*?)<\/h\1>/i', $content, $m, PREG_SET_ORDER ) ) {
		return array( 'html' => '', 'content' => $content );
	}
	if ( count( $m ) < 3 ) {
		return array( 'html' => '', 'content' => $content );
	}
	$used  = array();
	$items = array();
	foreach ( $m as $h ) {
		$level = (int) $h[1];
		$text  = wp_strip_all_tags( $h[3] );
		$slug  = sanitize_title( $text );
		$base  = $slug;
		$i     = 2;
		while ( in_array( $slug, $used, true ) ) { $slug = $base . '-' . $i++; }
		$used[]  = $slug;
		$items[] = array( 'level' => $level, 'text' => $text, 'slug' => $slug );
		$replacement = sprintf( '<h%1$d id="%2$s"%3$s>%4$s</h%1$d>', $level, esc_attr( $slug ), $h[2], $h[3] );
		$content = preg_replace( '/' . preg_quote( $h[0], '/' ) . '/', $replacement, $content, 1 );
	}

	ob_start(); ?>
	<aside class="toc" aria-label="<?php esc_attr_e( 'Table of contents', 'rawlaw' ); ?>">
		<h2 class="toc__title"><?php esc_html_e( 'In this article', 'rawlaw' ); ?></h2>
		<ol class="toc__list">
			<?php foreach ( $items as $item ) : ?>
				<li class="toc__item toc__item--lvl-<?php echo (int) $item['level']; ?>">
					<a href="#<?php echo esc_attr( $item['slug'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ol>
	</aside>
	<?php
	return array( 'html' => ob_get_clean(), 'content' => $content );
}

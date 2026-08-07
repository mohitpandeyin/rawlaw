<?php
/**
 * On-page SEO metadata layer — canonical, description, Open Graph, Twitter
 * Card, robots and title filters. Owned in-theme (no SEO plugin installed);
 * marketplace indexability rules (facet noindex, unverified-profile gating)
 * are not expressible in a plugin UI.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ------------------------------------------------------------------------
 * Meta description field — hand-written first, excerpt fallback.
 * --------------------------------------------------------------------- */

function rawlaw_seo_meta_box() {
	foreach ( array( 'post', 'page', 'lawyer', 'judgment' ) as $post_type ) {
		add_meta_box( 'rawlaw_seo', __( 'SEO', 'rawlaw' ), 'rawlaw_seo_meta_box_cb', $post_type, 'normal', 'low' );
	}
}
add_action( 'add_meta_boxes', 'rawlaw_seo_meta_box' );

function rawlaw_seo_meta_box_cb( $post ) {
	wp_nonce_field( 'rawlaw_seo_save', 'rawlaw_seo_nonce' );
	wp_enqueue_media();
	wp_enqueue_script( 'rawlaw-seo-admin', RAWLAW_URI . 'assets/js/admin-seo.js', array( 'jquery' ), RAWLAW_VERSION, true );

	$title    = get_post_meta( $post->ID, '_rawlaw_seo_title', true );
	$desc     = get_post_meta( $post->ID, '_rawlaw_seo_description', true );
	$image_id = get_post_meta( $post->ID, '_rawlaw_seo_og_image', true );
	$image    = $image_id ? wp_get_attachment_image_src( $image_id, 'medium' ) : false;
	?>
	<p>
		<label for="_rawlaw_seo_title"><strong><?php esc_html_e( 'SEO title', 'rawlaw' ); ?></strong></label><br>
		<input type="text" id="_rawlaw_seo_title" name="_rawlaw_seo_title" class="widefat" maxlength="70" value="<?php echo esc_attr( $title ); ?>">
		<span class="description" data-rawlaw-seo-counter="_rawlaw_seo_title" data-rawlaw-seo-ideal="60"><?php esc_html_e( 'Around 60 characters. Falls back to the post title when left empty.', 'rawlaw' ); ?></span>
	</p>
	<p>
		<label for="_rawlaw_seo_description"><strong><?php esc_html_e( 'Meta description', 'rawlaw' ); ?></strong></label><br>
		<textarea id="_rawlaw_seo_description" name="_rawlaw_seo_description" class="widefat" rows="2" maxlength="160"><?php echo esc_textarea( $desc ); ?></textarea>
		<span class="description" data-rawlaw-seo-counter="_rawlaw_seo_description" data-rawlaw-seo-ideal="160"><?php esc_html_e( '140-160 characters. Falls back to the excerpt when left empty.', 'rawlaw' ); ?></span>
	</p>
	<p>
		<label><strong><?php esc_html_e( 'Social share image', 'rawlaw' ); ?></strong></label><br>
		<input type="hidden" id="_rawlaw_seo_og_image" name="_rawlaw_seo_og_image" value="<?php echo esc_attr( $image_id ); ?>">
		<img id="_rawlaw_seo_og_image_preview" src="<?php echo $image ? esc_url( $image[0] ) : ''; ?>" style="max-width:200px;height:auto;display:<?php echo $image ? 'block' : 'none'; ?>;margin-bottom:8px;">
		<button type="button" class="button" id="_rawlaw_seo_og_image_select"><?php esc_html_e( 'Select image', 'rawlaw' ); ?></button>
		<button type="button" class="button" id="_rawlaw_seo_og_image_remove" style="display:<?php echo $image ? 'inline-block' : 'none'; ?>;"><?php esc_html_e( 'Remove', 'rawlaw' ); ?></button>
		<br><span class="description"><?php esc_html_e( 'Falls back to the featured image, then the site default, when left empty.', 'rawlaw' ); ?></span>
	</p>
	<?php
}

function rawlaw_seo_meta_save( $post_id ) {
	if ( ! isset( $_POST['rawlaw_seo_nonce'] ) || ! wp_verify_nonce( $_POST['rawlaw_seo_nonce'], 'rawlaw_seo_save' ) ) { return; }
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
	if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }
	if ( isset( $_POST['_rawlaw_seo_title'] ) ) {
		update_post_meta( $post_id, '_rawlaw_seo_title', sanitize_text_field( wp_unslash( $_POST['_rawlaw_seo_title'] ) ) );
	}
	if ( isset( $_POST['_rawlaw_seo_description'] ) ) {
		update_post_meta( $post_id, '_rawlaw_seo_description', sanitize_textarea_field( wp_unslash( $_POST['_rawlaw_seo_description'] ) ) );
	}
	if ( isset( $_POST['_rawlaw_seo_og_image'] ) ) {
		update_post_meta( $post_id, '_rawlaw_seo_og_image', absint( $_POST['_rawlaw_seo_og_image'] ) );
	}
}
add_action( 'save_post', 'rawlaw_seo_meta_save' );

/* ------------------------------------------------------------------------
 * Resolution helpers
 * --------------------------------------------------------------------- */

/**
 * Is the current request a faceted / free-text lawyer-archive query?
 * These never get their own canonical or index entry — they fold back to
 * the bare archive (spec 15 §3.3).
 */
function rawlaw_seo_is_faceted_lawyer_request() {
	if ( ! is_post_type_archive( 'lawyer' ) && ! ( is_search() && 'lawyer' === get_query_var( 'post_type' ) ) ) {
		return false;
	}
	foreach ( array( 'practice', 'location', 'min_exp', 'verified', 'sort', 's', 'q', 'city', 'intent' ) as $key ) {
		if ( isset( $_GET[ $key ] ) && '' !== $_GET[ $key ] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}
	}
	return false;
}

function rawlaw_seo_canonical_url() {
	if ( is_singular() ) {
		return get_permalink();
	}
	if ( is_post_type_archive( 'lawyer' ) ) {
		// Always the bare archive — facets never earn their own canonical.
		return get_post_type_archive_link( 'lawyer' );
	}
	if ( is_post_type_archive() ) {
		return get_post_type_archive_link( get_query_var( 'post_type' ) );
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		return $term ? get_term_link( $term ) : home_url( '/' );
	}
	if ( is_author() ) {
		return get_author_posts_url( get_queried_object_id() );
	}
	if ( is_home() && ! is_front_page() ) {
		$page_for_posts = (int) get_option( 'page_for_posts' );
		return $page_for_posts ? get_permalink( $page_for_posts ) : home_url( '/' );
	}
	if ( is_front_page() ) {
		return home_url( '/' );
	}
	if ( is_search() ) {
		return home_url( '/?s=' . rawurlencode( get_search_query() ) );
	}
	global $wp;
	return home_url( add_query_arg( array(), $wp->request ) );
}

function rawlaw_seo_description() {
	if ( is_singular() ) {
		$custom = get_post_meta( get_queried_object_id(), '_rawlaw_seo_description', true );
		if ( $custom ) {
			return mb_substr( $custom, 0, 160 );
		}
		$excerpt = wp_strip_all_tags( get_the_excerpt() );
		return mb_substr( $excerpt, 0, 160 );
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term && ! empty( $term->description ) ) {
			return mb_substr( wp_strip_all_tags( $term->description ), 0, 160 );
		}
	}
	if ( is_post_type_archive() ) {
		$obj = get_post_type_object( get_query_var( 'post_type' ) );
		if ( $obj && ! empty( $obj->description ) ) {
			return mb_substr( wp_strip_all_tags( $obj->description ), 0, 160 );
		}
	}
	return wp_strip_all_tags( get_bloginfo( 'description' ) );
}

/**
 * Robots directives ride WordPress core's own `wp_robots` filter chain
 * (WP 5.7+) so there is exactly one <meta name="robots"> tag on the page,
 * merged with core's own defaults, instead of a second competing tag.
 */
function rawlaw_seo_robots( $robots ) {
	$noindex = is_search() || is_404() || rawlaw_seo_is_faceted_lawyer_request();

	if ( is_singular( 'lawyer' ) && ! get_post_meta( get_the_ID(), '_rawlaw_verified', true ) ) {
		$noindex = true;
	}

	if ( $noindex ) {
		$robots['noindex'] = true;
	}
	$robots['max-image-preview'] = 'large';

	return $robots;
}
add_filter( 'wp_robots', 'rawlaw_seo_robots' );

function rawlaw_seo_og_image() {
	if ( is_singular() ) {
		$override_id = (int) get_post_meta( get_queried_object_id(), '_rawlaw_seo_og_image', true );
		if ( $override_id ) {
			$src = wp_get_attachment_image_src( $override_id, 'rawlaw-og' );
			if ( $src ) {
				$alt = get_post_meta( $override_id, '_wp_attachment_image_alt', true );
				return array(
					'url'    => $src[0],
					'width'  => $src[1],
					'height' => $src[2],
					'alt'    => $alt ? $alt : get_the_title(),
				);
			}
		}
		if ( has_post_thumbnail() ) {
			$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'rawlaw-og' );
			if ( $src ) {
				$alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
				return array(
					'url'    => $src[0],
					'width'  => $src[1],
					'height' => $src[2],
					'alt'    => $alt ? $alt : get_the_title(),
				);
			}
		}
	}
	$default_id = (int) get_theme_mod( 'rawlaw_default_og_image' );
	if ( $default_id ) {
		$src = wp_get_attachment_image_src( $default_id, 'rawlaw-og' );
		if ( $src ) {
			return array(
				'url'    => $src[0],
				'width'  => $src[1],
				'height' => $src[2],
				'alt'    => get_bloginfo( 'name' ),
			);
		}
	}
	$logo_id = get_theme_mod( 'custom_logo' );
	if ( $logo_id ) {
		$src = wp_get_attachment_image_src( $logo_id, 'full' );
		if ( $src ) {
			return array(
				'url'    => $src[0],
				'width'  => $src[1],
				'height' => $src[2],
				'alt'    => get_bloginfo( 'name' ),
			);
		}
	}
	return null;
}

/* ------------------------------------------------------------------------
 * Output
 * --------------------------------------------------------------------- */

function rawlaw_seo_head() {
	if ( is_admin() ) { return; }

	$canonical   = rawlaw_seo_canonical_url();
	$description = rawlaw_seo_description();
	$title       = wp_get_document_title();
	$image       = rawlaw_seo_og_image();
	$og_type     = is_singular( 'post' ) ? 'article' : 'website';
	$locale      = str_replace( '-', '_', get_locale() );

	echo "\n<!-- RawLaw SEO -->\n";
	printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );

	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $og_type ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $canonical ) );
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:locale" content="%s">' . "\n", esc_attr( $locale ) );

	if ( $image ) {
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image['url'] ) );
		printf( '<meta property="og:image:width" content="%d">' . "\n", (int) $image['width'] );
		printf( '<meta property="og:image:height" content="%d">' . "\n", (int) $image['height'] );
		printf( '<meta property="og:image:alt" content="%s">' . "\n", esc_attr( $image['alt'] ) );
	}

	if ( is_singular( 'post' ) ) {
		$post = get_queried_object();
		printf( '<meta property="article:published_time" content="%s">' . "\n", esc_attr( get_the_date( 'c' ) ) );
		printf( '<meta property="article:modified_time" content="%s">' . "\n", esc_attr( get_the_modified_date( 'c' ) ) );
		printf( '<meta property="article:author" content="%s">' . "\n", esc_attr( get_the_author_meta( 'display_name', $post->post_author ) ) );
	}

	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $description ) );
	if ( $image ) {
		printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $image['url'] ) );
	}
	echo "<!-- /RawLaw SEO -->\n";
}
add_action( 'wp_head', 'rawlaw_seo_head', 2 );

/* ------------------------------------------------------------------------
 * Title tag — em-dash separator, unprefixed archive titles.
 * --------------------------------------------------------------------- */

add_filter( 'document_title_separator', function() {
	return '—';
} );

add_filter( 'document_title_parts', function( $parts ) {
	if ( is_singular() ) {
		$custom = get_post_meta( get_queried_object_id(), '_rawlaw_seo_title', true );
		if ( $custom ) {
			$parts['title'] = mb_substr( $custom, 0, 60 );
		}
	}
	if ( is_category() || is_tag() || is_tax() ) {
		$term = get_queried_object();
		if ( $term ) {
			$parts['title'] = $term->name;
		}
	}
	if ( is_post_type_archive() ) {
		$obj = get_post_type_object( get_query_var( 'post_type' ) );
		if ( $obj ) {
			$parts['title'] = $obj->labels->name;
		}
	}
	return $parts;
} );

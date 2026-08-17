<?php
/**
 * Indexability policy — the single source of truth for "does this URL belong
 * in a search index", consumed by both the `<meta name="robots">` filter in
 * inc/seo-meta.php and by core's sitemap providers below.
 *
 * The two consumers MUST agree. A URL that carries `noindex` while still
 * shipping in wp-sitemap.xml is a self-contradiction — the sitemap invites
 * the crawl, the meta tag rejects the result — and Search Console files it
 * under "Excluded by 'noindex'" against a URL the site itself submitted.
 * Keeping one predicate here, rather than a noindex rule in one file and a
 * sitemap rule in another, is what stops the two drifting apart.
 *
 * Note what this file deliberately does NOT do: it adds nothing to
 * robots.txt. Disallowing an already-indexed URL prevents the re-crawl that
 * would let a crawler see the new `noindex`, which freezes the bloat in the
 * index permanently — the same ordering trap already documented at the head
 * of inc/robots.php.
 *
 * ## Why this exists (2026-08-17)
 *
 * AdSense rejected rawlaw.in for "Low value content". Measured against
 * production that day:
 *
 * - 4,511 posts (~1,600 words each — these are not the problem)
 * - 11,893 indexable `post_tag` archives, none carrying a `noindex`
 * - 13 pages, six of which are content-free account plumbing
 * - 1 category, 2 author archives
 *
 * So ~72% of the whole indexable surface was tag archives. A 60-tag sample
 * spread evenly across all six tag sitemaps found 85% carry exactly one
 * post and 96.7% carry fewer than five — sample counts of 1, 2, 3, 8 and
 * 10, with ~50 words of unique text on a single-post archive. Applying
 * spec 07's *existing* "<5 posts" rule (docs/specs/07-seo.md, roadmap 1.14)
 * therefore drops roughly 11,500 URLs without touching one article.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ------------------------------------------------------------------------
 * Policy
 * --------------------------------------------------------------------- */

/**
 * Minimum posts a tag archive needs before it earns a place in the index.
 *
 * spec 07 §"Thin archives" already states the rule as "tag archives with
 * <5 posts"; this is that rule, made executable. Below the threshold the
 * archive is a title, a date and one card — a strictly worse version of the
 * article it links to.
 */
function rawlaw_tag_index_min_posts() {
	return (int) apply_filters( 'rawlaw_tag_index_min_posts', 5 );
}

/**
 * Account plumbing: real pages, in the sitemap, with no content a crawler
 * can read. `/log-in/`, `/register/` and friends render a form; `/account/`,
 * `/profile/` and `/bookmarks/` render nothing at all until someone signs
 * in. Six of the site's thirteen pages, which is why a reviewer sampling
 * "the pages of rawlaw.in" mostly found login screens.
 *
 * Matched on slug rather than ID because these are wp-user-manager's pages,
 * not the theme's — the theme has no hook into their creation, and the IDs
 * differ between the local install and production.
 */
function rawlaw_utility_page_slugs() {
	return (array) apply_filters(
		'rawlaw_utility_page_slugs',
		array( 'log-in', 'password-reset', 'register', 'account', 'profile', 'bookmarks' )
	);
}

/**
 * Whether author archives are indexable.
 *
 * Currently false, and the reason is specific rather than doctrinal: both
 * accounts (`rawlaw`, `safflowerin`) have empty bios, and every article
 * carries the same institutional byline, so `/author/rawlaw/` paginates
 * through very nearly the same 4,511 posts as `/news/` with no unique copy
 * of its own.
 *
 * This should be flipped back to true — author pages are an asset, not a
 * liability, once they say who someone is. The condition is real named
 * authors with credentials (bar enrolment, practice area, photograph),
 * which is editorial work tracked separately, not a code change here.
 */
function rawlaw_authors_indexable() {
	return (bool) apply_filters( 'rawlaw_authors_indexable', false );
}

/* ------------------------------------------------------------------------
 * The predicate
 * --------------------------------------------------------------------- */

/**
 * Should the current request be kept out of the index?
 *
 * Read by rawlaw_seo_robots() in inc/seo-meta.php. Query-dependent, so it
 * is only meaningful from `wp` onwards — never call it at load time.
 */
function rawlaw_is_noindex_request() {
	if ( is_search() || is_404() ) {
		return true;
	}

	if ( is_author() ) {
		return ! rawlaw_authors_indexable();
	}

	if ( is_tag() ) {
		$term = get_queried_object();

		return ! $term instanceof WP_Term
			|| (int) $term->count < rawlaw_tag_index_min_posts();
	}

	if ( is_page() ) {
		$page = get_queried_object();

		return $page instanceof WP_Post
			&& in_array( $page->post_name, rawlaw_utility_page_slugs(), true );
	}

	return false;
}

/* ------------------------------------------------------------------------
 * Resolved ID sets — shared by the sitemap filters below
 * --------------------------------------------------------------------- */

/**
 * Tag term IDs at or above the threshold, i.e. the ones that stay in the
 * sitemap. ~390 of 11,893 on the numbers above.
 *
 * get_terms() cannot filter on `count`, so the comparison happens in PHP
 * over the full term set and the answer is cached for twelve hours. The
 * cache is deliberately not invalidated on every post save: at 15–33 posts
 * a day that would recompute the whole set dozens of times daily to no
 * purpose. A tag crossing 4 → 5 posts simply joins the sitemap within half
 * a day, and it is already reachable in the meantime through the tag links
 * every article footer carries.
 */
function rawlaw_indexable_tag_ids() {
	// Memoised per request as well as per transient: core calls
	// get_object_subtypes() once for the sitemap index and again for each
	// page, and both paths land here.
	static $memo = null;
	if ( is_array( $memo ) ) {
		return $memo;
	}

	$cached = get_transient( 'rawlaw_indexable_tag_ids' );
	if ( is_array( $cached ) ) {
		$memo = $cached;

		return $memo;
	}

	$min   = rawlaw_tag_index_min_posts();
	$terms = get_terms(
		array(
			'taxonomy'               => 'post_tag',
			'hide_empty'             => true,
			'update_term_meta_cache' => false,
		)
	);

	$ids = array();
	if ( ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			if ( (int) $term->count >= $min ) {
				$ids[] = (int) $term->term_id;
			}
		}
	}

	set_transient( 'rawlaw_indexable_tag_ids', $ids, 12 * HOUR_IN_SECONDS );
	$memo = $ids;

	return $memo;
}

/**
 * Drop the cached tag set when a term is edited, merged or deleted, so the
 * editorial hygiene pass in roadmap 1.14 (synonym merges, typo fixes) shows
 * up in the sitemap immediately rather than up to twelve hours later.
 */
function rawlaw_flush_indexable_tag_ids() {
	delete_transient( 'rawlaw_indexable_tag_ids' );
}
add_action( 'edited_post_tag', 'rawlaw_flush_indexable_tag_ids' );
add_action( 'created_post_tag', 'rawlaw_flush_indexable_tag_ids' );
add_action( 'delete_post_tag', 'rawlaw_flush_indexable_tag_ids' );

/**
 * Page IDs for the account plumbing, resolved from slugs in one query.
 */
function rawlaw_utility_page_ids() {
	$slugs = rawlaw_utility_page_slugs();
	if ( ! $slugs ) {
		return array();
	}

	return get_posts(
		array(
			'post_type'              => 'page',
			'post_status'            => 'any',
			'post_name__in'          => $slugs,
			'posts_per_page'         => count( $slugs ),
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);
}

/* ------------------------------------------------------------------------
 * Sitemap alignment — wp-sitemap.xml must offer only what is indexable
 * --------------------------------------------------------------------- */

/**
 * Restrict the tag sitemap to the archives that clear the threshold.
 *
 * The empty-set guard matters: WP_Term_Query treats an empty `include` as
 * "no restriction", so assigning one would silently re-admit all 11,893
 * tags. When nothing qualifies the taxonomy is removed outright, in
 * rawlaw_sitemap_taxonomies() below.
 */
function rawlaw_sitemap_tag_query_args( $args, $taxonomy ) {
	if ( 'post_tag' !== $taxonomy ) {
		return $args;
	}

	$ids = rawlaw_indexable_tag_ids();
	if ( $ids ) {
		$args['include'] = $ids;
	}

	return $args;
}
add_filter( 'wp_sitemaps_taxonomies_query_args', 'rawlaw_sitemap_tag_query_args', 10, 2 );

function rawlaw_sitemap_taxonomies( $taxonomies ) {
	if ( isset( $taxonomies['post_tag'] ) && ! rawlaw_indexable_tag_ids() ) {
		unset( $taxonomies['post_tag'] );
	}

	return $taxonomies;
}
add_filter( 'wp_sitemaps_taxonomies', 'rawlaw_sitemap_taxonomies' );

/**
 * Keep the account plumbing out of the page sitemap.
 */
function rawlaw_sitemap_page_query_args( $args, $post_type ) {
	if ( 'page' !== $post_type ) {
		return $args;
	}

	$ids = rawlaw_utility_page_ids();
	if ( $ids ) {
		$existing             = isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array();
		$args['post__not_in'] = array_merge( $existing, $ids );
	}

	return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'rawlaw_sitemap_page_query_args', 10, 2 );

/**
 * Retire wp-sitemap-users-1.xml while author archives are noindexed.
 */
function rawlaw_sitemap_drop_users_provider( $provider, $name ) {
	if ( 'users' === $name && ! rawlaw_authors_indexable() ) {
		return false;
	}

	return $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'rawlaw_sitemap_drop_users_provider', 10, 2 );

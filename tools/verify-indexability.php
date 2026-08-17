<?php
/**
 * Standalone harness for inc/indexability.php — stubs just enough of the
 * WordPress API to exercise the predicate and the sitemap filters.
 */

define( 'ABSPATH', __DIR__ );
define( 'HOUR_IN_SECONDS', 3600 );

// ---- Mutable request state the stubs read -------------------------------
$STATE = array(
	'search' => false, '404' => false, 'author' => false,
	'tag'    => false, 'page' => false, 'queried' => null,
	'terms'  => array(),
);

class WP_Term { public $term_id; public $count; public function __construct( $id, $c ) { $this->term_id = $id; $this->count = $c; } }
class WP_Post { public $post_name; public function __construct( $s ) { $this->post_name = $s; } }

function is_search()         { global $STATE; return $STATE['search']; }
function is_404()            { global $STATE; return $STATE['404']; }
function is_author()         { global $STATE; return $STATE['author']; }
function is_tag()            { global $STATE; return $STATE['tag']; }
function is_page()           { global $STATE; return $STATE['page']; }
function get_queried_object(){ global $STATE; return $STATE['queried']; }

function apply_filters( $h, $v ) { return $v; }
function add_filter() {} function add_action() {}
function is_wp_error( $t )  { return false; }
function get_transient( $k ) { return false; }
function set_transient() {}
function delete_transient() {}
function get_terms( $args )  { global $STATE; return $STATE['terms']; }
function get_posts( $args )  { return array( 101, 102, 103, 104, 105, 106 ); }

require dirname( __DIR__ ) . '/inc/indexability.php';

// ---- Harness -----------------------------------------------------------
$pass = 0; $fail = 0;
function check( $label, $actual, $expected ) {
	global $pass, $fail;
	$ok = ( $actual === $expected );
	$ok ? $pass++ : $fail++;
	printf(
		"%s %-52s got %-22s want %s\n",
		$ok ? 'PASS' : 'FAIL',
		$label,
		var_export( $actual, true ),
		var_export( $expected, true )
	);
}
function reset_state() {
	global $STATE;
	$STATE = array( 'search'=>false, '404'=>false, 'author'=>false, 'tag'=>false, 'page'=>false, 'queried'=>null, 'terms'=>array() );
}

echo "=== rawlaw_is_noindex_request() ===\n";

reset_state(); check( 'front page / single post / category', rawlaw_is_noindex_request(), false );
reset_state(); $STATE['search'] = true; check( 'search results', rawlaw_is_noindex_request(), true );
reset_state(); $STATE['404'] = true;    check( '404', rawlaw_is_noindex_request(), true );
reset_state(); $STATE['author'] = true; check( 'author archive (bios absent)', rawlaw_is_noindex_request(), true );

// Tag thresholds — the live distribution was 1, 2, 3, 8, 10.
foreach ( array( 0 => true, 1 => true, 2 => true, 4 => true, 5 => false, 8 => false, 10 => false ) as $count => $want ) {
	reset_state();
	$STATE['tag'] = true;
	$STATE['queried'] = new WP_Term( 7, $count );
	check( "tag archive with {$count} post(s)", rawlaw_is_noindex_request(), $want );
}

reset_state(); $STATE['tag'] = true; $STATE['queried'] = null;
check( 'tag archive, term unresolvable', rawlaw_is_noindex_request(), true );

foreach ( array( 'log-in', 'password-reset', 'register', 'account', 'profile', 'bookmarks' ) as $slug ) {
	reset_state(); $STATE['page'] = true; $STATE['queried'] = new WP_Post( $slug );
	check( "utility page /{$slug}/", rawlaw_is_noindex_request(), true );
}
foreach ( array( 'privacy-policy', 'contact', 'terms-and-conditions', 'about', 'editorial-policy' ) as $slug ) {
	reset_state(); $STATE['page'] = true; $STATE['queried'] = new WP_Post( $slug );
	check( "real page /{$slug}/ stays indexable", rawlaw_is_noindex_request(), false );
}

echo "\n=== sitemap filters ===\n";

// rawlaw_indexable_tag_ids() memoises in a function static, which is correct
// per request but means one process can only exercise one term set. The
// empty-set branch therefore runs as a second process: `php <file> empty`.
$scenario = $argv[1] ?? 'populated';

if ( 'empty' === $scenario ) {
	// THE TRAP: no tag qualifies. WP_Term_Query ignores an empty `include`,
	// so assigning one would silently re-admit all 11,893 tags — post_tag
	// has to be dropped from the sitemap index instead.
	$STATE['terms'] = array( new WP_Term( 21, 1 ), new WP_Term( 22, 2 ) );

	check( 'indexable tag ids (counts 1,2) is empty', rawlaw_indexable_tag_ids(), array() );

	$args = rawlaw_sitemap_tag_query_args( array( 'taxonomy' => 'post_tag' ), 'post_tag' );
	check( 'no include key when nothing qualifies', isset( $args['include'] ), false );

	check( 'post_tag dropped from sitemap index instead',
		array_keys( rawlaw_sitemap_taxonomies( array( 'post_tag' => 1, 'category' => 1 ) ) ),
		array( 'category' ) );

	printf( "\n%d passed, %d failed\n", $pass, $fail );
	exit( $fail > 0 ? 1 : 0 );
}

// Populated tag set: only >=5 survives.
$STATE['terms'] = array(
	new WP_Term( 11, 1 ), new WP_Term( 12, 4 ), new WP_Term( 13, 5 ),
	new WP_Term( 14, 8 ), new WP_Term( 15, 10 ),
);
check( 'indexable tag ids (counts 1,4,5,8,10)', rawlaw_indexable_tag_ids(), array( 13, 14, 15 ) );

// Second call must hit the memo and agree with the first.
check( 'memoised call returns the same set', rawlaw_indexable_tag_ids(), array( 13, 14, 15 ) );

$args = rawlaw_sitemap_tag_query_args( array( 'taxonomy' => 'post_tag' ), 'post_tag' );
check( 'post_tag sitemap gets include list', $args['include'] ?? null, array( 13, 14, 15 ) );

$args = rawlaw_sitemap_tag_query_args( array( 'taxonomy' => 'category' ), 'category' );
check( 'category sitemap untouched', isset( $args['include'] ), false );

check( 'post_tag kept in sitemap index when some qualify',
	array_keys( rawlaw_sitemap_taxonomies( array( 'post_tag' => 1, 'category' => 1 ) ) ),
	array( 'post_tag', 'category' ) );

$args = rawlaw_sitemap_page_query_args( array(), 'page' );
check( 'utility pages excluded from page sitemap', $args['post__not_in'] ?? null, array( 101, 102, 103, 104, 105, 106 ) );

$args = rawlaw_sitemap_page_query_args( array( 'post__not_in' => array( 999 ) ), 'page' );
check( 'pre-existing post__not_in preserved', $args['post__not_in'] ?? null, array( 999, 101, 102, 103, 104, 105, 106 ) );

$args = rawlaw_sitemap_page_query_args( array(), 'post' );
check( 'post sitemap untouched (all 4,511 articles)', isset( $args['post__not_in'] ), false );

check( 'users provider dropped', rawlaw_sitemap_drop_users_provider( 'obj', 'users' ), false );
check( 'other providers pass through', rawlaw_sitemap_drop_users_provider( 'obj', 'posts' ), 'obj' );

printf( "\n%d passed, %d failed\n", $pass, $fail );
exit( $fail > 0 ? 1 : 0 );

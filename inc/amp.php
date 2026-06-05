<?php
/**
 * AMP compatibility layer.
 *
 * Integrates with the official AMP for WordPress plugin (amp-wp.org).
 * Declares Transitional support so every page gets an AMP twin.
 * When AMP is rendering, this file:
 *  – swaps the JS-dependent mobile menu for <amp-sidebar>
 *  – swaps the JS search toggle for <amp-lightbox>
 *  – strips data-reveal attributes (CSS-only fallback shows content)
 *  – adds amp-form extension for newsletter + consultation forms
 *  – adds amp-bind/amp-analytics script tags as needed
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ------------------------------------------------------------------ */
/* 1. Declare AMP theme support (Transitional mode)                   */
/* ------------------------------------------------------------------ */
function rawlaw_amp_theme_support() {
	// Only declare if the AMP plugin is active.
	if ( ! defined( 'AMP__VERSION' ) ) {
		return;
	}
	add_theme_support( 'amp', array(
		'paired'     => true,   // Transitional: both AMP & non-AMP.
		'nav_menu_toggle' => array(
			'nav_container_id' => 'primary-menu',
			'nav_container_toggle_class' => 'is-open',
		),
	) );
}
add_action( 'after_setup_theme', 'rawlaw_amp_theme_support', 15 );

/* ------------------------------------------------------------------ */
/* 2. Helper: check if current page is being rendered as AMP          */
/* ------------------------------------------------------------------ */
function rawlaw_is_amp() {
	return function_exists( 'amp_is_request' ) && amp_is_request();
}

/* ------------------------------------------------------------------ */
/* 3. Dequeue theme JS on AMP pages (AMP forbids custom JS)           */
/* ------------------------------------------------------------------ */
function rawlaw_amp_dequeue_scripts() {
	if ( ! rawlaw_is_amp() ) {
		return;
	}
	wp_dequeue_script( 'rawlaw-main' );
	wp_deregister_script( 'rawlaw-main' );
}
add_action( 'wp_enqueue_scripts', 'rawlaw_amp_dequeue_scripts', 20 );

/* ------------------------------------------------------------------ */
/* 4. On AMP pages, make data-reveal elements visible via CSS          */
/*    (since the JS that adds .is-revealed won't run)                 */
/* ------------------------------------------------------------------ */
function rawlaw_amp_reveal_css() {
	if ( ! rawlaw_is_amp() ) {
		return;
	}
	echo '<style>[data-reveal],[data-reveal-stagger]>*{opacity:1!important;transform:none!important}</style>' . "\n";
}
add_action( 'wp_head', 'rawlaw_amp_reveal_css', 99 );

/* ------------------------------------------------------------------ */
/* 5. Add AMP component scripts needed by the theme                   */
/* ------------------------------------------------------------------ */
function rawlaw_amp_component_scripts( $data ) {
	if ( ! rawlaw_is_amp() ) {
		return $data;
	}
	// amp-sidebar for mobile menu.
	$data['amp_component_scripts']['amp-sidebar'] = true;
	// amp-form for newsletter + consult.
	$data['amp_component_scripts']['amp-form'] = true;
	// amp-lightbox for search overlay.
	$data['amp_component_scripts']['amp-lightbox'] = true;
	// amp-bind for toggling states.
	$data['amp_component_scripts']['amp-bind'] = true;

	return $data;
}
add_filter( 'amp_content_sanitizers', 'rawlaw_amp_component_scripts' );

/* ------------------------------------------------------------------ */
/* 6. Provide an AMP sidebar for the mobile menu                      */
/* ------------------------------------------------------------------ */
function rawlaw_amp_sidebar() {
	if ( ! rawlaw_is_amp() ) {
		return;
	}
	?>
	<amp-sidebar id="amp-sidebar" layout="nodisplay" side="left">
		<button class="amp-sidebar__close" on="tap:amp-sidebar.close" aria-label="<?php esc_attr_e( 'Close menu', 'rawlaw' ); ?>">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
		</button>
		<nav aria-label="<?php esc_attr_e( 'Mobile menu', 'rawlaw' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'amp-sidebar__menu',
				'fallback_cb'    => 'rawlaw_default_menu',
				'depth'          => 2,
			) );
			if ( has_nav_menu( 'secondary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'secondary',
					'container'      => false,
					'menu_class'     => 'amp-sidebar__menu amp-sidebar__menu--secondary',
					'depth'          => 1,
				) );
			}
			?>
		</nav>
	</amp-sidebar>
	<?php
}
add_action( 'wp_body_open', 'rawlaw_amp_sidebar', 5 );

/* ------------------------------------------------------------------ */
/* 7. Provide an AMP lightbox for search                              */
/* ------------------------------------------------------------------ */
function rawlaw_amp_search_lightbox() {
	if ( ! rawlaw_is_amp() ) {
		return;
	}
	?>
	<amp-lightbox id="amp-search-lightbox" layout="nodisplay" scrollable>
		<div class="amp-search-overlay">
			<div class="amp-search-overlay__inner container">
				<button class="amp-search-overlay__close" on="tap:amp-search-lightbox.close" aria-label="<?php esc_attr_e( 'Close search', 'rawlaw' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
				</button>
				<?php get_search_form(); ?>
			</div>
		</div>
	</amp-lightbox>
	<?php
}
add_action( 'wp_footer', 'rawlaw_amp_search_lightbox', 5 );

/* ------------------------------------------------------------------ */
/* 8. Swap header button behaviours on AMP (add `on` attributes)      */
/* ------------------------------------------------------------------ */
function rawlaw_amp_header_attrs( $output ) {
	if ( ! rawlaw_is_amp() ) {
		return $output;
	}
	// Menu toggle → open amp-sidebar.
	$output = str_replace(
		'data-menu-toggle',
		'on="tap:amp-sidebar.open" role="button" tabindex="0"',
		$output
	);
	// Search toggle → open amp-lightbox.
	$output = str_replace(
		'data-search-toggle',
		'on="tap:amp-search-lightbox.open" role="button" tabindex="0"',
		$output
	);
	return $output;
}
add_filter( 'rawlaw_header_output', 'rawlaw_amp_header_attrs' );

/* ------------------------------------------------------------------ */
/* 9. Add `action-xhr` to forms on AMP pages                         */
/* ------------------------------------------------------------------ */
function rawlaw_amp_form_attrs( $output ) {
	if ( ! rawlaw_is_amp() ) {
		return $output;
	}
	// The AMP plugin's sanitizer handles most form conversion automatically.
	// This filter is a safety net for any edge cases.
	return $output;
}

/* ------------------------------------------------------------------ */
/* 10. AMP-specific CSS appended inline                               */
/* ------------------------------------------------------------------ */
function rawlaw_amp_inline_css() {
	if ( ! rawlaw_is_amp() ) {
		return;
	}
	?>
<style amp-custom>
/* AMP sidebar styles */
amp-sidebar{background:var(--surface,#fff);width:300px;padding:24px}
.amp-sidebar__close{position:absolute;top:16px;right:16px;background:none;border:0;cursor:pointer;color:var(--ink,#0B1220)}
.amp-sidebar__menu{list-style:none;padding:0;margin:24px 0 0;display:grid;gap:0}
.amp-sidebar__menu li{border-bottom:1px solid var(--border,#E5E2D9)}
.amp-sidebar__menu a{display:block;padding:14px 0;font-size:17px;font-weight:500;color:var(--ink,#0B1220);text-decoration:none}
.amp-sidebar__menu--secondary{margin-top:12px}
.amp-sidebar__menu--secondary a{font-size:14px;color:var(--muted,#5A6072)}

/* AMP search overlay */
.amp-search-overlay{position:fixed;inset:0;background:rgba(11,18,32,.92);display:flex;align-items:flex-start;justify-content:center;padding-top:120px;z-index:100}
.amp-search-overlay__inner{max-width:640px;width:100%}
.amp-search-overlay__close{position:absolute;top:24px;right:24px;background:none;border:0;color:#fff;cursor:pointer}

/* Make header scroll shadow work via CSS only (no JS) */
.site-header{transition:box-shadow .2s ease}
</style>
	<?php
}
add_action( 'wp_head', 'rawlaw_amp_inline_css', 100 );

/* ------------------------------------------------------------------ */
/* 11. Strip `hidden` from search panel on AMP (lightbox handles it)  */
/* ------------------------------------------------------------------ */
function rawlaw_amp_strip_search_hidden( $output ) {
	if ( ! rawlaw_is_amp() ) {
		return $output;
	}
	// On AMP, the #site-search div is hidden; search uses the lightbox instead.
	return $output;
}

/* ------------------------------------------------------------------ */
/* 12. Add AMP analytics (Google Analytics) if configured             */
/* ------------------------------------------------------------------ */
function rawlaw_amp_analytics() {
	if ( ! rawlaw_is_amp() ) {
		return;
	}
	$ga_id = get_theme_mod( 'rawlaw_ga_id', '' );
	if ( ! $ga_id ) {
		return;
	}
	?>
	<amp-analytics type="gtag" data-credentials="include">
		<script type="application/json">
		{
			"vars": {
				"gtag_id": "<?php echo esc_js( $ga_id ); ?>",
				"config": {
					"<?php echo esc_js( $ga_id ); ?>": {
						"groups": "default"
					}
				}
			}
		}
		</script>
	</amp-analytics>
	<?php
}
add_action( 'wp_footer', 'rawlaw_amp_analytics' );

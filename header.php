<?php
/**
 * The header.
 *
 * @package RawLaw
 */
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#0B1220">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php if ( ! rawlaw_is_amp() ) : ?><script>document.documentElement.classList.remove('no-js')</script><?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#site-main"><?php esc_html_e( 'Skip to content', 'rawlaw' ); ?></a>

<header class="site-header" role="banner" data-reveal>
	<div class="site-header__bar">
		<div class="container site-header__inner">

			<button class="site-header__menu-toggle" aria-expanded="false" aria-controls="primary-menu" <?php echo rawlaw_is_amp() ? 'on="tap:amp-sidebar.open"' : 'data-menu-toggle'; ?>>
				<span class="hamburger" aria-hidden="true"><span></span><span></span><span></span></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'rawlaw' ); ?></span>
			</button>

			<div class="site-branding">
				<a class="site-branding__title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img class="site-logo" src="<?php echo esc_url( RAWLAW_URI . 'assets/media/rawlaw-logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="332" height="84">
				</a>
			</div>

			<nav class="site-nav" id="primary-menu" aria-label="<?php esc_attr_e( 'Primary', 'rawlaw' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'menu menu--primary',
					'fallback_cb'    => 'rawlaw_default_menu',
					'depth'          => 2,
				) );
				?>
			</nav>

			<div class="site-header__actions">
				<button class="icon-btn" <?php echo rawlaw_is_amp() ? 'on="tap:amp-search-lightbox.open"' : 'data-search-toggle'; ?> aria-expanded="false" aria-controls="site-search">
					<?php rawlaw_icon( 'search' ); ?>
					<span class="screen-reader-text"><?php esc_html_e( 'Search', 'rawlaw' ); ?></span>
				</button>
				<a class="btn btn--primary" href="https://app.rawlaw.in/register/client" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Get legal help', 'rawlaw' ); ?>">
					<?php rawlaw_icon( 'user' ); ?>
					<?php esc_html_e( 'Get Legal Help', 'rawlaw' ); ?>
				</a>
			</div>
		</div>
	</div>

	<div class="site-search" id="site-search" hidden>
		<div class="container">
			<?php get_search_form(); ?>
		</div>
	</div>
</header>

<?php
if ( ! function_exists( 'rawlaw_default_menu' ) ) {
	function rawlaw_default_menu() {
		echo '<ul class="menu menu--primary">';
		echo '<li><a href="' . esc_url( home_url( '/news/' ) ) . '">' . esc_html__( 'Legal News', 'rawlaw' ) . '</a></li>';
		echo '<li><a href="' . esc_url( home_url( '/practice-areas/' ) ) . '">' . esc_html__( 'Practice Areas', 'rawlaw' ) . '</a></li>';
		echo '<li><a href="' . esc_url( get_post_type_archive_link( 'lawyer' ) ?: home_url( '/find-a-lawyer/' ) ) . '">' . esc_html__( 'Find a Lawyer', 'rawlaw' ) . '</a></li>';
		echo '<li><a href="' . esc_url( get_post_type_archive_link( 'judgment' ) ?: home_url( '/judgments/' ) ) . '">' . esc_html__( 'Judgments', 'rawlaw' ) . '</a></li>';
		echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">' . esc_html__( 'About', 'rawlaw' ) . '</a></li>';
		echo '</ul>';
	}
}

rawlaw_breadcrumbs();
?>

<main id="site-main" class="site-main" tabindex="-1">

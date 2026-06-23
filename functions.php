<?php
/**
 * RawLaw theme bootstrap.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RAWLAW_VERSION', '1.0.0' );
define( 'RAWLAW_DIR', trailingslashit( get_template_directory() ) );
define( 'RAWLAW_URI', trailingslashit( get_template_directory_uri() ) );

require RAWLAW_DIR . 'inc/setup.php';
require RAWLAW_DIR . 'inc/enqueue.php';
require RAWLAW_DIR . 'inc/security.php';
require RAWLAW_DIR . 'inc/widgets.php';
require RAWLAW_DIR . 'inc/template-tags.php';
require RAWLAW_DIR . 'inc/breadcrumbs.php';
require RAWLAW_DIR . 'inc/schema.php';
require RAWLAW_DIR . 'inc/cpt.php';
require RAWLAW_DIR . 'inc/taxonomies.php';
require RAWLAW_DIR . 'inc/customizer.php';
require RAWLAW_DIR . 'inc/meta-boxes.php';
require RAWLAW_DIR . 'inc/marketplace.php';
require RAWLAW_DIR . 'inc/search-router.php';
require RAWLAW_DIR . 'inc/amp.php';
require RAWLAW_DIR . 'inc/contact-form.php';

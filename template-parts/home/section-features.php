<?php
/**
 * Section — Platform features marquee strip.
 *
 * Thin scroll-driven horizontal strip: icon + title only, no descriptions.
 * Items are rendered once in PHP; marquee.js duplicates them for the
 * scroll-driven GSAP animation. Falls back to a static scrollable row when
 * JS is unavailable or prefers-reduced-motion is set.
 *
 * @package RawLaw
 */

$features = array(
	array(
		'icon'  => 'search',
		'title' => __( 'Smart Matching', 'rawlaw' ),
	),
	array(
		'icon'  => 'shield-checkmark',
		'title' => __( 'Verified Profiles', 'rawlaw' ),
	),
	array(
		'icon'  => 'drafts',
		'title' => __( 'Drafts & Orders', 'rawlaw' ),
	),
	array(
		'icon'  => 'chat',
		'title' => __( 'Real-time Chat', 'rawlaw' ),
	),
	array(
		'icon'  => 'news',
		'title' => __( 'Legal News Feed', 'rawlaw' ),
	),
	array(
		'icon'  => 'lock',
		'title' => __( 'Secure & Confidential', 'rawlaw' ),
	),
	array(
		'icon'  => 'user',
		'title' => __( 'Dedicated Experts', 'rawlaw' ),
	),
	array(
		'icon'  => 'clock',
		'title' => __( 'Quick Responses', 'rawlaw' ),
	),
);
?>
<section class="features-bar" aria-label="<?php esc_attr_e( 'Platform highlights', 'rawlaw' ); ?>">
	<div class="features-bar__track" role="list">
		<?php foreach ( $features as $f ) : ?>
			<div class="features-bar__item" role="listitem">
				<span class="features-bar__icon" aria-hidden="true"><?php rawlaw_icon( $f['icon'] ); ?></span>
				<span class="features-bar__title"><?php echo esc_html( $f['title'] ); ?></span>
			</div>
			<span class="features-bar__sep" aria-hidden="true" role="presentation"></span>
		<?php endforeach; ?>
	</div>
</section>

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

$features = rawlaw_home_get( 'features', array() );
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

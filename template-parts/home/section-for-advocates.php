<?php
/**
 * Section — For Advocates supply acquisition.
 *
 * @package RawLaw
 */

$services_url = esc_url( home_url( '/services-for-advocates/' ) );
$advocates    = rawlaw_home_get( 'advocates', array() );
?>
<section id="for-advocates" class="section section--for-advocates" aria-labelledby="advocates-growth-heading" data-reveal>
	<div class="container advocate-growth">
		<div class="advocate-growth__content">
			<p class="section__eyebrow"><?php echo esc_html( $advocates['eyebrow'] ); ?></p>
			<h2 id="advocates-growth-heading" class="section__title"><?php echo esc_html( $advocates['title'] ); ?></h2>
			<p class="advocate-growth__text">
				<?php echo esc_html( $advocates['text'] ); ?>
			</p>
			<div class="advocate-growth__actions">
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( $advocates['primary_url'] ); ?>" target="_blank" rel="noopener">
					<?php echo esc_html( $advocates['primary_cta'] ); ?>
				</a>
				<a class="btn btn--ghost btn--lg" href="<?php echo $services_url; ?>">
					<?php echo esc_html( $advocates['secondary_cta'] ); ?>
				</a>
			</div>
		</div>

		<ul class="advocate-growth__list" aria-label="<?php esc_attr_e( 'Advocate benefits', 'rawlaw' ); ?>">
			<?php foreach ( $advocates['benefits'] as $benefit ) : ?>
			<li>
				<strong><?php echo esc_html( $benefit['title'] ); ?></strong>
				<span><?php echo esc_html( $benefit['text'] ); ?></span>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<?php
/**
 * Trust stats strip — prominent numbers with icons.
 *
 * Numbers are cached via transient for 1 hour. Lawyer/city counts were
 * removed 2026-08-07 with the `lawyer` CPT (see docs/AUDIT.md) — this
 * now shows only stats the editorial site itself can back up.
 *
 * @package RawLaw
 */

$stats = get_transient( 'rawlaw_trust_stats' );
if ( false === $stats ) {
	$article_count  = wp_count_posts( 'post' );
	$practice_areas = wp_count_terms( array( 'taxonomy' => 'practice_area', 'hide_empty' => true ) );

	$stats = array(
		'areas'    => is_wp_error( $practice_areas ) ? 0 : (int) $practice_areas,
		'articles' => is_object( $article_count ) ? (int) $article_count->publish : 0,
	);
	set_transient( 'rawlaw_trust_stats', $stats, HOUR_IN_SECONDS );
}

$items = array(
	array( 'icon' => 'verified', 'count' => $stats['areas'],    'label' => __( 'Practice Areas Covered', 'rawlaw' ) ),
	array( 'icon' => 'globe',    'count' => $stats['articles'], 'label' => __( 'Articles Published', 'rawlaw' ) ),
);
?>
<div class="stats-strip" data-reveal>
	<div class="container stats-strip__inner">
		<?php foreach ( $items as $item ) : ?>
			<?php if ( $item['count'] < 1 ) { continue; } ?>
			<div class="stats-strip__item">
				<span class="stats-strip__icon"><?php rawlaw_icon( $item['icon'] ); ?></span>
				<div class="stats-strip__text">
					<span class="stats-strip__num"><?php echo esc_html( number_format_i18n( $item['count'] ) . '+' ); ?></span>
					<span class="stats-strip__label"><?php echo esc_html( $item['label'] ); ?></span>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

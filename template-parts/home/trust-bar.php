<?php
/**
 * Trust stats strip — prominent numbers with icons.
 *
 * Numbers are cached via transient for 1 hour.
 *
 * @package RawLaw
 */

$stats = get_transient( 'rawlaw_trust_stats' );
if ( false === $stats ) {
	$lawyer_count  = wp_count_posts( 'lawyer' );
	$article_count = wp_count_posts( 'post' );
	$practice_areas = wp_count_terms( array( 'taxonomy' => 'practice_area', 'hide_empty' => true ) );
	$locations      = wp_count_terms( array( 'taxonomy' => 'lawyer_location', 'hide_empty' => true ) );

	$stats = array(
		'lawyers'   => is_object( $lawyer_count ) ? (int) $lawyer_count->publish : 0,
		'areas'     => is_wp_error( $practice_areas ) ? 0 : (int) $practice_areas,
		'cities'    => is_wp_error( $locations ) ? 0 : (int) $locations,
		'articles'  => is_object( $article_count ) ? (int) $article_count->publish : 0,
	);
	set_transient( 'rawlaw_trust_stats', $stats, HOUR_IN_SECONDS );
}

$lawyers  = $stats['lawyers']  > 10  ? number_format_i18n( $stats['lawyers'] )  . '+' : '10,000+';
$cities   = $stats['cities']   > 5   ? number_format_i18n( $stats['cities'] )   . '+' : '500+';

$items = array(
	array( 'icon' => 'user',     'num' => $lawyers,       'label' => __( 'Verified Lawyers', 'rawlaw' ) ),
	array( 'icon' => 'verified', 'num' => '2,00,000+',    'label' => __( 'Happy Clients', 'rawlaw' ) ),
	array( 'icon' => 'pin',      'num' => $cities,         'label' => __( 'Cities Covered', 'rawlaw' ) ),
	array( 'icon' => 'globe',    'num' => '4.8/5',         'label' => __( 'Average Rating', 'rawlaw' ) ),
	array( 'icon' => 'clock',    'num' => '24/7',          'label' => __( 'Support Available', 'rawlaw' ) ),
);
?>
<div class="stats-strip" data-reveal>
	<div class="container stats-strip__inner">
		<?php foreach ( $items as $item ) : ?>
			<div class="stats-strip__item">
				<span class="stats-strip__icon"><?php rawlaw_icon( $item['icon'] ); ?></span>
				<div class="stats-strip__text">
					<span class="stats-strip__num"><?php echo esc_html( $item['num'] ); ?></span>
					<span class="stats-strip__label"><?php echo esc_html( $item['label'] ); ?></span>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

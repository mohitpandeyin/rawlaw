<?php
/**
 * Section — FAQs with FAQPage JSON-LD schema.
 *
 * Answers the 6 most common questions about using RawLaw.
 * FAQPage schema boosts Google rich result eligibility.
 *
 * @package RawLaw
 */

$faq_content = rawlaw_home_get( 'faq', array() );
$faqs        = isset( $faq_content['items'] ) && is_array( $faq_content['items'] ) ? $faq_content['items'] : array();

// Output FAQPage JSON-LD schema.
$faq_schema = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array(),
);
foreach ( $faqs as $faq ) {
	$faq_schema['mainEntity'][] = array(
		'@type'          => 'Question',
		'name'           => $faq['q'],
		'acceptedAnswer' => array(
			'@type' => 'Answer',
			'text'  => $faq['a'],
		),
	);
}
?>
<script type="application/ld+json"><?php echo wp_json_encode( $faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>

<section class="section section--faq" aria-labelledby="faq-heading" data-reveal>
	<div class="container">
		<header class="section__header section__header--centered">
			<p class="section__eyebrow"><?php echo esc_html( $faq_content['eyebrow'] ); ?></p>
			<h2 id="faq-heading" class="section__title"><?php echo esc_html( $faq_content['title'] ); ?></h2>
			<p class="section__sub"><?php echo esc_html( $faq_content['subtitle'] ); ?></p>
		</header>

		<div class="faq-list" data-reveal-stagger>
			<?php foreach ( $faqs as $i => $faq ) :
				$item_id = 'faq-answer-' . ( $i + 1 );
			?>
			<div class="faq-item">
				<button class="faq-item__question" aria-expanded="false" aria-controls="<?php echo esc_attr( $item_id ); ?>"
					<?php if ( ! rawlaw_is_amp() ) : ?>data-faq-toggle<?php endif; ?>>
					<span><?php echo esc_html( $faq['q'] ); ?></span>
					<span class="faq-item__chevron" aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
					</span>
				</button>
				<div class="faq-item__answer" id="<?php echo esc_attr( $item_id ); ?>" hidden>
					<p><?php echo esc_html( $faq['a'] ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

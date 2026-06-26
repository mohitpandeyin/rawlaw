<?php
/**
 * Section — FAQs with FAQPage JSON-LD schema.
 *
 * Answers the 6 most common questions about using RawLaw.
 * FAQPage schema boosts Google rich result eligibility.
 *
 * @package RawLaw
 */

$faqs = array(
	array(
		'q' => __( 'Is it free to post a legal query on RawLaw?', 'rawlaw' ),
		'a' => __( 'Yes. Posting a query on RawLaw is free. You describe your issue and can review responses from verified advocates before deciding whether to book a consultation.', 'rawlaw' ),
	),
	array(
		'q' => __( 'How are lawyers verified on RawLaw?', 'rawlaw' ),
		'a' => __( 'Every lawyer on RawLaw is required to submit their Bar Council enrollment number and identity documents. Our team manually verifies each profile before it is listed on the platform.', 'rawlaw' ),
	),
	array(
		'q' => __( 'Can I find a lawyer for a specific city or court?', 'rawlaw' ),
		'a' => __( 'Yes. You can search for lawyers by city, state, or the court where your matter is filed. RawLaw covers all major High Courts and District Courts across India.', 'rawlaw' ),
	),
	array(
		'q' => __( 'What types of legal matters does RawLaw cover?', 'rawlaw' ),
		'a' => __( 'RawLaw covers a wide range of legal services including property disputes, family law, criminal cases, consumer complaints, labour matters, civil litigation, corporate law, GST, cheque bounce, and more.', 'rawlaw' ),
	),
	array(
		'q' => __( 'How quickly will I hear from a lawyer after posting a query?', 'rawlaw' ),
		'a' => __( 'Response time depends on the issue, city, urgency and lawyer availability. Urgent matters should be marked clearly so relevant advocates can prioritize them.', 'rawlaw' ),
	),
	array(
		'q' => __( 'Is my legal query and personal data kept confidential?', 'rawlaw' ),
		'a' => __( 'Absolutely. Your query details are only visible to lawyers on the platform and are never publicly listed. RawLaw follows strict data privacy practices and does not sell or share your personal information.', 'rawlaw' ),
	),
);

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
			<p class="section__eyebrow"><?php esc_html_e( 'FAQs', 'rawlaw' ); ?></p>
			<h2 id="faq-heading" class="section__title"><?php esc_html_e( 'Common Questions Answered', 'rawlaw' ); ?></h2>
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

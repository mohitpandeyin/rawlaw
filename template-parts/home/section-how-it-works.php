<?php
/**
 * Section — How RawLaw.in Works (4-step SaaS-style flow).
 *
 * @package RawLaw
 */

$steps = array(
	array(
		'num'   => '1',
		'title' => __( 'Post the issue', 'rawlaw' ),
		'desc'  => __( 'Start with a one-line issue, then share the matter, city, urgency, and preferred contact route.', 'rawlaw' ),
		'svg'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.5 14.25V11.625C19.5 9.76104 17.989 8.25 16.125 8.25H14.625C14.0037 8.25 13.5 7.74632 13.5 7.125V5.625C13.5 3.76104 11.989 2.25 10.125 2.25H8.25M13.4812 15.7312L15 17.25M10.5 2.25H5.625C5.00368 2.25 4.5 2.75368 4.5 3.375V19.875C4.5 20.4963 5.00368 21 5.625 21H18.375C18.9963 21 19.5 20.4963 19.5 19.875V11.25C19.5 6.27944 15.4706 2.25 10.5 2.25ZM14.25 13.875C14.25 15.3247 13.0747 16.5 11.625 16.5C10.1753 16.5 9 15.3247 9 13.875C9 12.4253 10.1753 11.25 11.625 11.25C13.0747 11.25 14.25 12.4253 14.25 13.875Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	),
	array(
		'num'   => '2',
		'title' => __( 'RawLaw captures context', 'rawlaw' ),
		'desc'  => __( 'Your details stay structured and private so the matter can be routed with the right context.', 'rawlaw' ),
		'svg'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 9H18.75M15 12H18.75M15 15H18.75M4.5 19.5H19.5C20.7426 19.5 21.75 18.4926 21.75 17.25V6.75C21.75 5.50736 20.7426 4.5 19.5 4.5H4.5C3.25736 4.5 2.25 5.50736 2.25 6.75V17.25C2.25 18.4926 3.25736 19.5 4.5 19.5ZM10.5 9.375C10.5 10.4105 9.66053 11.25 8.625 11.25C7.58947 11.25 6.75 10.4105 6.75 9.375C6.75 8.33947 7.58947 7.5 8.625 7.5C9.66053 7.5 10.5 8.33947 10.5 9.375ZM11.7939 15.7114C10.8489 16.2147 9.77021 16.5 8.62484 16.5C7.47948 16.5 6.40074 16.2147 5.45581 15.7114C5.92986 14.4207 7.16983 13.5 8.62484 13.5C10.0799 13.5 11.3198 14.4207 11.7939 15.7114Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	),
	array(
		'num'   => '3',
		'title' => __( 'Match to verified advocates', 'rawlaw' ),
		'desc'  => __( 'Review verified profiles by city, practice area, experience, and relevance before engaging.', 'rawlaw' ),
		'svg'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3V20.25M12 20.25C10.528 20.25 9.1179 20.515 7.81483 21M12 20.25C13.472 20.25 14.8821 20.515 16.1852 21M18.75 4.97089C16.5446 4.66051 14.291 4.5 12 4.5C9.70897 4.5 7.45542 4.66051 5.25 4.97089M18.75 4.97089C19.7604 5.1131 20.7608 5.28677 21.75 5.49087M18.75 4.97089L21.3704 15.6961C21.4922 16.1948 21.2642 16.7237 20.7811 16.8975C20.1468 17.1257 19.4629 17.25 18.75 17.25C18.0371 17.25 17.3532 17.1257 16.7189 16.8975C16.2358 16.7237 16.0078 16.1948 16.1296 15.6961L18.75 4.97089ZM2.25 5.49087C3.23922 5.28677 4.23956 5.1131 5.25 4.97089M5.25 4.97089L7.87036 15.6961C7.9922 16.1948 7.76419 16.7237 7.28114 16.8975C6.6468 17.1257 5.96292 17.25 5.25 17.25C4.53708 17.25 3.8532 17.1257 3.21886 16.8975C2.73581 16.7237 2.5078 16.1948 2.62964 15.6961L5.25 4.97089Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	),
	array(
		'num'   => '4',
		'title' => __( 'Move only when ready', 'rawlaw' ),
		'desc'  => __( 'Compare options, ask follow-up questions, then decide whether to consult.', 'rawlaw' ),
		'svg'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 12.7498L11.25 14.9998L15 9.74985M12 2.71411C9.8495 4.75073 6.94563 5.99986 3.75 5.99986C3.69922 5.99986 3.64852 5.99955 3.59789 5.99892C3.2099 7.17903 3 8.43995 3 9.74991C3 15.3414 6.82432 20.0397 12 21.3719C17.1757 20.0397 21 15.3414 21 9.74991C21 8.43995 20.7901 7.17903 20.4021 5.99892C20.3515 5.99955 20.3008 5.99986 20.25 5.99986C17.0544 5.99986 14.1505 4.75073 12 2.71411Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	),
);
?>
<section class="section section--alt section--how-it-works" aria-labelledby="hiw-heading" data-reveal>
	<div class="container">
		<header class="section__header section__header--centered">
			<p class="section__eyebrow"><?php esc_html_e( 'How it works', 'rawlaw' ); ?></p>
			<h2 id="hiw-heading" class="section__title"><?php esc_html_e( 'From query to qualified legal help', 'rawlaw' ); ?></h2>
			<p class="section__sub"><?php esc_html_e( 'A structured intake flow gives citizens clarity and gives advocates the context they need before responding.', 'rawlaw' ); ?></p>
		</header>

		<div class="how-it-works" data-reveal-stagger>
			<?php foreach ( $steps as $step ) : ?>
			<div class="how-step">
				<div class="how-step__icon">
					<span class="how-step__num" aria-hidden="true"><?php echo esc_html( $step['num'] ); ?></span>
					<span class="how-step__icon-svg" aria-hidden="true"><?php echo $step['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</div>
				<div class="how-step__text">
					<h3 class="how-step__title"><?php echo esc_html( $step['title'] ); ?></h3>
					<p class="how-step__desc"><?php echo esc_html( $step['desc'] ); ?></p>
				</div>
			</div>
			<?php endforeach; ?>
		</div>

		<div class="how-it-works__cta">
			<a class="btn btn--primary btn--lg" href="<?php echo esc_url( home_url( '/#rawlaw-hero-query-wizard' ) ); ?>">
				<?php esc_html_e( 'Start with your query — it\'s free', 'rawlaw' ); ?>
				<svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
			</a>
		</div>
	</div>
</section>

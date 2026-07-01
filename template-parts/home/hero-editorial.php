<?php
/**
 * Hero — minimal legal assistance intake with top news on right.
 *
 * Left column: essential headline, one intake field, one assistance CTA.
 * Right column: Top News section with important legal articles.
 *
 * @package RawLaw
 */

$fallback_action = esc_url( 'https://app.rawlaw.in/register/client' );
$popular = rawlaw_home_get( 'hero.popular', array() );

?>

<div class="hero__inner">
	<!-- Left: content -->
	<div class="hero__left">
		<header class="hero__lede">
			<h1 class="hero__headline">
				<span class="hero__headline-line"><?php echo esc_html( rawlaw_home_get( 'hero.headline_line' ) ); ?></span>
				<span class="hero__headline-accent"><?php echo esc_html( rawlaw_home_get( 'hero.headline_accent' ) ); ?></span>
			</h1>
			<p class="hero__subtitle">
				<?php echo esc_html( rawlaw_home_get( 'hero.subtitle' ) ); ?>
			</p>
		</header>

		<form class="hero__finder hero-intake" action="<?php echo $fallback_action; ?>" method="get" data-query-modal-trigger>
			<div class="hero__finder-row">
				<label class="hero__finder-field">
					<span class="hero__finder-icon" aria-hidden="true"><?php rawlaw_icon( 'chat' ); ?></span>
					<span class="hero__finder-label"><?php esc_html_e( 'Legal issue', 'rawlaw' ); ?></span>
					<input
						class="hero__finder-input"
						type="text"
						name="intent"
						data-hero-query-intent
						placeholder="<?php echo esc_attr( rawlaw_home_get( 'hero.placeholder' ) ); ?>"
						autocomplete="off"
					>
				</label>
				<button class="hero__finder-btn" type="submit">
					<?php echo esc_html( rawlaw_home_get( 'hero.button' ) ); ?>
					<svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
				</button>
			</div>
		</form>

		<div class="hero__quick-actions">
			<div class="hero__chips" aria-label="<?php esc_attr_e( 'Popular legal issues', 'rawlaw' ); ?>">
				<span class="hero__chips-label"><?php echo esc_html( rawlaw_home_get( 'hero.popular_label' ) ); ?></span>
				<?php foreach ( $popular as $item ) : ?>
					<button class="hero__chip" type="button" data-query-preset data-preset-area="<?php echo esc_attr( $item['area'] ); ?>" data-preset-details="<?php echo esc_attr( $item['details'] ); ?>">
						<?php echo esc_html( $item['label'] ); ?>
					</button>
				<?php endforeach; ?>
			</div>
			<p class="hero__alt">
				<?php echo esc_html( rawlaw_home_get( 'hero.lawyer_prompt' ) ); ?>
				<a href="<?php echo esc_url( rawlaw_home_get( 'hero.lawyer_link_url' ) ); ?>" target="_blank" rel="noopener">
					<?php echo esc_html( rawlaw_home_get( 'hero.lawyer_link_text' ) ); ?>
					<span aria-hidden="true">&rarr;</span>
				</a>
			</p>
		</div>
	</div>

	<!-- Right: Top News -->
	<div class="hero__right">
		<?php get_template_part( 'template-parts/home/hero-top-news' ); ?>
	</div>
</div>

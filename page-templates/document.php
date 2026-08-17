<?php
/**
 * Template Name: Document (auto contents)
 * Template Post Type: page
 *
 * Long-form static document — About, Editorial Policy, and anything else of
 * the same shape. Reuses the `.legal-page` / `.legal-toc` styling that the
 * Privacy, Terms and Refund templates already share, but builds its table of
 * contents from the content's own headings instead of a hardcoded list.
 *
 * That is the whole reason this file exists. Those three templates each
 * hardcode their TOC — 12, 14 and 12 `<a href="#…">` links respectively, tied
 * to their own `#pp-*` / `#tc-*` anchors. Pointing the About page at the
 * Privacy Policy template would therefore render a dozen dead links, and
 * adding a fourth hardcoded copy for every new page does not scale. Here the
 * list comes from `rawlaw_build_toc()`, the parser the article template
 * already uses, so a page's contents cannot drift out of sync with its
 * headings.
 *
 * Degrades on purpose: fewer than three headings and the TOC is dropped
 * entirely (`rawlaw_build_toc()`'s own threshold — a two-section page does
 * not need one), with `--full` collapsing the grid to a single column so the
 * prose does not render inside the 240px sidebar track.
 *
 * @package RawLaw
 */

get_header();

while ( have_posts() ) :
	the_post();

	// Filters run once here, then the result is echoed — calling
	// the_content() below as well would run every filter a second time.
	$content = apply_filters( 'the_content', get_the_content() );
	$toc     = rawlaw_build_toc( $content );
	$items   = ! empty( $toc['items'] ) ? $toc['items'] : array();
	$content = $toc['content'];
	$updated = get_post_meta( get_the_ID(), '_rawlaw_last_updated', true ) ?: get_the_modified_date( 'j F Y' );
	?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'legal-page' ); ?> aria-labelledby="legal-page-title">

	<header class="legal-page__header" data-reveal>
		<div class="container">
			<?php rawlaw_breadcrumbs(); ?>
			<h1 id="legal-page-title" class="legal-page__title"><?php the_title(); ?></h1>
			<p class="legal-page__meta">
				<?php
				printf(
					/* translators: %s: last updated date */
					esc_html__( 'Last updated: %s', 'rawlaw' ),
					'<time datetime="' . esc_attr( get_the_modified_date( 'Y-m-d' ) ) . '">' . esc_html( $updated ) . '</time>'
				);
				?>
			</p>
		</div>
	</header>

	<div class="legal-page__body container<?php echo $items ? '' : ' legal-page__body--full'; ?>" data-reveal>
		<?php if ( $items ) : ?>
			<aside class="legal-page__toc" aria-label="<?php esc_attr_e( 'Table of contents', 'rawlaw' ); ?>">
				<div class="legal-toc">
					<p class="legal-toc__heading"><?php esc_html_e( 'Contents', 'rawlaw' ); ?></p>
					<nav>
						<ol class="legal-toc__list">
							<?php foreach ( $items as $item ) : ?>
								<li class="legal-toc__item legal-toc__item--lvl-<?php echo (int) $item['level']; ?>"><a href="#<?php echo esc_attr( $item['slug'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a></li>
							<?php endforeach; ?>
						</ol>
					</nav>
				</div>
			</aside>
		<?php endif; ?>

		<div class="legal-page__content prose">
			<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput -- already through the_content filters. ?>
		</div>
	</div>

	<div class="legal-page__cta" data-reveal>
		<div class="container">
			<p><?php esc_html_e( 'Questions, or something we got wrong? We want to hear about it.', 'rawlaw' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'rawlaw' ); ?></a>
		</div>
	</div>

</article>

	<?php
endwhile;

get_footer();

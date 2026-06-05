<?php
/**
 * Single article — clean editorial reading view, schema-ready, with TOC.
 *
 * @package RawLaw
 */
get_header(); ?>

<?php while ( have_posts() ) : the_post();
	$content = apply_filters( 'the_content', get_the_content() );
	$toc     = rawlaw_build_toc( $content );
	$tags    = get_the_tags();
	$categories = get_the_category();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?>>

	<header class="article__header">
		<div class="container">
			<?php rawlaw_category_eyebrow(); ?>
			<h1 class="article__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="article__dek"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<?php rawlaw_article_meta( array( 'show_avatar' => true, 'show_read' => true ) ); ?>
		</div>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="article__featured">
				<?php the_post_thumbnail( 'rawlaw-hero', array( 'fetchpriority' => 'high', 'decoding' => 'async' ) ); ?>
				<?php $caption = get_the_post_thumbnail_caption(); if ( $caption ) : ?>
					<figcaption><?php echo esc_html( $caption ); ?></figcaption>
				<?php endif; ?>
			</figure>
		<?php endif; ?>
	</header>

	<div class="article__layout container">
		<div class="article__rail article__rail--start" aria-hidden="false">
			<?php if ( $toc['html'] ) echo $toc['html']; ?>
			<div class="share" aria-label="<?php esc_attr_e( 'Share this article', 'rawlaw' ); ?>">
				<p class="share__label"><?php esc_html_e( 'Share', 'rawlaw' ); ?></p>
				<ul>
					<li><a class="icon-btn" rel="noopener" target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>" aria-label="<?php esc_attr_e( 'Share on X', 'rawlaw' ); ?>"><?php rawlaw_icon( 'twitter' ); ?></a></li>
					<li><a class="icon-btn" rel="noopener" target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo rawurlencode( get_permalink() ); ?>" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'rawlaw' ); ?>"><?php rawlaw_icon( 'linkedin' ); ?></a></li>
					<li><a class="icon-btn" rel="noopener" target="_blank" href="https://api.whatsapp.com/send?text=<?php echo rawurlencode( get_the_title() . ' ' . get_permalink() ); ?>" aria-label="<?php esc_attr_e( 'Share on WhatsApp', 'rawlaw' ); ?>"><?php rawlaw_icon( 'whatsapp' ); ?></a></li>
					<li><button type="button" class="icon-btn" data-copy-link data-url="<?php echo esc_attr( get_permalink() ); ?>" aria-label="<?php esc_attr_e( 'Copy link', 'rawlaw' ); ?>"><?php rawlaw_icon( 'link' ); ?></button></li>
				</ul>
			</div>
		</div>

		<div class="article__main">
			<div class="prose"><?php echo $toc['content']; // already filtered through the_content ?></div>

			<?php if ( $tags ) : ?>
				<ul class="tag-list tag-list--lg" aria-label="<?php esc_attr_e( 'Article tags', 'rawlaw' ); ?>">
					<?php foreach ( $tags as $tag ) : ?>
						<li><a class="tag" href="<?php echo esc_url( get_tag_link( $tag ) ); ?>">#<?php echo esc_html( $tag->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/components/author-bio' ); ?>
		</div>
	</div>

</article>

<?php get_template_part( 'template-parts/article/related' ); ?>

<?php if ( comments_open() || get_comments_number() ) : ?>
	<section class="container container--prose">
		<?php comments_template(); ?>
	</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>

<?php
/**
 * Lawyer card — marketplace listing.
 *
 * @package RawLaw
 */
$id           = get_the_ID();
$designation  = get_post_meta( $id, '_rawlaw_designation', true );
$firm         = get_post_meta( $id, '_rawlaw_firm', true );
$experience   = (int) get_post_meta( $id, '_rawlaw_experience', true );
$consultation = get_post_meta( $id, '_rawlaw_consultation', true );
$languages    = get_post_meta( $id, '_rawlaw_languages', true );
$practice     = get_the_terms( $id, 'practice_area' );
$location     = get_the_terms( $id, 'lawyer_location' );
$rating       = rawlaw_lawyer_rating( $id );
?>
<article id="lawyer-<?php echo (int) $id; ?>" <?php post_class( 'lawyer-card' ); ?> data-reveal>
	<header class="lawyer-card__head">
		<a class="lawyer-card__photo" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'rawlaw-square', array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) );
			} else {
				echo '<span class="lawyer-card__initials">' . esc_html( mb_substr( get_the_title(), 0, 1 ) ) . '</span>';
			}
			?>
		</a>
		<div class="lawyer-card__intro">
			<h3 class="lawyer-card__name">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<?php rawlaw_verified_badge( $id ); ?>
			</h3>
			<?php if ( $designation || $firm ) : ?>
				<p class="lawyer-card__role">
					<?php echo esc_html( trim( $designation . ( $firm ? ' · ' . $firm : '' ), ' ·' ) ); ?>
				</p>
			<?php endif; ?>
			<?php if ( $rating ) : ?>
				<p class="lawyer-card__rating" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %1$s out of 5 from %2$d reviews', 'rawlaw' ), $rating['avg'], $rating['count'] ) ); ?>">
					<span class="stars" style="--r:<?php echo esc_attr( $rating['avg'] ); ?>" aria-hidden="true">★★★★★</span>
					<strong><?php echo esc_html( $rating['avg'] ); ?></strong>
					<span class="muted">(<?php echo (int) $rating['count']; ?>)</span>
				</p>
			<?php endif; ?>
		</div>
	</header>

	<dl class="lawyer-card__facts">
		<?php if ( $experience ) : ?>
			<div><dt><?php esc_html_e( 'Experience', 'rawlaw' ); ?></dt><dd><?php printf( esc_html( _n( '%d year', '%d years', $experience, 'rawlaw' ) ), $experience ); ?></dd></div>
		<?php endif; ?>
		<?php if ( $location && ! is_wp_error( $location ) ) : ?>
			<div><dt><?php esc_html_e( 'Location', 'rawlaw' ); ?></dt><dd><?php echo esc_html( $location[0]->name ); ?></dd></div>
		<?php endif; ?>
		<?php if ( $consultation ) : ?>
			<div><dt><?php esc_html_e( 'Consult fee', 'rawlaw' ); ?></dt><dd>₹<?php echo esc_html( number_format_i18n( (int) $consultation ) ); ?></dd></div>
		<?php endif; ?>
		<?php if ( $languages ) : ?>
			<div><dt><?php esc_html_e( 'Languages', 'rawlaw' ); ?></dt><dd><?php echo esc_html( $languages ); ?></dd></div>
		<?php endif; ?>
	</dl>

	<?php if ( $practice && ! is_wp_error( $practice ) ) : ?>
		<ul class="tag-list" aria-label="<?php esc_attr_e( 'Practice areas', 'rawlaw' ); ?>">
			<?php foreach ( array_slice( $practice, 0, 4 ) as $term ) : ?>
				<li><a class="tag" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<div class="lawyer-card__cta">
		<a class="btn btn--primary btn--sm" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View profile', 'rawlaw' ); ?></a>
		<a class="btn btn--ghost btn--sm" href="<?php echo esc_url( add_query_arg( 'consult', $id, get_permalink() ) ); ?>#consult"><?php esc_html_e( 'Request consultation', 'rawlaw' ); ?></a>
	</div>
</article>

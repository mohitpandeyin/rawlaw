<?php
/**
 * Single lawyer profile — premium marketplace profile page.
 *
 * @package RawLaw
 */
get_header(); while ( have_posts() ) : the_post();
	$id           = get_the_ID();
	$designation  = get_post_meta( $id, '_rawlaw_designation', true );
	$firm         = get_post_meta( $id, '_rawlaw_firm', true );
	$experience   = (int) get_post_meta( $id, '_rawlaw_experience', true );
	$bar_id       = get_post_meta( $id, '_rawlaw_bar_id', true );
	$languages    = get_post_meta( $id, '_rawlaw_languages', true );
	$email        = get_post_meta( $id, '_rawlaw_email', true );
	$phone        = get_post_meta( $id, '_rawlaw_phone', true );
	$website      = get_post_meta( $id, '_rawlaw_website', true );
	$consultation = get_post_meta( $id, '_rawlaw_consultation', true );
	$accepting    = get_post_meta( $id, '_rawlaw_accepting', true );
	$practice     = get_the_terms( $id, 'practice_area' );
	$location     = get_the_terms( $id, 'lawyer_location' );
	$rating       = rawlaw_lawyer_rating( $id );
?>

<article id="lawyer-<?php echo (int) $id; ?>" <?php post_class( 'lawyer-profile' ); ?>>

	<header class="lawyer-profile__hero">
		<div class="container lawyer-profile__hero-inner">
			<div class="lawyer-profile__photo">
				<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'rawlaw-square', array( 'fetchpriority' => 'high', 'decoding' => 'async', 'alt' => '' ) );
				else : ?>
					<span class="lawyer-card__initials lawyer-card__initials--lg" aria-hidden="true"><?php echo esc_html( mb_substr( get_the_title(), 0, 1 ) ); ?></span>
				<?php endif; ?>
			</div>

			<div class="lawyer-profile__intro">
				<p class="eyebrow">
					<?php echo esc_html( $designation ?: __( 'Advocate', 'rawlaw' ) ); ?>
					<?php rawlaw_verified_badge( $id ); ?>
				</p>
				<h1 class="lawyer-profile__name"><?php the_title(); ?></h1>
				<?php if ( $firm ) : ?>
					<p class="lawyer-profile__firm"><?php echo esc_html( $firm ); ?></p>
				<?php endif; ?>

				<ul class="lawyer-profile__meta">
					<?php if ( $experience ) : ?>
						<li><strong><?php echo (int) $experience; ?>+</strong> <?php esc_html_e( 'years experience', 'rawlaw' ); ?></li>
					<?php endif; ?>
					<?php if ( $location && ! is_wp_error( $location ) ) : ?>
						<li><?php rawlaw_icon( 'pin' ); ?> <?php echo esc_html( $location[0]->name ); ?></li>
					<?php endif; ?>
					<?php if ( $languages ) : ?>
						<li><?php rawlaw_icon( 'globe' ); ?> <?php echo esc_html( $languages ); ?></li>
					<?php endif; ?>
					<?php if ( $rating ) : ?>
						<li>
							<span class="stars" style="--r:<?php echo esc_attr( $rating['avg'] ); ?>" aria-hidden="true">★★★★★</span>
							<strong><?php echo esc_html( $rating['avg'] ); ?></strong>
							<a href="#reviews" class="muted">(<?php printf( esc_html( _n( '%d review', '%d reviews', $rating['count'], 'rawlaw' ) ), $rating['count'] ); ?>)</a>
						</li>
					<?php endif; ?>
				</ul>

				<?php if ( $practice && ! is_wp_error( $practice ) ) : ?>
					<ul class="tag-list">
						<?php foreach ( $practice as $term ) : ?>
							<li><a class="tag" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<aside class="lawyer-profile__cta">
				<?php if ( $consultation ) : ?>
					<p class="lawyer-profile__price"><span><?php esc_html_e( 'Consultation from', 'rawlaw' ); ?></span><strong>₹<?php echo esc_html( number_format_i18n( (int) $consultation ) ); ?></strong></p>
				<?php endif; ?>
				<?php if ( $accepting ) : ?>
					<p class="badge badge--ok"><?php esc_html_e( 'Accepting new clients', 'rawlaw' ); ?></p>
				<?php else : ?>
					<p class="badge badge--muted"><?php esc_html_e( 'Limited availability', 'rawlaw' ); ?></p>
				<?php endif; ?>
				<a class="btn btn--primary btn--block" href="#consult"><?php esc_html_e( 'Request consultation', 'rawlaw' ); ?></a>
				<?php if ( $phone ) : ?>
					<a class="btn btn--ghost btn--block" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php esc_html_e( 'Call', 'rawlaw' ); ?> <?php echo esc_html( $phone ); ?></a>
				<?php endif; ?>
				<p class="muted xs"><?php esc_html_e( 'Your enquiry is shared only with this lawyer.', 'rawlaw' ); ?></p>
			</aside>
		</div>
	</header>

	<div class="container lawyer-profile__layout">
		<div class="lawyer-profile__main">
			<section class="lawyer-profile__section">
				<h2 class="section__title"><?php esc_html_e( 'About', 'rawlaw' ); ?></h2>
				<div class="prose"><?php the_content(); ?></div>
			</section>

			<section class="lawyer-profile__section">
				<h2 class="section__title"><?php esc_html_e( 'Practice areas', 'rawlaw' ); ?></h2>
				<?php if ( $practice && ! is_wp_error( $practice ) ) : ?>
					<ul class="practice-grid">
						<?php foreach ( $practice as $term ) : ?>
							<li><a href="<?php echo esc_url( get_term_link( $term ) ); ?>"><strong><?php echo esc_html( $term->name ); ?></strong><?php if ( $term->description ) echo '<small>' . esc_html( wp_trim_words( $term->description, 14 ) ) . '</small>'; ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</section>

			<section id="consult" class="lawyer-profile__section consult">
				<h2 class="section__title"><?php esc_html_e( 'Request a consultation', 'rawlaw' ); ?></h2>
				<p class="muted"><?php esc_html_e( 'Share a brief description of your matter. The lawyer will respond within 48 hours.', 'rawlaw' ); ?></p>
				<form class="consult__form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" <?php if ( rawlaw_is_amp() ) { echo 'action-xhr="' . esc_url( admin_url( 'admin-post.php' ) ) . '" target="_top"'; } ?>>
					<?php wp_nonce_field( 'rawlaw_consult', 'rawlaw_consult_nonce' ); ?>
					<input type="hidden" name="action" value="rawlaw_consult">
					<input type="hidden" name="lawyer_id" value="<?php echo (int) $id; ?>">

					<div class="form-grid">
						<label><span><?php esc_html_e( 'Your name', 'rawlaw' ); ?></span><input type="text" name="name" required></label>
						<label><span><?php esc_html_e( 'Email', 'rawlaw' ); ?></span><input type="email" name="email" required></label>
						<label><span><?php esc_html_e( 'Phone', 'rawlaw' ); ?></span><input type="tel" name="phone"></label>
						<label><span><?php esc_html_e( 'City', 'rawlaw' ); ?></span><input type="text" name="city"></label>
					</div>
					<label><span><?php esc_html_e( 'Brief description of your legal matter', 'rawlaw' ); ?></span><textarea name="message" rows="5" required></textarea></label>
					<label class="checkbox"><input type="checkbox" required> <span><?php esc_html_e( 'I understand RawLaw does not provide legal advice and is not party to this engagement.', 'rawlaw' ); ?></span></label>
					<button type="submit" class="btn btn--primary"><?php esc_html_e( 'Send enquiry', 'rawlaw' ); ?></button>
				</form>
			</section>

			<section id="reviews" class="lawyer-profile__section">
				<h2 class="section__title"><?php esc_html_e( 'Reviews', 'rawlaw' ); ?></h2>
				<?php comments_template(); ?>
			</section>
		</div>

		<aside class="lawyer-profile__rail">
			<section class="card-info">
				<h3><?php esc_html_e( 'Credentials', 'rawlaw' ); ?></h3>
				<dl>
					<?php if ( $bar_id ) : ?><div><dt><?php esc_html_e( 'Bar Council ID', 'rawlaw' ); ?></dt><dd><?php echo esc_html( $bar_id ); ?></dd></div><?php endif; ?>
					<?php if ( $experience ) : ?><div><dt><?php esc_html_e( 'Experience', 'rawlaw' ); ?></dt><dd><?php printf( esc_html( _n( '%d year', '%d years', $experience, 'rawlaw' ) ), $experience ); ?></dd></div><?php endif; ?>
					<?php if ( $email ) : ?><div><dt><?php esc_html_e( 'Email', 'rawlaw' ); ?></dt><dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></dd></div><?php endif; ?>
					<?php if ( $website ) : ?><div><dt><?php esc_html_e( 'Website', 'rawlaw' ); ?></dt><dd><a href="<?php echo esc_url( $website ); ?>" rel="noopener" target="_blank"><?php echo esc_html( wp_parse_url( $website, PHP_URL_HOST ) ); ?></a></dd></div><?php endif; ?>
				</dl>
			</section>
			<?php if ( is_active_sidebar( 'sidebar-marketplace' ) ) dynamic_sidebar( 'sidebar-marketplace' ); ?>
		</aside>
	</div>
</article>

<?php endwhile; get_footer(); ?>

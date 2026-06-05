<?php
/**
 * Marketplace filters — practice area, location, experience, verified.
 *
 * @package RawLaw
 */
$current_practice = isset( $_GET['practice'] ) ? (array) $_GET['practice'] : array();
$current_location = isset( $_GET['location'] ) ? (array) $_GET['location'] : array();
$current_min_exp  = isset( $_GET['min_exp'] ) ? (int) $_GET['min_exp'] : 0;
$current_verified = ! empty( $_GET['verified'] );

$practice_areas = get_terms( array( 'taxonomy' => 'practice_area', 'hide_empty' => false ) );
$locations      = get_terms( array( 'taxonomy' => 'lawyer_location', 'hide_empty' => false ) );
$action         = get_post_type_archive_link( 'lawyer' );
?>
<aside class="filters" aria-label="<?php esc_attr_e( 'Filter lawyers', 'rawlaw' ); ?>">
	<form class="filters__form" method="get" action="<?php echo esc_url( $action ); ?>">
		<header class="filters__head">
			<h2 class="filters__title"><?php esc_html_e( 'Refine results', 'rawlaw' ); ?></h2>
			<a class="filters__reset" href="<?php echo esc_url( $action ); ?>"><?php esc_html_e( 'Reset', 'rawlaw' ); ?></a>
		</header>

		<details class="filters__group" open>
			<summary><?php esc_html_e( 'Practice area', 'rawlaw' ); ?></summary>
			<ul class="filters__options">
				<?php foreach ( $practice_areas as $term ) : ?>
					<li>
						<label>
							<input type="checkbox" name="practice[]" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( in_array( $term->slug, $current_practice, true ) ); ?>>
							<span><?php echo esc_html( $term->name ); ?></span>
							<small class="muted"><?php echo (int) $term->count; ?></small>
						</label>
					</li>
				<?php endforeach; ?>
			</ul>
		</details>

		<details class="filters__group" open>
			<summary><?php esc_html_e( 'Location', 'rawlaw' ); ?></summary>
			<ul class="filters__options">
				<?php foreach ( $locations as $term ) : ?>
					<li>
						<label>
							<input type="checkbox" name="location[]" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( in_array( $term->slug, $current_location, true ) ); ?>>
							<span><?php echo esc_html( $term->name ); ?></span>
							<small class="muted"><?php echo (int) $term->count; ?></small>
						</label>
					</li>
				<?php endforeach; ?>
			</ul>
		</details>

		<details class="filters__group">
			<summary><?php esc_html_e( 'Experience', 'rawlaw' ); ?></summary>
			<div class="filters__field">
				<label for="filter-min-exp"><?php esc_html_e( 'Minimum years', 'rawlaw' ); ?></label>
				<input id="filter-min-exp" type="number" name="min_exp" min="0" max="60" value="<?php echo esc_attr( $current_min_exp ?: '' ); ?>" placeholder="0">
			</div>
		</details>

		<label class="filters__check">
			<input type="checkbox" name="verified" value="1" <?php checked( $current_verified ); ?>>
			<span><?php esc_html_e( 'Verified by RawLaw only', 'rawlaw' ); ?></span>
		</label>

		<button type="submit" class="btn btn--primary btn--block"><?php esc_html_e( 'Apply filters', 'rawlaw' ); ?></button>
	</form>
</aside>

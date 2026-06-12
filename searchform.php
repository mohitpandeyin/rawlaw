<?php
/**
 * Search form.
 *
 * @package RawLaw
 */

$search_field_id = 'search-field-' . wp_unique_id();
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="search-form__label" for="<?php echo esc_attr( $search_field_id ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'Search RawLaw', 'rawlaw' ); ?></span>
	</label>
	<div class="search-form__field">
		<?php // SVG icon inline for fastest first paint. ?>
		<svg class="search-form__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
		<input
			type="search"
			id="<?php echo esc_attr( $search_field_id ); ?>"
			class="search-form__input"
			placeholder="<?php esc_attr_e( 'Search judgments, articles, lawyers…', 'rawlaw' ); ?>"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			name="s"
			autocomplete="off"
		>
		<button type="submit" class="search-form__submit">
			<span><?php esc_html_e( 'Search', 'rawlaw' ); ?></span>
		</button>
	</div>
</form>

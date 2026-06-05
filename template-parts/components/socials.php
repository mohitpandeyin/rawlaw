<?php
/**
 * Social links rendered from Customizer.
 *
 * @package RawLaw
 */
$socials = array(
	'twitter'  => array( 'X / Twitter', 'twitter' ),
	'linkedin' => array( 'LinkedIn',    'linkedin' ),
	'facebook' => array( 'Facebook',    'facebook' ),
	'youtube'  => array( 'YouTube',     'youtube' ),
	'instagram'=> array( 'Instagram',   'instagram' ),
);
$any = false;
foreach ( $socials as $key => $info ) { if ( get_theme_mod( 'rawlaw_social_' . $key ) ) { $any = true; break; } }
if ( ! $any ) { return; }
?>
<ul class="socials" aria-label="<?php esc_attr_e( 'Social media', 'rawlaw' ); ?>">
	<?php foreach ( $socials as $key => $info ) :
		$url = get_theme_mod( 'rawlaw_social_' . $key );
		if ( ! $url ) { continue; }
		?>
		<li>
			<a href="<?php echo esc_url( $url ); ?>" aria-label="<?php echo esc_attr( $info[0] ); ?>" rel="me noopener" target="_blank">
				<?php rawlaw_icon( $info[1] ); ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>

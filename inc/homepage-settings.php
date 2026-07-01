<?php
/**
 * Homepage content settings.
 *
 * @package RawLaw
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function rawlaw_home_default_content() {
	$asset_base = trailingslashit( get_template_directory_uri() ) . 'assets/media/home/';

	return array(
		'hero'      => array(
			'headline_line' => __( 'Understand the law.', 'rawlaw' ),
			'headline_accent' => __( 'Find verified legal help.', 'rawlaw' ),
			'subtitle' => __( 'Tell us what happened. We will ask for a few details next so relevant verified advocates can respond.', 'rawlaw' ),
			'placeholder' => __( 'e.g. Builder delayed possession, need legal notice...', 'rawlaw' ),
			'button' => __( 'Get Assistance', 'rawlaw' ),
			'popular_label' => __( 'Popular:', 'rawlaw' ),
			'lawyer_prompt' => __( 'Are you a lawyer?', 'rawlaw' ),
			'lawyer_link_text' => __( 'Register as an advocate', 'rawlaw' ),
			'lawyer_link_url' => 'https://app.rawlaw.in/register/lawyer',
			'popular' => array(
				array( 'label' => __( 'Bail', 'rawlaw' ), 'area' => 'criminal-law', 'details' => __( 'I need legal help for bail or an urgent criminal matter.', 'rawlaw' ) ),
				array( 'label' => __( 'Divorce', 'rawlaw' ), 'area' => 'family-law', 'details' => __( 'I need advice on divorce, maintenance, custody, or a related family matter.', 'rawlaw' ) ),
				array( 'label' => __( 'RERA', 'rawlaw' ), 'area' => 'property', 'details' => __( 'I need help with a builder delay, RERA complaint, or property dispute.', 'rawlaw' ) ),
				array( 'label' => __( 'Cheque Bounce', 'rawlaw' ), 'area' => 'criminal-law', 'details' => __( 'I need help with a cheque bounce notice or Section 138 matter.', 'rawlaw' ) ),
				array( 'label' => __( 'Consumer Complaint', 'rawlaw' ), 'area' => 'consumer-protection', 'details' => __( 'I want to file or respond to a consumer complaint.', 'rawlaw' ) ),
			),
		),
		'features'  => array(
			array( 'icon' => 'shield-checkmark', 'title' => __( 'Verified profiles', 'rawlaw' ) ),
			array( 'icon' => 'lock', 'title' => __( 'Private legal queries', 'rawlaw' ) ),
			array( 'icon' => 'news', 'title' => __( 'India-focused guidance', 'rawlaw' ) ),
			array( 'icon' => 'search', 'title' => __( 'Compare before consulting', 'rawlaw' ) ),
			array( 'icon' => 'chat', 'title' => __( 'Ask without pressure', 'rawlaw' ) ),
			array( 'icon' => 'user', 'title' => __( 'Advocate visibility', 'rawlaw' ) ),
		),
		'kyr'       => array(
			'eyebrow' => __( 'Know your rights', 'rawlaw' ),
			'title' => __( 'Not sure what your legal issue is called?', 'rawlaw' ),
			'subtitle' => __( 'Choose the situation closest to yours. RawLaw pre-fills the query wizard so you can explain the matter faster.', 'rawlaw' ),
			'visual_eyebrow' => __( 'Guided issue setup', 'rawlaw' ),
			'trust' => __( 'Pick the closest issue and RawLaw carries the context into the query form.', 'rawlaw' ),
			'issues' => array(
				array( 'title' => __( 'I am going through a divorce', 'rawlaw' ), 'sub' => __( 'Family law · Maintenance · Custody', 'rawlaw' ), 'area' => 'family-law', 'details' => __( 'I need advice on divorce, maintenance, custody, or a related family matter.', 'rawlaw' ), 'image' => $asset_base . 'kyr-family.svg', 'visual_title' => __( 'Family matter intake', 'rawlaw' ), 'visual_desc' => __( 'Turn maintenance, custody, separation or settlement questions into a structured legal request.', 'rawlaw' ) ),
				array( 'title' => __( 'I need bail for someone', 'rawlaw' ), 'sub' => __( 'Criminal law · Bail application', 'rawlaw' ), 'area' => 'criminal-law', 'details' => __( 'I need legal help for bail or an urgent criminal matter.', 'rawlaw' ), 'image' => $asset_base . 'kyr-bail.svg', 'visual_title' => __( 'Urgent criminal help', 'rawlaw' ), 'visual_desc' => __( 'Capture urgency, court context and city so the matter can be understood quickly.', 'rawlaw' ) ),
				array( 'title' => __( 'My landlord is threatening eviction', 'rawlaw' ), 'sub' => __( 'Property · Tenancy rights', 'rawlaw' ), 'area' => 'property', 'details' => __( 'My landlord is threatening eviction and I need to understand my tenancy rights.', 'rawlaw' ), 'image' => $asset_base . 'kyr-tenancy.svg', 'visual_title' => __( 'Tenancy rights clarity', 'rawlaw' ), 'visual_desc' => __( 'Explain rent, notice, possession and landlord issues in a format advocates can assess.', 'rawlaw' ) ),
				array( 'title' => __( 'I received a legal notice', 'rawlaw' ), 'sub' => __( 'Civil law · Reply and next steps', 'rawlaw' ), 'area' => '', 'details' => __( 'I received a legal notice and need help understanding the reply and next steps.', 'rawlaw' ), 'image' => $asset_base . 'kyr-notice.svg', 'visual_title' => __( 'Notice reply planning', 'rawlaw' ), 'visual_desc' => __( 'Summarize deadlines, sender details and response needs before sharing documents after signup.', 'rawlaw' ) ),
				array( 'title' => __( 'I want to file a consumer complaint', 'rawlaw' ), 'sub' => __( 'Consumer protection · E-filing', 'rawlaw' ), 'area' => 'consumer-protection', 'details' => __( 'I want to file a consumer complaint and need guidance on the process.', 'rawlaw' ), 'image' => $asset_base . 'kyr-consumer.svg', 'visual_title' => __( 'Consumer dispute support', 'rawlaw' ), 'visual_desc' => __( 'Organize purchase details, complaint history and requested remedy for a stronger first brief.', 'rawlaw' ) ),
				array( 'title' => __( 'I need to register property', 'rawlaw' ), 'sub' => __( 'Property · Registration process', 'rawlaw' ), 'area' => 'property', 'details' => __( 'I need help with property registration, documents, or next legal steps.', 'rawlaw' ), 'image' => $asset_base . 'kyr-property.svg', 'visual_title' => __( 'Property document review', 'rawlaw' ), 'visual_desc' => __( 'Clarify registry, title, stamp duty or document questions before moving to a consultation.', 'rawlaw' ) ),
			),
		),
		'news'      => array(
			'eyebrow' => __( 'Legal news first', 'rawlaw' ),
			'title' => __( 'News & Judgments', 'rawlaw' ),
			'subtitle' => __( 'Follow legal developments, court updates and practical explainers, then take the right next step when an issue affects you.', 'rawlaw' ),
			'view_all' => __( 'View all', 'rawlaw' ),
			'primary_cta' => __( 'Read More News', 'rawlaw' ),
			'query_cta' => __( 'Post a Legal Query', 'rawlaw' ),
			'cta_note' => __( 'Not sure what to do next? Start with the issue; RawLaw keeps the context structured for your next step.', 'rawlaw' ),
		),
		'advocates' => array(
			'eyebrow' => __( 'For advocates', 'rawlaw' ),
			'title' => __( 'Build visibility where legal intent starts.', 'rawlaw' ),
			'text' => __( 'RawLaw is built around legal news, citizen queries and verified lawyer discovery. Create a profile, show your practice areas, and earn trust before a client reaches out.', 'rawlaw' ),
			'primary_cta' => __( 'Join as Advocate', 'rawlaw' ),
			'primary_url' => 'https://app.rawlaw.in/register/lawyer',
			'secondary_cta' => __( 'View Advocate Services', 'rawlaw' ),
			'benefits' => array(
				array( 'title' => __( 'Profile visibility', 'rawlaw' ), 'text' => __( 'Appear in discovery paths shaped by city, court, practice area and legal issue.', 'rawlaw' ) ),
				array( 'title' => __( 'Relevant query opportunities', 'rawlaw' ), 'text' => __( 'Receive legal requirements from people already describing a real issue.', 'rawlaw' ) ),
				array( 'title' => __( 'Verification badge', 'rawlaw' ), 'text' => __( 'Make Bar Council details and profile checks visible before conversation starts.', 'rawlaw' ) ),
				array( 'title' => __( 'Content-led authority', 'rawlaw' ), 'text' => __( 'Use explainers, updates and answers to build trust without cold selling.', 'rawlaw' ) ),
			),
		),
		'how'       => array(
			'eyebrow' => __( 'How it works', 'rawlaw' ),
			'title' => __( 'From query to qualified legal help', 'rawlaw' ),
			'subtitle' => __( 'A structured intake flow gives citizens clarity and gives advocates the context they need before responding.', 'rawlaw' ),
			'cta' => __( 'Start with your query — it\'s free', 'rawlaw' ),
			'steps' => array(
				array( 'title' => __( 'Post the issue', 'rawlaw' ), 'desc' => __( 'Start with a one-line issue, then share the matter, city, urgency, and preferred contact route.', 'rawlaw' ) ),
				array( 'title' => __( 'RawLaw captures context', 'rawlaw' ), 'desc' => __( 'Your details stay structured and private so the matter can be routed with the right context.', 'rawlaw' ) ),
				array( 'title' => __( 'Match to verified advocates', 'rawlaw' ), 'desc' => __( 'Review verified profiles by city, practice area, experience, and relevance before engaging.', 'rawlaw' ) ),
				array( 'title' => __( 'Move only when ready', 'rawlaw' ), 'desc' => __( 'Compare options, ask follow-up questions, then decide whether to consult.', 'rawlaw' ) ),
			),
		),
		'faq'       => array(
			'eyebrow' => __( 'FAQs', 'rawlaw' ),
			'title' => __( 'Common Questions Answered', 'rawlaw' ),
			'subtitle' => __( 'Clear answers on verification, privacy, query intake and next steps.', 'rawlaw' ),
			'items' => array(
				array( 'q' => __( 'Is it free to post a legal query on RawLaw?', 'rawlaw' ), 'a' => __( 'Yes. Posting a query on RawLaw is free. You describe your issue and can review responses from verified advocates before deciding whether to book a consultation.', 'rawlaw' ) ),
				array( 'q' => __( 'How are advocates verified on RawLaw?', 'rawlaw' ), 'a' => __( 'RawLaw is built around profile checks such as Bar Council enrollment details, identity information, practice areas and city. Verification status should be visible before you contact an advocate.', 'rawlaw' ) ),
				array( 'q' => __( 'What happens after I post a query?', 'rawlaw' ), 'a' => __( 'RawLaw keeps your issue structured so you can complete signup, track updates, and continue the matter inside the platform.', 'rawlaw' ) ),
				array( 'q' => __( 'What types of legal matters does RawLaw cover?', 'rawlaw' ), 'a' => __( 'RawLaw covers a wide range of legal services including property disputes, family law, criminal cases, consumer complaints, labour matters, civil litigation, corporate law, GST, cheque bounce, and more.', 'rawlaw' ) ),
				array( 'q' => __( 'How quickly will I hear from a lawyer after posting a query?', 'rawlaw' ), 'a' => __( 'Response time depends on the issue, city, urgency and lawyer availability. Urgent matters should be marked clearly so relevant advocates can prioritize them.', 'rawlaw' ) ),
				array( 'q' => __( 'Is my legal query and personal data kept confidential?', 'rawlaw' ), 'a' => __( 'Legal queries are meant to stay inside the RawLaw workspace instead of being published publicly. Avoid sharing unnecessary sensitive documents until you choose who to engage.', 'rawlaw' ) ),
			),
		),
		'closing'   => array(
			'title' => __( 'Your rights matter. Do not navigate the law alone.', 'rawlaw' ),
			'text' => __( 'Start with the issue, understand your options, then continue inside RawLaw when you are ready.', 'rawlaw' ),
			'primary_cta' => __( 'Post Free Query', 'rawlaw' ),
			'secondary_cta' => __( 'Login', 'rawlaw' ),
			'secondary_url' => 'https://app.rawlaw.in/login',
		),
		'footer'    => array(
			'about' => __( 'Legal news, plain-language guidance and structured query intake for India.', 'rawlaw' ),
			'trust_1' => __( 'Legal updates and practical insights', 'rawlaw' ),
			'trust_2' => __( 'Private query intake', 'rawlaw' ),
			'fine_print' => __( 'Made with clarity, trust and access.', 'rawlaw' ),
			'copy' => __( 'Legal information and query intake for India.', 'rawlaw' ),
		),
	);
}

function rawlaw_home_merge_content( $defaults, $saved ) {
	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	foreach ( $defaults as $key => $default ) {
		if ( is_array( $default ) ) {
			$defaults[ $key ] = rawlaw_home_merge_content( $default, isset( $saved[ $key ] ) ? $saved[ $key ] : array() );
			continue;
		}

		if ( isset( $saved[ $key ] ) && '' !== $saved[ $key ] ) {
			$defaults[ $key ] = $saved[ $key ];
		}
	}

	return $defaults;
}

function rawlaw_home_content() {
	$saved = get_option( 'rawlaw_homepage_content', array() );
	return rawlaw_home_merge_content( rawlaw_home_default_content(), is_array( $saved ) ? $saved : array() );
}

function rawlaw_home_get( $path, $fallback = '' ) {
	$content = rawlaw_home_content();
	foreach ( explode( '.', $path ) as $part ) {
		if ( ! is_array( $content ) || ! array_key_exists( $part, $content ) ) {
			return $fallback;
		}
		$content = $content[ $part ];
	}

	return '' === $content ? $fallback : $content;
}

function rawlaw_sanitize_homepage_content( $input ) {
	$defaults = rawlaw_home_default_content();
	if ( ! is_array( $input ) ) {
		return array();
	}

	return rawlaw_sanitize_homepage_content_group( $input, $defaults );
}

function rawlaw_sanitize_homepage_content_group( $input, $defaults ) {
	$output = array();
	foreach ( $defaults as $key => $default ) {
		if ( ! isset( $input[ $key ] ) ) {
			continue;
		}
		if ( is_array( $default ) ) {
			$output[ $key ] = rawlaw_sanitize_homepage_content_group( is_array( $input[ $key ] ) ? $input[ $key ] : array(), $default );
			continue;
		}

		$value = wp_unslash( $input[ $key ] );
		if ( false !== strpos( (string) $key, 'url' ) || 'image' === $key ) {
			$output[ $key ] = esc_url_raw( $value );
		} elseif ( in_array( $key, array( 'details', 'text', 'subtitle', 'desc', 'a', 'visual_desc', 'about', 'copy', 'fine_print' ), true ) ) {
			$output[ $key ] = sanitize_textarea_field( $value );
		} else {
			$output[ $key ] = sanitize_text_field( $value );
		}
	}

	return $output;
}

function rawlaw_homepage_admin_menu() {
	add_theme_page(
		__( 'RawLaw Homepage', 'rawlaw' ),
		__( 'RawLaw Homepage', 'rawlaw' ),
		'edit_theme_options',
		'rawlaw-homepage',
		'rawlaw_homepage_settings_page'
	);
}
add_action( 'admin_menu', 'rawlaw_homepage_admin_menu' );

function rawlaw_homepage_register_settings() {
	register_setting( 'rawlaw_homepage_settings', 'rawlaw_homepage_content', array(
		'type'              => 'array',
		'sanitize_callback' => 'rawlaw_sanitize_homepage_content',
		'default'           => array(),
	) );
}
add_action( 'admin_init', 'rawlaw_homepage_register_settings' );

function rawlaw_homepage_field( $path, $label, $type = 'text' ) {
	$value = rawlaw_home_get( $path );
	$name  = 'rawlaw_homepage_content[' . implode( '][', array_map( 'esc_attr', explode( '.', $path ) ) ) . ']';
	$id    = 'rawlaw-home-' . sanitize_html_class( str_replace( '.', '-', $path ) );
	?>
	<p class="rawlaw-home-field">
		<label for="<?php echo esc_attr( $id ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label>
		<?php if ( 'textarea' === $type ) : ?>
			<textarea id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" rows="3" class="large-text"><?php echo esc_textarea( $value ); ?></textarea>
		<?php else : ?>
			<input id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" type="<?php echo esc_attr( $type ); ?>" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
		<?php endif; ?>
	</p>
	<?php
}

function rawlaw_homepage_settings_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	$content = rawlaw_home_content();
	?>
	<div class="wrap rawlaw-home-settings">
		<h1><?php esc_html_e( 'RawLaw Homepage Content', 'rawlaw' ); ?></h1>
		<p><?php esc_html_e( 'Edit homepage copy and content only. Layout, section order and responsive design remain controlled by the theme.', 'rawlaw' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'rawlaw_homepage_settings' ); ?>

			<h2><?php esc_html_e( 'Hero', 'rawlaw' ); ?></h2>
			<?php
			rawlaw_homepage_field( 'hero.headline_line', __( 'Headline line 1', 'rawlaw' ) );
			rawlaw_homepage_field( 'hero.headline_accent', __( 'Headline line 2', 'rawlaw' ) );
			rawlaw_homepage_field( 'hero.subtitle', __( 'Subtitle', 'rawlaw' ), 'textarea' );
			rawlaw_homepage_field( 'hero.placeholder', __( 'Input placeholder', 'rawlaw' ) );
			rawlaw_homepage_field( 'hero.button', __( 'Button text', 'rawlaw' ) );
			rawlaw_homepage_field( 'hero.lawyer_prompt', __( 'Advocate prompt', 'rawlaw' ) );
			rawlaw_homepage_field( 'hero.lawyer_link_text', __( 'Advocate link text', 'rawlaw' ) );
			rawlaw_homepage_field( 'hero.lawyer_link_url', __( 'Advocate link URL', 'rawlaw' ), 'url' );
			?>
			<h3><?php esc_html_e( 'Popular Chips', 'rawlaw' ); ?></h3>
			<?php foreach ( $content['hero']['popular'] as $i => $item ) : ?>
				<h4><?php printf( esc_html__( 'Chip %d', 'rawlaw' ), $i + 1 ); ?></h4>
				<?php
				rawlaw_homepage_field( "hero.popular.$i.label", __( 'Label', 'rawlaw' ) );
				rawlaw_homepage_field( "hero.popular.$i.area", __( 'Legal category slug', 'rawlaw' ) );
				rawlaw_homepage_field( "hero.popular.$i.details", __( 'Prefill details', 'rawlaw' ), 'textarea' );
				?>
			<?php endforeach; ?>

			<h2><?php esc_html_e( 'Feature Strip', 'rawlaw' ); ?></h2>
			<?php foreach ( $content['features'] as $i => $feature ) : ?>
				<?php rawlaw_homepage_field( "features.$i.title", sprintf( esc_html__( 'Feature %d title', 'rawlaw' ), $i + 1 ) ); ?>
			<?php endforeach; ?>

			<h2><?php esc_html_e( 'Know Your Rights', 'rawlaw' ); ?></h2>
			<?php
			rawlaw_homepage_field( 'kyr.eyebrow', __( 'Eyebrow', 'rawlaw' ) );
			rawlaw_homepage_field( 'kyr.title', __( 'Title', 'rawlaw' ) );
			rawlaw_homepage_field( 'kyr.subtitle', __( 'Subtitle', 'rawlaw' ), 'textarea' );
			rawlaw_homepage_field( 'kyr.visual_eyebrow', __( 'Visual eyebrow', 'rawlaw' ) );
			rawlaw_homepage_field( 'kyr.trust', __( 'Trust note', 'rawlaw' ), 'textarea' );
			foreach ( $content['kyr']['issues'] as $i => $issue ) :
				?>
				<h3><?php printf( esc_html__( 'Know Your Rights Item %d', 'rawlaw' ), $i + 1 ); ?></h3>
				<?php
				rawlaw_homepage_field( "kyr.issues.$i.title", __( 'Card title', 'rawlaw' ) );
				rawlaw_homepage_field( "kyr.issues.$i.sub", __( 'Card subtitle', 'rawlaw' ) );
				rawlaw_homepage_field( "kyr.issues.$i.area", __( 'Legal category slug', 'rawlaw' ) );
				rawlaw_homepage_field( "kyr.issues.$i.details", __( 'Prefill details', 'rawlaw' ), 'textarea' );
				rawlaw_homepage_field( "kyr.issues.$i.image", __( 'Visual image URL', 'rawlaw' ), 'url' );
				rawlaw_homepage_field( "kyr.issues.$i.visual_title", __( 'Visual title', 'rawlaw' ) );
				rawlaw_homepage_field( "kyr.issues.$i.visual_desc", __( 'Visual description', 'rawlaw' ), 'textarea' );
			endforeach;
			?>

			<h2><?php esc_html_e( 'News Section', 'rawlaw' ); ?></h2>
			<?php
			rawlaw_homepage_field( 'news.eyebrow', __( 'Eyebrow', 'rawlaw' ) );
			rawlaw_homepage_field( 'news.title', __( 'Title', 'rawlaw' ) );
			rawlaw_homepage_field( 'news.subtitle', __( 'Subtitle', 'rawlaw' ), 'textarea' );
			rawlaw_homepage_field( 'news.view_all', __( 'View all link text', 'rawlaw' ) );
			rawlaw_homepage_field( 'news.primary_cta', __( 'Primary CTA', 'rawlaw' ) );
			rawlaw_homepage_field( 'news.query_cta', __( 'Query CTA', 'rawlaw' ) );
			rawlaw_homepage_field( 'news.cta_note', __( 'CTA note', 'rawlaw' ), 'textarea' );
			?>

			<h2><?php esc_html_e( 'For Advocates', 'rawlaw' ); ?></h2>
			<?php
			rawlaw_homepage_field( 'advocates.eyebrow', __( 'Eyebrow', 'rawlaw' ) );
			rawlaw_homepage_field( 'advocates.title', __( 'Title', 'rawlaw' ) );
			rawlaw_homepage_field( 'advocates.text', __( 'Text', 'rawlaw' ), 'textarea' );
			rawlaw_homepage_field( 'advocates.primary_cta', __( 'Primary CTA', 'rawlaw' ) );
			rawlaw_homepage_field( 'advocates.primary_url', __( 'Primary URL', 'rawlaw' ), 'url' );
			rawlaw_homepage_field( 'advocates.secondary_cta', __( 'Secondary CTA', 'rawlaw' ) );
			foreach ( $content['advocates']['benefits'] as $i => $benefit ) :
				rawlaw_homepage_field( "advocates.benefits.$i.title", sprintf( esc_html__( 'Benefit %d title', 'rawlaw' ), $i + 1 ) );
				rawlaw_homepage_field( "advocates.benefits.$i.text", sprintf( esc_html__( 'Benefit %d text', 'rawlaw' ), $i + 1 ), 'textarea' );
			endforeach;
			?>

			<h2><?php esc_html_e( 'How It Works', 'rawlaw' ); ?></h2>
			<?php
			rawlaw_homepage_field( 'how.eyebrow', __( 'Eyebrow', 'rawlaw' ) );
			rawlaw_homepage_field( 'how.title', __( 'Title', 'rawlaw' ) );
			rawlaw_homepage_field( 'how.subtitle', __( 'Subtitle', 'rawlaw' ), 'textarea' );
			rawlaw_homepage_field( 'how.cta', __( 'CTA text', 'rawlaw' ) );
			foreach ( $content['how']['steps'] as $i => $step ) :
				rawlaw_homepage_field( "how.steps.$i.title", sprintf( esc_html__( 'Step %d title', 'rawlaw' ), $i + 1 ) );
				rawlaw_homepage_field( "how.steps.$i.desc", sprintf( esc_html__( 'Step %d description', 'rawlaw' ), $i + 1 ), 'textarea' );
			endforeach;
			?>

			<h2><?php esc_html_e( 'FAQ', 'rawlaw' ); ?></h2>
			<?php
			rawlaw_homepage_field( 'faq.eyebrow', __( 'Eyebrow', 'rawlaw' ) );
			rawlaw_homepage_field( 'faq.title', __( 'Title', 'rawlaw' ) );
			rawlaw_homepage_field( 'faq.subtitle', __( 'Subtitle', 'rawlaw' ), 'textarea' );
			foreach ( $content['faq']['items'] as $i => $faq ) :
				rawlaw_homepage_field( "faq.items.$i.q", sprintf( esc_html__( 'Question %d', 'rawlaw' ), $i + 1 ), 'textarea' );
				rawlaw_homepage_field( "faq.items.$i.a", sprintf( esc_html__( 'Answer %d', 'rawlaw' ), $i + 1 ), 'textarea' );
			endforeach;
			?>

			<h2><?php esc_html_e( 'Closing CTA & Footer Copy', 'rawlaw' ); ?></h2>
			<?php
			rawlaw_homepage_field( 'closing.title', __( 'Closing title', 'rawlaw' ) );
			rawlaw_homepage_field( 'closing.text', __( 'Closing text', 'rawlaw' ), 'textarea' );
			rawlaw_homepage_field( 'closing.primary_cta', __( 'Primary CTA', 'rawlaw' ) );
			rawlaw_homepage_field( 'closing.secondary_cta', __( 'Secondary CTA', 'rawlaw' ) );
			rawlaw_homepage_field( 'closing.secondary_url', __( 'Secondary URL', 'rawlaw' ), 'url' );
			rawlaw_homepage_field( 'footer.about', __( 'Footer about', 'rawlaw' ), 'textarea' );
			rawlaw_homepage_field( 'footer.trust_1', __( 'Footer trust item 1', 'rawlaw' ) );
			rawlaw_homepage_field( 'footer.trust_2', __( 'Footer trust item 2', 'rawlaw' ) );
			rawlaw_homepage_field( 'footer.fine_print', __( 'Footer fine print', 'rawlaw' ) );
			rawlaw_homepage_field( 'footer.copy', __( 'Footer copyright sentence', 'rawlaw' ) );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

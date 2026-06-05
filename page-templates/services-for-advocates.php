<?php
/**
 * Template Name: Services for Advocates
 * Template Post Type: page
 *
 * A conversion-focused landing page for RawLaw's litigation support services.
 *
 * @package RawLaw
 */

get_header();
$contact_url = esc_url( home_url( '/contact/' ) );
?>

<!-- ========== HERO ========== -->
<section class="sfa-hero" data-reveal>
	<div class="container sfa-hero__inner">
		<div class="sfa-hero__content">
			<span class="sfa-hero__eyebrow"><?php esc_html_e( 'For Advocates & Law Firms', 'rawlaw' ); ?></span>
			<h1 class="sfa-hero__title">
				<?php esc_html_e( 'Precision Drafting.', 'rawlaw' ); ?><br>
				<?php esc_html_e( 'Structured Research.', 'rawlaw' ); ?><br>
				<em><?php esc_html_e( 'Court-Ready Work.', 'rawlaw' ); ?></em>
			</h1>
			<p class="sfa-hero__subtitle"><?php esc_html_e( 'Confidential, backend drafting and research support exclusively for practicing advocates and law firms across India. We work behind the scenes — so you can lead from the front.', 'rawlaw' ); ?></p>
			<div class="sfa-hero__ctas">
				<a class="btn btn--primary btn--lg" href="<?php echo $contact_url; ?>"><?php esc_html_e( 'Request Litigation Support', 'rawlaw' ); ?></a>
				<a class="btn btn--ghost btn--lg" href="#sfa-how"><?php esc_html_e( 'How It Works', 'rawlaw' ); ?></a>
			</div>
		</div>
		<div class="sfa-hero__graphic" aria-hidden="true">
			<!-- Decorative illustration: layered document cards -->
			<div class="sfa-hero__visual">
				<div class="sfa-hero__doc sfa-hero__doc--back"></div>
				<div class="sfa-hero__doc sfa-hero__doc--mid"></div>
				<div class="sfa-hero__doc sfa-hero__doc--front">
					<span class="sfa-hero__doc-line sfa-hero__doc-line--title"></span>
					<span class="sfa-hero__doc-line"></span>
					<span class="sfa-hero__doc-line"></span>
					<span class="sfa-hero__doc-line sfa-hero__doc-line--short"></span>
					<span class="sfa-hero__doc-seal" aria-hidden="true"></span>
				</div>
			</div>
			<div class="sfa-hero__pills">
				<span class="sfa-hero__pill"><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Court-Ready', 'rawlaw' ); ?></span>
				<span class="sfa-hero__pill sfa-hero__pill--blue"><?php rawlaw_icon( 'lock' ); ?> <?php esc_html_e( 'Confidential', 'rawlaw' ); ?></span>
			</div>
		</div>
	</div>
</section>

<!-- ========== TRUST BAR ========== -->
<div class="sfa-trustbar" data-reveal>
	<div class="container">
		<div class="sfa-trustbar__inner">
			<div class="sfa-trustbar__item">
				<strong>500+</strong>
				<span><?php esc_html_e( 'Drafts Delivered', 'rawlaw' ); ?></span>
			</div>
			<div class="sfa-trustbar__sep" aria-hidden="true"></div>
			<div class="sfa-trustbar__item">
				<strong>100+</strong>
				<span><?php esc_html_e( 'Advocates Served', 'rawlaw' ); ?></span>
			</div>
			<div class="sfa-trustbar__sep" aria-hidden="true"></div>
			<div class="sfa-trustbar__item">
				<strong>15+</strong>
				<span><?php esc_html_e( 'Practice Areas', 'rawlaw' ); ?></span>
			</div>
			<div class="sfa-trustbar__sep" aria-hidden="true"></div>
			<div class="sfa-trustbar__item">
				<strong>3</strong>
				<span><?php esc_html_e( 'Revisions Included', 'rawlaw' ); ?></span>
			</div>
		</div>
	</div>
</div>

<!-- ========== WHY RAW LAW — VALUE PROPS ========== -->
<section class="section sfa-why" data-reveal>
	<div class="container">
		<header class="section__header section__header--centered">
			<p class="section__eyebrow"><?php esc_html_e( 'Why Raw Law', 'rawlaw' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'Your Extended Litigation Team — Without the Overhead', 'rawlaw' ); ?></h2>
			<p class="sfa-why__lead"><?php esc_html_e( 'We function as your confidential backend litigation support desk — court-ready pleadings, structured legal research, case law compilation, and strategic drafting for civil, criminal, commercial, arbitration, and constitutional matters.', 'rawlaw' ); ?></p>
		</header>
		<div class="sfa-demands" data-reveal-stagger>
			<?php
			$demands = array(
				array( 'title' => __( 'Speed', 'rawlaw' ),               'desc' => __( 'Fast turnaround on urgent filings and research', 'rawlaw' ) ),
				array( 'title' => __( 'Accuracy', 'rawlaw' ),            'desc' => __( 'Precise, error-free drafting with procedural compliance', 'rawlaw' ) ),
				array( 'title' => __( 'Precedent Depth', 'rawlaw' ),     'desc' => __( 'Comprehensive case law and statutory research', 'rawlaw' ) ),
				array( 'title' => __( 'Structured Pleadings', 'rawlaw' ), 'desc' => __( 'Court-formatted, logically organized documents', 'rawlaw' ) ),
				array( 'title' => __( 'Strategic Positioning', 'rawlaw' ), 'desc' => __( 'Framing arguments for maximum persuasive impact', 'rawlaw' ) ),
			);
			$demand_i = 0;
			foreach ( $demands as $d ) :
				$demand_i++;
			?>
			<div class="sfa-demand">
				<span class="sfa-demand__num" aria-hidden="true"><?php echo str_pad( $demand_i, 2, '0', STR_PAD_LEFT ); ?></span>
				<h3 class="sfa-demand__title"><?php echo esc_html( $d['title'] ); ?></h3>
				<p class="sfa-demand__desc"><?php echo esc_html( $d['desc'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ========== OUR SERVICES ========== -->
<section class="section section--alt sfa-services" data-reveal>
	<div class="container">
		<header class="section__header section__header--centered">
			<p class="section__eyebrow"><?php esc_html_e( 'Our Services', 'rawlaw' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'Comprehensive Drafting Support', 'rawlaw' ); ?></h2>
			<p class="sfa-services__lead"><?php esc_html_e( 'All drafts are structured, research-backed, and formatted court-ready.', 'rawlaw' ); ?></p>
		</header>
		<div class="sfa-services__grid" data-reveal-stagger>
			<?php
			$services = array(
				__( 'Bail Applications', 'rawlaw' ),
				__( 'Anticipatory Bail', 'rawlaw' ),
				__( 'Writ Petitions', 'rawlaw' ),
				__( 'Arbitration Petitions', 'rawlaw' ),
				__( 'Appeals (Civil & Criminal)', 'rawlaw' ),
				__( 'Written Submissions', 'rawlaw' ),
				__( 'Legal Notices', 'rawlaw' ),
				__( 'Affidavits', 'rawlaw' ),
				__( 'Interim Applications', 'rawlaw' ),
				__( 'Revision Applications', 'rawlaw' ),
				__( 'Commercial Suits', 'rawlaw' ),
				__( 'Constitutional Matters', 'rawlaw' ),
			);
			foreach ( $services as $s ) : ?>
			<div class="sfa-service">
				<span class="sfa-service__check" aria-hidden="true"></span>
				<span class="sfa-service__name"><?php echo esc_html( $s ); ?></span>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ========== HOW IT WORKS ========== -->
<section class="section" id="sfa-how" data-reveal>
	<div class="container">
		<header class="section__header section__header--centered">
			<p class="section__eyebrow"><?php esc_html_e( 'How It Works', 'rawlaw' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'Four Simple Steps', 'rawlaw' ); ?></h2>
		</header>
		<ol class="sfa-steps" data-reveal-stagger>
			<?php
			$steps = array(
				array( 'title' => __( 'Submit Your Brief', 'rawlaw' ),   'desc' => __( 'Share your matter summary and relevant documents securely.', 'rawlaw' ) ),
				array( 'title' => __( 'Scope & Timeline', 'rawlaw' ),    'desc' => __( 'Receive a clear confirmation of deliverables and timeline.', 'rawlaw' ) ),
				array( 'title' => __( 'Receive Your Draft', 'rawlaw' ),  'desc' => __( 'Work delivered in structured, editable, court-ready format.', 'rawlaw' ) ),
				array( 'title' => __( 'Revisions Included', 'rawlaw' ),  'desc' => __( 'Up to three rounds of revisions at no additional cost.', 'rawlaw' ) ),
			);
			$step_i = 0;
			foreach ( $steps as $step ) :
				$step_i++;
			?>
			<li class="sfa-step">
				<span class="sfa-step__num" aria-hidden="true"><?php echo esc_html( $step_i ); ?></span>
				<h3 class="sfa-step__title"><?php echo esc_html( $step['title'] ); ?></h3>
				<p class="sfa-step__desc"><?php echo esc_html( $step['desc'] ); ?></p>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<!-- ========== WHO WE WORK WITH + CONFIDENTIALITY (merged) ========== -->
<section class="section section--alt sfa-audience" data-reveal>
	<div class="container">
		<div class="sfa-audience__grid">
			<!-- Left: Who -->
			<div class="sfa-audience__block">
				<p class="section__eyebrow"><?php esc_html_e( 'Who We Work With', 'rawlaw' ); ?></p>
				<h2 class="section__title"><?php esc_html_e( 'Built for Real-World Legal Practice', 'rawlaw' ); ?></h2>
				<ul class="sfa-audience__list" role="list">
					<li><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Solo practitioners', 'rawlaw' ); ?></li>
					<li><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Litigation chambers', 'rawlaw' ); ?></li>
					<li><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Boutique firms', 'rawlaw' ); ?></li>
					<li><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Senior advocates', 'rawlaw' ); ?></li>
					<li><?php rawlaw_icon( 'verified' ); ?> <?php esc_html_e( 'Corporate dispute teams', 'rawlaw' ); ?></li>
				</ul>
			</div>
			<!-- Right: Confidentiality -->
			<div class="sfa-audience__block sfa-audience__block--trust">
				<p class="section__eyebrow"><?php esc_html_e( 'Confidentiality First', 'rawlaw' ); ?></p>
				<h2 class="section__title"><?php esc_html_e( 'We Work Under Your Name. Always.', 'rawlaw' ); ?></h2>
				<ul class="sfa-audience__list" role="list">
					<li><?php rawlaw_icon( 'lock' ); ?> <?php esc_html_e( 'Strict internal confidentiality protocols', 'rawlaw' ); ?></li>
					<li><?php rawlaw_icon( 'lock' ); ?> <?php esc_html_e( 'Controlled document access', 'rawlaw' ); ?></li>
					<li><?php rawlaw_icon( 'lock' ); ?> <?php esc_html_e( 'No client solicitation — ever', 'rawlaw' ); ?></li>
					<li><?php rawlaw_icon( 'lock' ); ?> <?php esc_html_e( 'Non-compete commitment', 'rawlaw' ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<!-- ========== WHY CHOOSE US — BENEFITS ========== -->
<section class="section sfa-benefits" data-reveal>
	<div class="container">
		<header class="section__header section__header--centered">
			<p class="section__eyebrow"><?php esc_html_e( 'Why Choose Us', 'rawlaw' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'Why Advocates Choose Raw Law', 'rawlaw' ); ?></h2>
		</header>
		<div class="sfa-benefits__grid" data-reveal-stagger>
			<?php
			$benefits = array(
				array( 'title' => __( 'Court-Structured Drafting', 'rawlaw' ),       'desc' => __( 'Formatted exactly as courts expect — structured, numbered, citation-accurate.', 'rawlaw' ) ),
				array( 'title' => __( 'Litigation-Focused Research', 'rawlaw' ),     'desc' => __( 'Practical, issue-wise research memos with applicable precedents.', 'rawlaw' ) ),
				array( 'title' => __( 'Time Efficiency', 'rawlaw' ),                 'desc' => __( 'Offload research and drafting so you can focus on courtroom strategy.', 'rawlaw' ) ),
				array( 'title' => __( 'No Staffing Overhead', 'rawlaw' ),            'desc' => __( 'Full-time quality without full-time payroll commitment.', 'rawlaw' ) ),
				array( 'title' => __( 'Reliable Turnaround', 'rawlaw' ),             'desc' => __( 'Committed timelines with milestone updates on every engagement.', 'rawlaw' ) ),
				array( 'title' => __( 'Strategic Pleading Framing', 'rawlaw' ),      'desc' => __( 'Arguments structured for persuasive impact and judicial attention.', 'rawlaw' ) ),
			);
			foreach ( $benefits as $b ) : ?>
			<div class="sfa-benefit">
				<h3 class="sfa-benefit__title"><?php echo esc_html( $b['title'] ); ?></h3>
				<p class="sfa-benefit__desc"><?php echo esc_html( $b['desc'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ========== PRICING / ENGAGEMENT MODELS ========== -->
<section class="section section--alt sfa-pricing" data-reveal>
	<div class="container">
		<header class="section__header section__header--centered">
			<p class="section__eyebrow"><?php esc_html_e( 'Engagement Models', 'rawlaw' ); ?></p>
			<h2 class="section__title"><?php esc_html_e( 'Flexible Plans for Every Practice', 'rawlaw' ); ?></h2>
		</header>
		<div class="sfa-pricing__grid" data-reveal-stagger>
			<div class="sfa-plan">
				<h3 class="sfa-plan__title"><?php esc_html_e( 'Per-Draft', 'rawlaw' ); ?></h3>
				<p class="sfa-plan__desc"><?php esc_html_e( 'Pay per document. Ideal for occasional filings or one-off research requests.', 'rawlaw' ); ?></p>
				<a class="sfa-plan__link" href="<?php echo $contact_url; ?>"><?php esc_html_e( 'Get Started', 'rawlaw' ); ?> &rarr;</a>
			</div>
			<div class="sfa-plan sfa-plan--featured">
				<span class="sfa-plan__badge"><?php esc_html_e( 'Popular', 'rawlaw' ); ?></span>
				<h3 class="sfa-plan__title"><?php esc_html_e( 'Monthly Retainer', 'rawlaw' ); ?></h3>
				<p class="sfa-plan__desc"><?php esc_html_e( 'Dedicated support hours each month. Best for regular litigation workload.', 'rawlaw' ); ?></p>
				<a class="sfa-plan__link" href="<?php echo $contact_url; ?>"><?php esc_html_e( 'Get Started', 'rawlaw' ); ?> &rarr;</a>
			</div>
			<div class="sfa-plan">
				<h3 class="sfa-plan__title"><?php esc_html_e( 'Volume-Based', 'rawlaw' ); ?></h3>
				<p class="sfa-plan__desc"><?php esc_html_e( 'Bulk drafting packages for firms with high-volume filing needs.', 'rawlaw' ); ?></p>
				<a class="sfa-plan__link" href="<?php echo $contact_url; ?>"><?php esc_html_e( 'Get Started', 'rawlaw' ); ?> &rarr;</a>
			</div>
		</div>
	</div>
</section>

<!-- ========== CLOSING CTA ========== -->
<section class="section sfa-cta" data-reveal>
	<div class="container">
		<div class="sfa-cta__inner">
			<p class="section__eyebrow"><?php esc_html_e( 'Get Started', 'rawlaw' ); ?></p>
			<h2 class="sfa-cta__title"><?php esc_html_e( 'Ready to Delegate Smartly?', 'rawlaw' ); ?></h2>
			<p class="sfa-cta__subtitle"><?php esc_html_e( 'Focus on arguments. We\'ll handle the groundwork.', 'rawlaw' ); ?></p>
			<a class="btn btn--primary btn--lg" href="<?php echo $contact_url; ?>"><?php esc_html_e( 'Request Litigation Support Today', 'rawlaw' ); ?></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>

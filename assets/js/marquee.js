/**
 * RawLaw — Scroll-driven features-bar marquee.
 *
 * Requires GSAP + ScrollTrigger (loaded by WordPress enqueue).
 * Skips silently when either is absent or prefers-reduced-motion is set.
 *
 * Behaviour:
 *   - Duplicate all track children in JS so the visible strip never runs dry.
 *   - Map page scroll progress (top-of-page → bottom-of-page) to translateX.
 *   - scrub: 1.5 gives a natural, slightly lagged feel.
 *   - Scrolling down → strip moves left.  Scrolling up → strip moves right.
 */
(function () {
	'use strict';

	// Guard: require GSAP, ScrollTrigger, and motion preference.
	if (
		typeof gsap === 'undefined' ||
		typeof ScrollTrigger === 'undefined' ||
		window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches
	) {
		return;
	}

	gsap.registerPlugin( ScrollTrigger );

	var bar   = document.querySelector( '.features-bar' );
	var track = bar && bar.querySelector( '.features-bar__track' );

	if ( ! track ) { return; }

	// --- 1. Duplicate children for seamless visual continuity ---------------
	// Move across more than one set to increase marquee travel.
	var travelSets = 2;

	// Clone every existing child (items + separators) and append with aria-hidden.
	var originals = Array.prototype.slice.call( track.children );
	for ( var setIndex = 0; setIndex < travelSets; setIndex++ ) {
		originals.forEach( function ( node ) {
			var clone = node.cloneNode( true );
			clone.setAttribute( 'aria-hidden', 'true' );
			// Listitem role should not be duplicated for AT
			if ( clone.getAttribute( 'role' ) === 'listitem' ) {
				clone.setAttribute( 'role', 'presentation' );
			}
			track.appendChild( clone );
		} );
	}

	// Mark bar as ready (CSS can use this to apply overflow: hidden earlier if needed)
	bar.classList.add( 'features-bar--ready' );

	// --- 2. Measure and animate after layout is calculated ------------------
	// rAF ensures the browser has performed layout with the duplicated children.
	requestAnimationFrame( function () {
		// singleSetWidth = original set width.
		var totalSets       = travelSets + 1;
		var singleSetWidth  = track.scrollWidth / totalSets;
		var travelDistance  = singleSetWidth * travelSets;

		// Animate: scroll top→bottom maps to x: 0 → -travelDistance
		gsap.fromTo(
			track,
			{ x: 0 },
			{
				x            : -travelDistance,
				ease         : 'none',
				scrollTrigger: {
					trigger: document.body,
					start  : 'top top',
					end    : 'bottom bottom',
					scrub  : 1.5,
				},
			}
		);
	} );
} )();

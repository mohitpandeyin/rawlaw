/**
 * reCAPTCHA v3 for the comment form.
 *
 * Google's api.js is not enqueued in PHP — it's injected here, lazily, on
 * first interaction with the comment field, rather than on every page load.
 * Loading api.js?render=SITE_KEY spins up a hidden anchor iframe immediately
 * (that's how v3 works even before .execute() is ever called), which is
 * third-party weight nobody needed unless they're about to write a comment.
 *
 * v3 has no checkbox — grecaptcha.execute() fetches a token asynchronously,
 * so the real submit is held until the token is attached to the form.
 */
(function () {
	'use strict';

	// WP core's default comment_form() submit button is
	// <input name="submit" id="submit" type="submit">. A form control named
	// or id'd "submit" shadows HTMLFormElement's own submit method — per
	// spec, the named-control lookup wins, so `form.submit` resolves to that
	// <input> element, not a function, and `form.submit()` throws
	// "form.submit is not a function". Confirmed live: this made every
	// comment that passed reCAPTCHA silently fail to post — the token
	// attached, `recaptchaDone` got set, then the call threw and nothing
	// submitted. `HTMLFormElement.prototype.submit.call(form)` calls the
	// real method directly, bypassing the shadowing.
	function submitForm(form) {
		HTMLFormElement.prototype.submit.call(form);
	}

	document.addEventListener('DOMContentLoaded', function () {
		var form = document.getElementById('commentform');
		var field = document.getElementById('comment');
		if (!form || !field || typeof RawLawRecaptcha === 'undefined') {
			return;
		}

		var apiPromise = null;

		// Idempotent: the focus listener and a fast submit-without-focusing
		// path can both call this — only the first call actually injects
		// the script, everyone else gets the same pending/resolved promise.
		function loadApi() {
			if (apiPromise) {
				return apiPromise;
			}
			apiPromise = new Promise(function (resolve, reject) {
				var script = document.createElement('script');
				script.src = RawLawRecaptcha.apiUrl;
				script.async = true;
				script.onload = function () { resolve(); };
				script.onerror = function () { reject(new Error('reCAPTCHA failed to load')); };
				document.head.appendChild(script);
			});
			return apiPromise;
		}

		// Start loading as soon as they show intent to comment, so it's
		// likely already resolved by the time they click submit.
		field.addEventListener('focus', loadApi, { once: true });

		form.addEventListener('submit', function (e) {
			if (form.dataset.recaptchaDone === '1') {
				return;
			}
			e.preventDefault();

			loadApi().then(function () {
				grecaptcha.ready(function () {
					grecaptcha.execute(RawLawRecaptcha.siteKey, { action: RawLawRecaptcha.action }).then(function (token) {
						var input = form.querySelector('input[name="g-recaptcha-response"]');
						if (!input) {
							input = document.createElement('input');
							input.type = 'hidden';
							input.name = 'g-recaptcha-response';
							form.appendChild(input);
						}
						input.value = token;
						form.dataset.recaptchaDone = '1';
						submitForm(form);
					});
				});
			}).catch(function () {
				// api.js genuinely failed to load (network/ad-blocker) —
				// submit anyway rather than trap the visitor. The server
				// side check in inc/comment-antispam.php rejects a missing
				// token when reCAPTCHA is configured, matching what already
				// happens for a no-JS submission.
				submitForm(form);
			});
		});
	});
})();

/**
 * reCAPTCHA v3 for the comment form.
 *
 * v3 has no checkbox — grecaptcha.execute() fetches a token asynchronously,
 * so the real submit is held until the token is attached to the form.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var form = document.getElementById('commentform');
		if (!form || typeof grecaptcha === 'undefined' || typeof RawLawRecaptcha === 'undefined') {
			return;
		}

		form.addEventListener('submit', function (e) {
			if (form.dataset.recaptchaDone === '1') {
				return;
			}
			e.preventDefault();

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
					form.submit();
				});
			});
		});
	});
})();

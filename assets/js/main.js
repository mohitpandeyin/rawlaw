/**
 * RawLaw — front-end interactions.
 *
 * Goals:
 *   - one well-orchestrated reveal per page (staggered hero on first paint)
 *   - accessible mobile menu + search toggle
 *   - scroll-spy for table of contents
 *   - subtle scroll-triggered reveals (respecting prefers-reduced-motion)
 *   - copy-link share button
 *
 * No frameworks. All interactions degrade gracefully when JS is disabled.
 */
(function () {
	'use strict';
	var doc = document;
	var html = doc.documentElement;
	var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* --- 1. Mobile menu toggle ----------------------------------------- */
	var menuToggle = doc.querySelector('[data-menu-toggle]');
	var menu = doc.getElementById('primary-menu');
	if (menuToggle && menu) {
		menuToggle.addEventListener('click', function () {
			var open = menu.classList.toggle('is-open');
			menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			doc.body.classList.toggle('is-menu-open', open);
		});
	}

	/* --- 2. Search bar toggle ------------------------------------------ */
	var searchToggle = doc.querySelector('[data-search-toggle]');
	var searchPanel = doc.getElementById('site-search');
	if (searchToggle && searchPanel) {
		searchToggle.addEventListener('click', function () {
			var open = searchPanel.hasAttribute('hidden');
			if (open) {
				searchPanel.removeAttribute('hidden');
				searchToggle.setAttribute('aria-expanded', 'true');
				var input = searchPanel.querySelector('input[type=search]');
				if (input) setTimeout(function () { input.focus(); }, 50);
			} else {
				searchPanel.setAttribute('hidden', '');
				searchToggle.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/* --- 3. First-paint reveal: hero on load --------------------------- */
	requestAnimationFrame(function () {
		doc.querySelectorAll('[data-reveal-stagger]').forEach(function (el) {
			el.classList.add('is-revealed');
		});
		// Reveal anything above the fold immediately to avoid pop-in.
		doc.querySelectorAll('[data-reveal]').forEach(function (el) {
			var rect = el.getBoundingClientRect();
			if (rect.top < window.innerHeight * 0.9) {
				el.classList.add('is-revealed');
			}
		});
	});

	/* --- 4. Scroll-triggered reveals (subtle, batched) ----------------- */
	if ('IntersectionObserver' in window && !prefersReduced) {
		var io = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-revealed');
					io.unobserve(entry.target);
				}
			});
		}, { rootMargin: '0px 0px -10% 0px', threshold: 0.05 });

		doc.querySelectorAll('[data-reveal]:not(.is-revealed)').forEach(function (el) { io.observe(el); });
	} else {
		// Fallback: reveal everything immediately.
		doc.querySelectorAll('[data-reveal]').forEach(function (el) { el.classList.add('is-revealed'); });
	}

	/* --- 5. TOC scroll-spy --------------------------------------------- */
	var tocLinks = doc.querySelectorAll('.toc__list a[href^="#"]');
	if (tocLinks.length && 'IntersectionObserver' in window) {
		var headings = [];
		tocLinks.forEach(function (a) {
			var id = a.getAttribute('href').slice(1);
			var h  = doc.getElementById(id);
			if (h) headings.push({ id: id, el: h, link: a });
		});
		var current = null;
		var spy = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					var id = entry.target.id;
					tocLinks.forEach(function (l) { l.parentElement.classList.toggle('is-active', l.getAttribute('href') === '#' + id); });
				}
			});
		}, { rootMargin: '-30% 0px -65% 0px' });
		headings.forEach(function (h) { spy.observe(h.el); });
	}

	/* --- 6. Smooth-scroll for in-page anchors -------------------------- */
	if (!prefersReduced) {
		doc.querySelectorAll('a[href^="#"]').forEach(function (a) {
			a.addEventListener('click', function (e) {
				var id = a.getAttribute('href');
				if (id.length > 1) {
					var target = doc.getElementById(id.slice(1));
					if (target) {
						e.preventDefault();
						target.scrollIntoView({ behavior: 'smooth', block: 'start' });
						target.setAttribute('tabindex', '-1');
						target.focus({ preventScroll: true });
					}
				}
			});
		});
	}

	/* --- 7. Copy share link -------------------------------------------- */
	doc.querySelectorAll('[data-copy-link]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var url = btn.getAttribute('data-url') || window.location.href;
			if (navigator.clipboard) {
				navigator.clipboard.writeText(url).then(function () {
					var prev = btn.getAttribute('aria-label');
					btn.setAttribute('aria-label', 'Link copied');
					btn.classList.add('is-copied');
					setTimeout(function () { btn.setAttribute('aria-label', prev || ''); btn.classList.remove('is-copied'); }, 1600);
				});
			}
		});
	});

	/* --- 8. Header shadow on scroll (tasteful, perf-cheap) ------------- */
	var header = doc.querySelector('.site-header');
	if (header) {
		var lastY = 0;
		var onScroll = function () {
			var y = window.scrollY;
			header.classList.toggle('is-scrolled', y > 8);
			lastY = y;
		};
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	/* --- 9. FAQ accordion ---------------------------------------------- */
	doc.querySelectorAll('[data-faq-toggle]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var expanded = btn.getAttribute('aria-expanded') === 'true';
			var answerId = btn.getAttribute('aria-controls');
			var answer   = answerId ? doc.getElementById(answerId) : null;
			btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
			if (answer) {
				if (expanded) {
					answer.setAttribute('hidden', '');
				} else {
					answer.removeAttribute('hidden');
				}
			}
		});
	});
})();

/* ─── Contact form — validation + AJAX submission ───────────────────────── */
(function () {
	'use strict';

	var form = document.getElementById('rawlaw-contact-form');
	if (!form) return;

	/* Validation patterns — must mirror RAWLAW_CONTACT_REGEX in contact-form.php */
	var PATTERNS = {
		contact_name:    /^[a-zA-Z\s.\-']{2,60}$/,
		contact_email:   /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/,
		contact_phone:   /^(\+91[\-\s]?)?[6-9]\d{9}$/,
	};

	function showError(field, msg) {
		var errEl = document.getElementById('err-' + field.name);
		if (errEl) {
			errEl.textContent = msg;
			errEl.hidden = false;
		}
		field.setAttribute('aria-invalid', 'true');
		field.classList.add('is-invalid');
	}

	function clearError(field) {
		var errEl = document.getElementById('err-' + field.name);
		if (errEl) {
			errEl.textContent = '';
			errEl.hidden = true;
		}
		field.removeAttribute('aria-invalid');
		field.classList.remove('is-invalid');
	}

	function validateField(field) {
		var val  = field.value.trim();
		var name = field.name;

		/* Required check */
		if (field.required && !val) {
			showError(field, 'This field is required.');
			return false;
		}

		/* Pattern checks */
		if (name === 'contact_name' && val && !PATTERNS.contact_name.test(val)) {
			showError(field, 'Please enter a valid name (2–60 characters, letters only).');
			return false;
		}
		if (name === 'contact_email' && val && !PATTERNS.contact_email.test(val)) {
			showError(field, 'Please enter a valid email address.');
			return false;
		}
		if (name === 'contact_phone' && val && !PATTERNS.contact_phone.test(val)) {
			showError(field, 'Please enter a valid 10-digit Indian mobile number.');
			return false;
		}
		if (name === 'contact_message') {
			var len = val.length;
			if (len < 20) {
				showError(field, 'Message is too short — please write at least 20 characters.');
				return false;
			}
			if (len > 2000) {
				showError(field, 'Message is too long — please keep it under 2000 characters.');
				return false;
			}
		}

		clearError(field);
		return true;
	}

	/* Live validation on blur + re-validate on input if already invalid */
	form.querySelectorAll('input, select, textarea').forEach(function (field) {
		field.addEventListener('blur', function () {
			validateField(field);
		});
		field.addEventListener('input', function () {
			if (field.classList.contains('is-invalid')) validateField(field);
		});
	});

	/* Character counter for message textarea */
	var msgField   = form.querySelector('[name="contact_message"]');
	var charCount  = document.getElementById('contact-message-count');
	if (msgField && charCount) {
		msgField.addEventListener('input', function () {
			charCount.textContent = msgField.value.length + ' / 2000';
		});
	}

	/* Form submit */
	form.addEventListener('submit', function (e) {
		e.preventDefault();

		/* Validate all fields */
		var fields  = form.querySelectorAll('input, select, textarea');
		var isValid = true;
		fields.forEach(function (f) {
			if (!validateField(f)) isValid = false;
		});
		if (!isValid) {
			var firstInvalid = form.querySelector('.is-invalid');
			if (firstInvalid) firstInvalid.focus();
			return;
		}

		/* Disable submit button while in-flight */
		var btn     = form.querySelector('[type="submit"]');
		var btnText = btn.textContent;
		btn.disabled = true;
		btn.textContent = 'Sending\u2026';

		/* Hide any previous global error */
		var globalErr = document.getElementById('contact-global-error');
		if (globalErr) globalErr.hidden = true;

		/* Build FormData and inject action + nonce */
		var data = new FormData(form);
		var cfg  = window.RawLawContact || {};
		data.append('action', 'rawlaw_contact_submit');
		data.append('nonce',  cfg.nonce || '');

		fetch(cfg.ajaxUrl || '/wp-admin/admin-ajax.php', {
			method:      'POST',
			body:        data,
			credentials: 'same-origin',
		})
		.then(function (res) { return res.json(); })
		.then(function (res) {
			if (res.success) {
				/* Replace form with success message */
				form.parentNode.innerHTML =
					'<div class="contact-success" role="status">' +
					'<div class="contact-success__icon" aria-hidden="true">&#10003;</div>' +
					'<h2>Message sent!</h2>' +
					'<p>' + res.data.message + '</p>' +
					'</div>';
			} else {
				/* Show global error */
				if (globalErr) {
					globalErr.textContent = res.data.message || 'Submission failed. Please try again.';
					globalErr.hidden = false;
				}
				/* Show field-level errors returned from server */
				if (res.data.fields) {
					Object.keys(res.data.fields).forEach(function (fieldName) {
						var f = form.querySelector('[name="' + fieldName + '"]');
						if (f) showError(f, res.data.fields[fieldName]);
					});
					var firstInvalid = form.querySelector('.is-invalid');
					if (firstInvalid) firstInvalid.focus();
				}
				btn.disabled    = false;
				btn.textContent = btnText;
			}
		})
		.catch(function () {
			if (globalErr) {
				globalErr.textContent = 'A network error occurred. Please check your connection and try again.';
				globalErr.hidden = false;
			}
			btn.disabled    = false;
			btn.textContent = btnText;
		});
	});
})();

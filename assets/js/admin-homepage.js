(function () {
	'use strict';

	var doc = document;
	var page = doc.querySelector('.rawlaw-home-settings');
	if (!page) return;
	page.classList.add('has-tabs');

	var tabs = Array.prototype.slice.call(page.querySelectorAll('[data-home-tab]'));
	var panels = Array.prototype.slice.call(page.querySelectorAll('[data-home-panel]'));
	var storageKey = 'rawlaw_home_active_panel';

	function setActivePanel(id) {
		var targetId = id || (tabs[0] ? tabs[0].getAttribute('href') : '');
		var hasPanel = panels.some(function (panel) {
			return '#' + panel.id === targetId;
		});
		if (!hasPanel) {
			targetId = tabs[0] ? tabs[0].getAttribute('href') : '';
		}
		tabs.forEach(function (tab) {
			var active = tab.getAttribute('href') === targetId;
			tab.classList.toggle('is-active', active);
			tab.setAttribute('aria-current', active ? 'page' : 'false');
		});
		panels.forEach(function (panel) {
			panel.classList.toggle('is-active', '#' + panel.id === targetId);
		});
		try {
			window.localStorage.setItem(storageKey, targetId);
		} catch (e) {}
	}

	var initial = window.location.hash && doc.querySelector(window.location.hash) ? window.location.hash : '';
	if (!initial) {
		try {
			initial = window.localStorage.getItem(storageKey) || '';
		} catch (e) {}
	}
	setActivePanel(initial);

	tabs.forEach(function (tab) {
		tab.addEventListener('click', function (event) {
			event.preventDefault();
			var target = tab.getAttribute('href');
			setActivePanel(target);
			if (target) {
				window.history.replaceState(null, '', target);
			}
		});
	});

	page.querySelectorAll('[data-count-field]').forEach(function (field) {
		var counter = page.querySelector('[data-count-for="' + field.id + '"]');
		if (!counter) return;
		function updateCount() {
			var max = parseInt(field.getAttribute('maxlength') || '0', 10);
			counter.textContent = max ? field.value.length + ' / ' + max : field.value.length;
		}
		field.addEventListener('input', updateCount);
		updateCount();
	});

	page.querySelectorAll('[data-media-target]').forEach(function (button) {
		button.addEventListener('click', function () {
			if (!window.wp || !window.wp.media) return;
			var targetId = button.getAttribute('data-media-target');
			var input = targetId ? doc.getElementById(targetId) : null;
			var preview = targetId ? page.querySelector('[data-media-preview="' + targetId + '"]') : null;
			var previewImage = preview ? preview.querySelector('img') : null;
			var frame = window.wp.media({
				title: 'Select homepage visual',
				button: { text: 'Use this image' },
				multiple: false
			});
			frame.on('select', function () {
				var attachment = frame.state().get('selection').first();
				if (!attachment || !input) return;
				var data = attachment.toJSON();
				input.value = data.url || '';
				if (preview && previewImage && data.url) {
					previewImage.src = data.url;
					preview.hidden = false;
				}
				input.dispatchEvent(new Event('change', { bubbles: true }));
			});
			frame.open();
		});
	});
})();

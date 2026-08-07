/**
 * Admin-only: SEO meta box character-count guidance + OG image picker.
 * Enqueued only on the post-editor screen, never on the public site.
 *
 * @package RawLaw
 */
(function ($) {
	'use strict';

	$(function () {
		/* --- Character-count guidance --- */
		$('[data-rawlaw-seo-counter]').each(function () {
			var $note   = $(this);
			var fieldId = $note.data('rawlaw-seo-counter');
			var ideal   = parseInt($note.data('rawlaw-seo-ideal'), 10) || 60;
			var $field  = $('#' + fieldId);
			var baseText = $note.text();

			if (!$field.length) { return; }

			function update() {
				var len = $field.val().length;
				var color = '#646970';
				if (len > ideal) {
					color = '#d63638';
				} else if (len >= Math.round(ideal * 0.7)) {
					color = '#2271b1';
				}
				$note.css('color', color);
				$note.attr('data-count', len + ' / ' + ideal);
				if (!$note.find('.rawlaw-seo-count').length) {
					$note.append(' <strong class="rawlaw-seo-count"></strong>');
				}
				$note.find('.rawlaw-seo-count').text('(' + len + '/' + ideal + ')');
			}

			$field.on('input', update);
			update();
		});

		/* --- OG image picker --- */
		var frame;
		var $input   = $('#_rawlaw_seo_og_image');
		var $preview = $('#_rawlaw_seo_og_image_preview');
		var $select  = $('#_rawlaw_seo_og_image_select');
		var $remove  = $('#_rawlaw_seo_og_image_remove');

		if ($select.length) {
			$select.on('click', function (e) {
				e.preventDefault();
				if (frame) { frame.open(); return; }
				frame = wp.media({
					title: 'Select social share image',
					multiple: false,
					library: { type: 'image' },
					button: { text: 'Use this image' }
				});
				frame.on('select', function () {
					var attachment = frame.state().get('selection').first().toJSON();
					$input.val(attachment.id);
					$preview.attr('src', attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url).show();
					$remove.show();
				});
				frame.open();
			});

			$remove.on('click', function (e) {
				e.preventDefault();
				$input.val('');
				$preview.hide();
				$remove.hide();
			});
		}
	});
})(jQuery);

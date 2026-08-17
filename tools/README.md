# tools/

Developer utilities. **Nothing here is loaded or executed by WordPress** —
these are build-time scripts kept in the repo so generated assets can be
reproduced rather than being one-off artefacts nobody can regenerate.

## verify-indexability.php

Exercises `inc/indexability.php` without WordPress, by stubbing the handful
of core functions it touches. Run it after changing the tag threshold, the
utility-page slug list, or either sitemap filter.

```bash
php tools/verify-indexability.php          # predicate + populated tag set — 33 assertions
php tools/verify-indexability.php empty    # the empty-tag-set branch — 26 assertions
```

Both must end `0 failed`. Two runs rather than one because
`rawlaw_indexable_tag_ids()` memoises in a function static — correct for a
real request, but it means a single process can only exercise one term set,
and the empty set is the branch worth proving: `WP_Term_Query` **ignores an
empty `include`**, so a threshold that no tag cleared would silently
re-admit every tag archive to the sitemap instead of excluding them all.

## make-og-images.py

Regenerates `assets/og/*.png` — the Open Graph / social-share cards
(1200x630 PNG) used by `rawlaw_shipped_og_image()` in `inc/seo-meta.php`.

```bash
python3 -m venv /tmp/ogvenv && /tmp/ogvenv/bin/pip install Pillow
/tmp/ogvenv/bin/python tools/make-og-images.py            # -> ./out-light
/tmp/ogvenv/bin/python tools/make-og-images.py --dark     # -> ./out-dark
```

Then copy the chosen set into `assets/og/`. **Light is what ships** — it
matches the site's own white/navy identity. The dark variant is kept
working so the two can be compared without rewriting anything.

### WhatsApp square crop — why the layout is centred

WhatsApp's compact link preview shows a **centre-cropped square**, not the
full 1.91:1 image. On a 1200x630 canvas that square is `x 285..915` and the
full height — so only the horizontal axis is ever cut. Every element is
therefore centred inside a 600px column (`SAFE_W`, spanning x 300..900),
which leaves ~15px of clearance inside the crop and means the whole
composition survives the square intact rather than being sliced.

Do not switch this back to a left-aligned layout without re-checking that
crop: left-aligned text starting near x=76 falls entirely outside the
square and disappears in WhatsApp's compact preview.

**To add a page:** append to the `PAGES` dict — the key must match the
WordPress page slug exactly, since `rawlaw_shipped_og_image()` resolves
`assets/og/<post_name>.png`. The `default` key is the site-wide fallback
(homepage, archives, posts with no featured image).

**Dependencies, deliberately noted:** this script reads two macOS system
fonts — `Iowan Old Style` (the hero headline serif, see `main.css`) and
Inter Tight from `~/Library/Fonts`. It will not run as-is on Linux/CI
without substituting those font paths. That is an accepted trade: the
alternative was bundling font binaries into the theme, and these assets
are regenerated rarely.

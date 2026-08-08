# Changelog

All notable changes to the `rawlaw` theme are documented here.
Format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
(spec 11 §Release). Dates are when the change shipped to production,
not when work started. Full narrative detail for any entry lives in
`docs/AUDIT.md`, keyed by the same date.

This file starts retroactively on 2026-08-07 (T-52) — entries before
that date are backfilled from `docs/AUDIT.md` at summary level; they
were not tracked here as they happened.

## [Unreleased]

## 2026-08-07

### Fixed
- `sitemap-news.xml` and the IndexNow key file returned a correct
  body but an HTTP 404 status, because WordPress queues a 404 before
  `template_redirect` runs for any path with no matching rewrite
  rule. Added `status_header(200)` to both virtual-endpoint branches
  in `inc/discoverability.php`.

## 2026-08-06

### Added
- Per-post SEO title/description/OG-image overrides and a site-wide
  default OG image (`inc/seo-meta.php`, `inc/customizer.php`,
  `assets/js/admin-seo.js`) — the theme's own replacement for
  Rank Math/Yoast output, which were removed from production.
- Migrated the 35 salvageable Rank Math title/description values into
  the new fields; deleted all `rank_math_*`/`_yoast_wpseo_*` postmeta
  and 12 orphaned plugin tables.

## 2026-08-05

### Added
- Owned `robots.txt` with an explicit AI-crawler policy (no training
  block) and a `Content-Signal` header.
- News sitemap (`/sitemap-news.xml`) and IndexNow ping on publish.
- `_rawlaw_kyc_status` as the real KYC state machine source of truth;
  `_rawlaw_verified` kept as an auto-derived legacy boolean.
- `_rawlaw_share_contact` opt-in and `rawlaw_contact_visible()` gate —
  advocate phone/email/Bar ID are masked unless the advocate opts in
  or the viewer is logged in (0.12).
- `RAWLAW_MARKETPLACE_LIVE` toggle gating the `/find-a-lawyer/`
  directory and homepage marketplace sections behind a "coming soon"
  state (0.10) — none of it is indexed while off.
- Bare `/news/` category URL, replacing `/category/news/`, with a 301
  from the old path and matching feed routes.

### Removed
- AMP support entirely (0.8) — plugin, templates, and all AMP-specific
  code. 301 redirects added for `?amp=1` and `/amp/` URL forms.
- The lawyer rating/review system (dead code on both the write and
  read side; product decision was no ratings at all, not a repair).

### Fixed
- Single-contact requirement submissions (email *or* phone) were being
  rejected because the validation required both (T-3).
- A PHP 8.2 fatal in `archive-lawyer.php` from `sanitize_title()`
  receiving an array (T-4 and related).
- `/news/feed/` was serving WordPress's default empty comment feed
  instead of the category feed.

## 2026-08-04 and earlier

### Added
- Initial theme build: homepage, lawyer marketplace templates, news/
  judgment content types, contact and post-a-requirement flows.

[Unreleased]: #

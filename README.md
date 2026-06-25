# RawLaw — premium WordPress theme

Editorial-first legal news theme with a verified lawyer marketplace. Built lean: classic PHP templates, a tokenised CSS design system, and progressive-enhancement JavaScript. No build step.

## Highlights
- **Editorial design** — Inter (sans-serif throughout), fluid type scale, generous prose layout, sticky TOC + share rail on articles.
- **Marketplace** — `lawyer` and `judgment` custom post types, taxonomies for practice areas, locations, and courts. Faceted search, sort, sticky CTA, ratings via comments, consultation enquiries.
- **SEO & schema** — automatic JSON-LD: NewsMediaOrganization, WebSite + SearchAction, NewsArticle, Attorney with AggregateRating, BreadcrumbList. Yoast primary-category aware.
- **Performance** — critical CSS inlined; deferred main stylesheet & JS; preconnect to font CDN; native lazy-loading; aspect-ratio reservations; minimal DOM.
- **Accessibility** — semantic landmarks, skip links, focus styles, full keyboard navigation, `aria-expanded` toggles, full `prefers-reduced-motion` honor.
- **Security** — disables XML-RPC, removes generator/RSD/wlwmanifest, escapes all output, nonce-protected forms, security headers, file editing disabled.

## Platform flow alignment
- RawLaw's public theme is the editorial trust and acquisition layer: news, guides, judgments, service pages, lawyer discovery surfaces, and SEO pages.
- Marketplace CTAs must support the content journey without overpowering it: article → related service → find lawyer / post query → consultation.
- Homepage order should preserve the article-first traffic engine before deeper marketplace modules: hero search, top news, featured/latest articles, trending topics, find legal help, services, featured lawyers, how it works, judgments, footer links.
- Unified search should route informational, service, lawyer, location, and complex legal-help intent to the right public template or workspace entry point.
- Full product and system flow references live in `app/public/docs/specs/PRD.md`, `SYSTEM_DESIGN.md`, and `PLATFORM_FLOW.md`.

## Activation
1. Folder is already installed at `wp-content/themes/rawlaw/`.
2. Appearance → Themes → **Activate**. Rewrites flush automatically (`after_switch_theme`).
3. Appearance → Menus → assign menus to: **Primary**, **Secondary**, **Footer**, **Marketplace**.
4. Appearance → Customize → **Brand & social** for tagline, social URLs, newsletter form action.
5. Appearance → Customize → **Homepage sections** to set CSV slugs of categories featured on the home page.
6. Posts → Categories: create your `news`, `analysis`, `judgments`, etc.
7. Lawyers → Add New: fill the meta-box (designation, firm, bar ID, languages, contact, consultation fee, verified, accepting clients).
8. Practice Areas / Locations / Courts under their respective menus.

## Recommended plugins (optional)
- **Yoast SEO** — primary-category support is wired in; sitemaps and OG tags handled by the plugin.
- **WP Super Cache / LiteSpeed** — for Core Web Vitals.
- **Wordfence** — application-layer hardening.

## Custom hooks
- `rawlaw_consult_after` — fires after a consultation enquiry is processed. `do_action('rawlaw_consult_after', $lawyer_id, $data)`.

## Tokens
Edit `assets/css/main.css` `:root` block to retheme. Editor and front-end share the palette.

## License
GPL-2.0-or-later.

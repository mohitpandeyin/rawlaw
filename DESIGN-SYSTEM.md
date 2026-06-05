# RawLaw Design System

> Premium editorial theme for an Indian legal marketplace.  
> PHP 8.1+ · Vanilla CSS (custom properties) · AMP-compatible · Inter typeface

---

## Table of Contents

1. [Color Tokens](#color-tokens)
2. [Typography](#typography)
3. [Spacing Scale](#spacing-scale)
4. [Radii & Borders](#radii--borders)
5. [Shadows](#shadows)
6. [Motion](#motion)
7. [Layout](#layout)
8. [Buttons](#buttons)
9. [Icon System](#icon-system)
10. [Components](#components)
11. [CSS Architecture](#css-architecture)
12. [Helper Functions](#helper-functions)
13. [Design Rules](#design-rules)
14. [Responsive Breakpoints](#responsive-breakpoints)

---

## Color Tokens

| Token              | Value       | Usage                                |
|--------------------|-------------|--------------------------------------|
| `--ink`            | `#0B1220`   | Primary text, headings               |
| `--ink-soft`       | `#1E2A3A`   | Softer body copy                     |
| `--paper`          | `#FFFFFF`   | Page background                      |
| `--surface`        | `#FFFFFF`   | Card/component surface               |
| `--surface-alt`    | `#F5F8FC`   | Subtle alternate backgrounds         |
| `--navy`           | `#1A3F72`   | Brand primary, links, accents        |
| `--navy-700`       | `#112E56`   | CTA buttons, deeper emphasis         |
| `--muted`          | `#55657C`   | Secondary text, timestamps           |
| `--muted-2`        | `#7D8A9D`   | Placeholder text                     |
| `--border`         | `#DCE4EE`   | Default borders, dividers            |
| `--border-strong`  | `#C9D4E2`   | Emphasized borders                   |
| `--success`        | `#2F7A4D`   | Verified badges, positive states     |
| `--danger`         | `#B23A3A`   | Error states                         |

### Palette Philosophy
- **No gold/warm accents** — palette is cool blue + ink.
- Only the footer uses dark backgrounds (navy/ink). All page sections stay light.
- Accent hierarchy: `--navy-700` (CTAs) → `--navy` (links, highlights) → `--ink` (text).

---

## Typography

### Font Stack

```css
--font-sans: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
--font-display: var(--font-sans);
```

The hero headline uses a serif override for editorial feel:
```css
font-family: "Iowan Old Style", "Palatino Linotype", Palatino, "Times New Roman", serif;
```

### Type Scale (fluid clamp)

| Token          | Min    | Max    | Usage                       |
|----------------|--------|--------|-----------------------------|
| `--fs-xs`      | 12px   | 13px   | Captions, labels            |
| `--fs-sm`      | 13px   | 14px   | Small UI text               |
| `--fs-base`    | 15px   | 17px   | Body copy                   |
| `--fs-md`      | 17px   | 19px   | Lead text                   |
| `--fs-lg`      | 20px   | 24px   | Section subtitles           |
| `--fs-xl`      | 24px   | 32px   | Card titles, h3             |
| `--fs-2xl`     | 30px   | 44px   | Section headings, h2        |
| `--fs-3xl`     | 36px   | 60px   | Page titles, h1             |
| `--fs-display` | 44px   | 88px   | Hero headline               |

### Heading Defaults
- `font-family: var(--font-display)`
- `color: var(--ink)`
- `line-height: 1.18`
- `letter-spacing: -.02em`
- `font-weight: 700`

### Body Defaults
- `font: 400 var(--fs-base)/1.65 var(--font-sans)`
- `-webkit-font-smoothing: antialiased`

---

## Spacing Scale

| Token   | Value  | Typical Use                    |
|---------|--------|--------------------------------|
| `--s-1` | 4px    | Micro gaps                     |
| `--s-2` | 8px    | Tight inline gaps              |
| `--s-3` | 12px   | Component inner padding        |
| `--s-4` | 16px   | Standard gap                   |
| `--s-5` | 24px   | Section inner spacing          |
| `--s-6` | 32px   | Medium breathing room          |
| `--s-7` | 48px   | Section padding                |
| `--s-8` | 64px   | Large section padding          |
| `--s-9` | 96px   | Hero/CTA vertical space        |
| `--s-10`| 128px  | Maximum section spacing        |

---

## Radii & Borders

| Token    | Value  | Usage                           |
|----------|--------|---------------------------------|
| `--r-sm` | 4px    | Tags, chips                     |
| `--r-md` | 8px    | Cards, inputs                   |
| `--r-lg` | 12px   | Containers, modals              |
| `--r-xl` | 20px   | Hero sections, large panels     |
| `--bw`   | 1px    | Default border-width            |

Buttons use `border-radius: 999px` (pill shape).

---

## Shadows

| Token         | Value                                                   | Usage               |
|---------------|---------------------------------------------------------|---------------------|
| `--shadow-sm` | `0 1px 2px rgba(11,18,32,.04), 0 0 0 1px rgba(...)` | Subtle card rest    |
| `--shadow-md` | `0 6px 24px -8px rgba(11,18,32,.10), ...`            | Card hover          |
| `--shadow-lg` | `0 24px 60px -20px rgba(11,18,32,.18), ...`          | Modals, hero cards  |

---

## Motion

| Token        | Value                             | Usage                    |
|--------------|-----------------------------------|--------------------------|
| `--ease-soft`| `cubic-bezier(.22,.61,.36,1)`     | General transitions      |
| `--ease-out` | `cubic-bezier(.16,1,.3,1)`        | Exit / reveal animations |
| `--dur-fast` | `160ms`                           | Hover, color change      |
| `--dur-mid`  | `280ms`                           | Expand, slide            |
| `--dur-slow` | `520ms`                           | Image zoom, scroll fx    |

### AMP Compatibility
No inline JavaScript. Use CSS-only animations and `data-reveal` / `data-reveal-stagger` attributes for scroll animations.

---

## Layout

| Token               | Value    | Usage               |
|---------------------|----------|---------------------|
| `--container`       | 1240px   | Main content width  |
| `--container-prose` | 720px    | Article body width  |

```css
.container { width: 100%; max-width: var(--container); margin: 0 auto; padding: 0 24px; }
.container--prose { max-width: var(--container-prose); }
```

---

## Buttons

### Variants

| Class          | Appearance                                  |
|----------------|---------------------------------------------|
| `.btn--primary`| Navy-700 bg, white text, pill shape         |
| `.btn--ghost`  | Transparent bg, border, ink text            |

### Sizes

| Class      | Padding       | Font Size |
|------------|---------------|-----------|
| `.btn--sm` | 9px 14px      | 13px      |
| (default)  | 12px 20px     | 14px      |
| `.btn--lg` | 16px 28px     | 16px      |

### Modifiers
- `.btn--block` — full width
- `.icon-btn` — 40×40 circle icon-only button
- `.link-arrow` — text link with animated arrow

---

## Icon System

Icons are inline SVGs stored in `assets/icons/` and rendered via the `rawlaw_icon()` PHP helper.

### Available Icons

| Name              | File                    |
|-------------------|-------------------------|
| chat              | `chat.svg`              |
| clock             | `clock.svg`             |
| drafts            | `drafts.svg`            |
| facebook          | `facebook.svg`          |
| globe             | `globe.svg`             |
| instagram         | `instagram.svg`         |
| link              | `link.svg`              |
| linkedin          | `linkedin.svg`          |
| lock              | `lock.svg`              |
| news              | `news.svg`              |
| pin               | `pin.svg`               |
| search            | `search.svg`            |
| shield-checkmark  | `shield-checkmark.svg`  |
| twitter           | `twitter.svg`           |
| user              | `user.svg`              |
| verified          | `verified.svg`          |
| whatsapp          | `whatsapp.svg`          |
| youtube           | `youtube.svg`           |

### Usage
```php
<?php rawlaw_icon( 'search', 'optional-class' ); ?>
```

---

## Components

### Cards
- White background (`--surface`)
- No heavy border — rely on spacing and typography hierarchy
- Subtle hover opacity shift on images
- No border-radius on editorial/newspaper images (squared)

### Newspaper Grid (News & Insights)
Three-zone layout:
- **Zone A (top):** Lead story (large image + headline) + stacked text-only briefs with vertical column rule
- **Zone B (middle):** 4-column image stories with vertical column rules between columns
- **Zone C (bottom):** Dense text-only headline row (3 columns)

### Ticker (Breaking News)
- Navy label pill left
- Horizontally scrolling marquee (CSS `@keyframes`)
- Thin outer border, `--r-md` radius

### Hero (Front Page)
- Two-column: search/headline left, top news right
- Serif headline, fluid `clamp()` sizing
- Unified search input (pill-shaped, 1-field)
- Subtle radial gradient background

### Header
- Sticky, white, blur backdrop
- 1px bottom border
- Logo left, nav center, actions right
- Underline active menu items via `::after`

### Footer
- Dark editorial (navy/ink gradient)
- 4-column link grid
- Social icons row
- Mono logo variant

---

## CSS Architecture

Single file: `assets/css/main.css`  
Critical above-the-fold subset: `assets/css/critical.css`  
Editor parity: `assets/css/editor.css`

### Section Index

| #  | Section                              |
|----|--------------------------------------|
| 1  | Tokens (custom properties)           |
| 2  | Reset & base                         |
| 3  | Layout primitives                    |
| 4  | Buttons & links                      |
| 5  | Header / nav                         |
| 6  | Search form                          |
| 7  | Breadcrumbs                          |
| 8  | Ticker                               |
| 9  | Hero (front page)                    |
| 10 | Grids                                |
| 11 | Article cards                        |
| 12 | Meta                                 |
| 13 | Tags / chips / badges                |
| 14 | Single article                       |
| 15 | Footer                               |
| 17 | Archive headers                      |
| 18 | Author archive                       |
| 19 | Judgments                            |
| 20 | Marketplace                          |
| 21 | Pagination                           |
| 22 | Motion utilities                     |
| 23 | Marketplace teaser (front-page)      |
| 24 | Services for Advocates page          |
| 25 | Homepage — redesigned components     |

---

## Helper Functions

| Function                       | Purpose                                      |
|--------------------------------|----------------------------------------------|
| `rawlaw_icon($name, $class)`   | Output inline SVG from `assets/icons/`       |
| `rawlaw_logo($variant)`        | Output site logo ('mark' or 'full')          |
| `rawlaw_category_eyebrow()`    | Category label above articles                |
| `rawlaw_article_meta($args)`   | Post meta (date, reading time, author)       |
| `rawlaw_reading_time()`        | Estimated reading time                       |
| `rawlaw_is_amp()`              | Check if current request is AMP              |
| `rawlaw_breadcrumbs()`         | Structured breadcrumb navigation             |
| `rawlaw_verified_badge($id)`   | Verified lawyer badge with icon              |
| `rawlaw_lawyer_rating($id)`    | Average review rating                        |

---

## Design Rules

1. **No dark sections** — only the footer uses dark backgrounds. All page sections use `--paper`, `--surface`, or `--surface-alt`.
2. **No emoji in UI** — use SVG icons via `rawlaw_icon()`.
3. **No gold/warm accents** — brand is cool blue + ink only.
4. **Accessibility** — semantic HTML, 4.5:1 contrast minimum, `aria-hidden="true"` on decorative elements, `:focus-visible` support.
5. **Typography hierarchy** — uppercase eyebrows (11-12px, letter-spacing .12em+), display headings use serif, body uses Inter.
6. **Illustrations** — CSS-only decorative elements (gradients, pseudo-elements). No external images for decoration.
7. **AMP-compatible** — no inline JavaScript. CSS-only animations.
8. **Buttons are pills** — `border-radius: 999px` on all button variants.
9. **Editorial images** — no border-radius (squared crops for newspaper feel).
10. **Column rules** — vertical `1px solid var(--border)` between adjacent editorial columns (newspaper grid convention).

---

## Responsive Breakpoints

| Breakpoint | Target                          |
|------------|---------------------------------|
| ≤ 1024px   | Tablet landscape               |
| ≤ 880px    | Nav collapses to hamburger     |
| ≤ 768px    | Tablet portrait, stacked grids |
| ≤ 600px    | Large phone                    |
| ≤ 480px    | Small phone                    |
| ≤ 420px    | Compact phone                  |

### Grid Collapse Pattern
- 4 cols → 2 cols → 1 col (news, marketplace)
- Hero 2-col → stacked at 880px
- Footer 4-col → 2-col → 1-col

---

## File Structure

```
rawlaw/
├── assets/
│   ├── css/
│   │   ├── main.css          ← All styles (tokens → components → pages)
│   │   ├── critical.css      ← Above-the-fold subset
│   │   └── editor.css        ← Gutenberg editor parity
│   ├── icons/                ← SVG icon library
│   ├── js/
│   │   └── marquee.js        ← GSAP + ScrollTrigger for features bar
│   └── media/
│       ├── rawlaw-logo.svg
│       └── rawlaw-logo-mono.svg
├── inc/
│   ├── amp.php               ← AMP compatibility layer
│   ├── breadcrumbs.php
│   ├── cpt.php               ← Custom post types (lawyer, etc.)
│   ├── customizer.php
│   ├── enqueue.php           ← Asset loading + critical CSS
│   ├── marketplace.php       ← Lawyer archive/filtering logic
│   ├── meta-boxes.php        ← Lawyer fields, Top News toggle
│   ├── schema.php            ← JSON-LD structured data
│   ├── search-router.php     ← Smart search routing
│   ├── setup.php             ← Theme support, editor palette
│   └── template-tags.php     ← Icons, meta, reading time helpers
├── template-parts/
│   ├── home/                 ← Homepage sections
│   ├── components/           ← Reusable partials
│   ├── article/              ← Single post partials
│   └── lawyer/               ← Lawyer profile partials
├── page-templates/           ← Custom page templates
├── front-page.php
├── footer.php
├── functions.php
└── style.css                 ← Theme metadata only
```

#!/usr/bin/env python3
"""
Generate RawLaw Open Graph images (1200x630 PNG).

Why PNG at 1200x630: that is the 1.91:1 ratio Facebook/LinkedIn/X crop to,
and WhatsApp link previews need a raster format (it will not render SVG).

WHATSAPP SQUARE-CROP CONSTRAINT
-------------------------------
WhatsApp has two preview forms. The rich preview shows the full 1.91:1
image, but the compact/list form shows a small CENTRE-CROPPED SQUARE.
On a 1200x630 canvas that square is:

    x in [285, 915]   (630 wide, centred)
    y in [0, 630]     (the full height — the canvas is already 630 tall)

So only the HORIZONTAL axis is ever cut. Everything meaningful therefore
lives in a centred column no wider than SAFE_W, which keeps the whole
composition intact in the square and simply loses empty margin. That is
why this layout is centre-aligned rather than the more conventional
left-aligned social card.

Typography mirrors the live site:
  - Iowan Old Style -> the hero headline serif (main.css:867 font stack)
  - Inter Tight     -> stands in for Inter (main.css --font-sans)
Colours are the tokens from main.css:8-22.
"""

import os
import sys
from PIL import Image, ImageDraw, ImageFont

W, H = 1200, 630

# Centre square that WhatsApp's compact preview keeps.
SQUARE = 630
SQ_X0, SQ_X1 = (W - SQUARE) // 2, (W + SQUARE) // 2   # 285 .. 915
# Content column, inset from the square so nothing touches the crop edge.
# 600 centred spans x 300..900, i.e. 15px of clearance inside the 285..915
# square on each side.
SAFE_W = 600
COL_X0, COL_X1 = (W - SAFE_W) // 2, (W + SAFE_W) // 2

# --- brand tokens (assets/css/main.css :root) ---------------------------
INK        = (11, 18, 32)      # --ink         #0B1220
NAVY       = (26, 63, 114)     # --navy        #1A3F72
NAVY_700   = (17, 46, 86)      # --navy-700    #112E56
PAPER      = (255, 255, 255)   # --paper       #FFFFFF
SURFACE_ALT= (245, 248, 252)   # --surface-alt #F5F8FC
MUTED      = (85, 101, 124)    # --muted       #55657C
BORDER     = (220, 228, 238)   # --border      #DCE4EE
WHITE      = (255, 255, 255)
ACCENT_DK  = (122, 165, 224)   # --navy lifted, for legibility on ink

SERIF_TTC  = "/System/Library/Fonts/Supplemental/Iowan Old Style.ttc"
SERIF_BOLD = 1                 # face index inside the .ttc
INTER_DIR  = os.path.expanduser("~/Library/Fonts")


class Palette:
    def __init__(self, light):
        self.light = light
        if light:
            self.bg_a, self.bg_b = PAPER, SURFACE_ALT
            self.title   = INK
            self.mark    = INK
            self.tld     = NAVY
            self.tagline = MUTED
            self.eyebrow = NAVY
            self.rule    = BORDER
            self.foot    = MUTED
            self.accent  = NAVY
            self.grid    = (26, 63, 114, 10)
            self.glow    = NAVY
            self.glow_a  = 26
        else:
            self.bg_a, self.bg_b = INK, NAVY_700
            self.title   = WHITE
            self.mark    = WHITE
            self.tld     = ACCENT_DK
            self.tagline = (143, 166, 196)
            self.eyebrow = ACCENT_DK
            self.rule    = (38, 52, 78)
            self.foot    = (143, 166, 196)
            self.accent  = ACCENT_DK
            self.grid    = (255, 255, 255, 7)
            self.glow    = NAVY
            self.glow_a  = 92


def inter(weight, size):
    name = "regular" if weight == 400 else str(weight)
    return ImageFont.truetype(f"{INTER_DIR}/inter-tight-v7-latin-{name}.ttf", size)


def serif(size):
    return ImageFont.truetype(SERIF_TTC, size, index=SERIF_BOLD)


def tracked_w(d, s, font, tracking):
    return sum(d.textlength(c, font=font) for c in s) + tracking * max(len(s) - 1, 0)


def draw_tracked_centred(d, cx, y, s, font, fill, tracking):
    x = cx - tracked_w(d, s, font, tracking) / 2
    for c in s:
        d.text((x, y), c, font=font, fill=fill)
        x += d.textlength(c, font=font) + tracking


def wrap(d, s, font, max_w):
    words, lines, cur = s.split(), [], ""
    for w in words:
        trial = f"{cur} {w}".strip()
        if d.textlength(trial, font=font) <= max_w or not cur:
            cur = trial
        else:
            lines.append(cur)
            cur = w
    if cur:
        lines.append(cur)
    return lines


def background(p):
    img = Image.new("RGB", (W, H), p.bg_a)

    # Diagonal wash toward the secondary tone, strongest bottom-right.
    grad = Image.new("L", (W, H))
    g = grad.load()
    for y in range(H):
        for x in range(0, W, 2):
            t = (x / W) * 0.45 + (y / H) * 0.55
            v = int(max(0.0, min(1.0, t)) * (255 if p.light else 150))
            g[x, y] = v
            if x + 1 < W:
                g[x + 1, y] = v
    img = Image.composite(Image.new("RGB", (W, H), p.bg_b), img, grad)

    # Soft radial glow, top-centre — reinforces the centred composition and
    # stays inside the square crop.
    glow = Image.new("L", (W, H), 0)
    gl = glow.load()
    cx, cy, r = W * 0.5, H * 0.02, 620.0
    for y in range(0, H, 2):
        for x in range(0, W, 2):
            dist = (((x - cx) ** 2 + (y - cy) ** 2) ** 0.5) / r
            v = int(max(0.0, 1.0 - dist) ** 2 * p.glow_a)
            for dy in (0, 1):
                for dx in (0, 1):
                    if x + dx < W and y + dy < H:
                        gl[x + dx, y + dy] = v
    img = Image.composite(Image.new("RGB", (W, H), p.glow), img, glow)

    # Faint 48px grid, echoing the homepage hero decor.
    ov = Image.new("RGBA", (W, H), (0, 0, 0, 0))
    od = ImageDraw.Draw(ov)
    for x in range(0, W, 48):
        od.line([(x, 0), (x, H)], fill=p.grid)
    for y in range(0, H, 48):
        od.line([(0, y), (W, y)], fill=p.grid)
    return Image.alpha_composite(img.convert("RGBA"), ov).convert("RGB")


def build(title, eyebrow, out_path, light=True, show_tagline=True):
    p = Palette(light)
    img = background(p)
    d = ImageDraw.Draw(img)
    cx = W // 2

    # ---- wordmark lockup, centred ---------------------------------------
    y = 84
    f_mark = inter(800, 42)
    f_tld = inter(700, 27)
    w_mark = d.textlength("RawLaw", font=f_mark)
    w_tld = d.textlength(".in", font=f_tld)
    x = cx - (w_mark + w_tld) / 2
    d.text((x, y), "RawLaw", font=f_mark, fill=p.mark)
    d.text((x + w_mark + 2, y + 14), ".in", font=f_tld, fill=p.tld)

    ty = y + 58
    if show_tagline:
        # Rules either side of the tagline, mirroring the real logo lockup.
        f_tag = inter(600, 12)
        tag = "UNFILTERED LEGAL INSIGHTS"
        tw = tracked_w(d, tag, f_tag, 3.0)
        draw_tracked_centred(d, cx, ty, tag, f_tag, p.tagline, 3.0)
        for x0, x1 in ((cx - tw / 2 - 46, cx - tw / 2 - 14),
                       (cx + tw / 2 + 14, cx + tw / 2 + 46)):
            d.line([(x0, ty + 7), (x1, ty + 7)], fill=p.rule, width=1)
        ty += 20

    # ---- eyebrow + title, centred inside the safe column ----------------
    # Prefer a balanced 2-line break over the largest possible type: at this
    # column width the greedy "biggest that fits in 3 lines" choice strands a
    # single word on the last line, whereas dropping a few px breaks cleanly
    # at the conjunction. Only fall back to 3 lines if 2 would mean going
    # below ~46px, which starts to read small in the compact square.
    def fit(max_lines, floor):
        for s in range(64, floor - 1, -2):
            f = serif(s)
            L = wrap(d, title, f, SAFE_W)
            if len(L) <= max_lines:
                return f, L, s
        return None

    chosen = fit(2, 46) or fit(3, 36)
    if chosen:
        f_title, lines, size = chosen
    else:
        size = 36
        f_title = serif(size)
        lines = wrap(d, title, f_title, SAFE_W)[:3]

    lh = int(size * 1.18)
    eyebrow_gap = 40
    block_h = eyebrow_gap + lh * len(lines)

    zone_top, zone_bottom = ty + 26, H - 96
    ey = zone_top + ((zone_bottom - zone_top) - block_h) / 2

    f_eye = inter(700, 14)
    draw_tracked_centred(d, cx, ey, eyebrow.upper(), f_eye, p.eyebrow, 2.6)

    ty0 = ey + eyebrow_gap
    for i, line in enumerate(lines):
        lw = d.textlength(line, font=f_title)
        d.text((cx - lw / 2, ty0 + i * lh), line, font=f_title, fill=p.title)

    # ---- footer ---------------------------------------------------------
    fy = H - 74
    d.line([(COL_X0, fy), (COL_X1, fy)], fill=p.rule, width=1)
    f_foot = inter(600, 15)
    fw = d.textlength("rawlaw.in", font=f_foot)
    d.text((cx - fw / 2, fy + 16), "rawlaw.in", font=f_foot, fill=p.foot)

    img.save(out_path, "PNG", optimize=True)
    return out_path


# slug -> (display title, eyebrow, show_lockup_tagline).
# The key must match the WordPress page slug exactly — rawlaw_shipped_og_image()
# resolves assets/og/<post_name>.png. "default" is the site-wide fallback.
#
# Deliberately NOT listed: contact, privacy-policy, terms-and-conditions and
# cancellation-refund-policy. Those are boilerplate legal/utility pages where
# a bespoke card earns nothing, so they fall through to `default` — which is
# automatic, since rawlaw_shipped_og_image() only returns a slug match when
# the file exists. Adding a key back here is all it takes to reinstate one.
PAGES = {
    # The default card suppresses the lockup tagline: its title already
    # carries the "unfiltered legal insights" line, and printing that phrase
    # twice on one card reads as a mistake.
    #
    # Comma before "and" dropped: it joins two noun phrases, not two clauses
    # or a 3+ item list, so it is not standard punctuation. Revert to
    # "insights, and legal" if the pause is wanted as a deliberate device.
    "default": ("Unfiltered legal insights and legal support.",
                "Legal news & analysis", False),
    "raw-law": ("Legal news, aid and awareness.", "About RawLaw", True),
    "legal-drafting-and-research-support-services-for-advocates": (
        "Legal Drafting & Research Support", "For advocates", True),
}


if __name__ == "__main__":
    light = "--dark" not in sys.argv
    base = os.path.dirname(os.path.abspath(__file__))
    out_dir = os.path.join(base, "out-light" if light else "out-dark")
    os.makedirs(out_dir, exist_ok=True)
    for slug, (title, eyebrow, tagline) in PAGES.items():
        p = build(title, eyebrow, os.path.join(out_dir, f"{slug}.png"),
                  light=light, show_tagline=tagline)
        print(f"{os.path.getsize(p)/1024:7.1f} KB  {os.path.basename(p)}")
    print(f"-> {out_dir}")

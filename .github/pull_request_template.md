<!--
Required by docs/specs/11-development-rules.md ("PR checklist (blocking)").
Some items below reference tooling (CI, PHPUnit, axe-core, phpcs) that
doesn't exist yet in this repo (tracked as T-41 / T-52 in
docs/theme-fixes/01-defect-register.md). Until that tooling exists,
treat those boxes as "I did this manually" rather than "a bot verified
this" — say how in the verification section below.
-->

## What & why

<!-- One or two sentences. Link the relevant docs/specs/ or docs/seo-plan/ item if there is one. -->

## Checklist

- [ ] `docs/AUDIT.md` updated with an entry, if this changes behaviour, data, or a prior decision
- [ ] No new post meta / option key without a matching entry in `docs/specs/10-database.md`
- [ ] No new public-facing route/URL without an entry in `docs/seo-plan/` or `docs/specs/07-seo.md`
- [ ] Strings are translatable (`__()` / `_e()`, `rawlaw` text domain) and escaped on output / sanitized on input
- [ ] Nonce + `current_user_can()` check on every state-changing action
- [ ] Coding standards followed (phpcs/WPCS conventions) — no automated gate yet, reviewer eyeballs this
- [ ] Reviewer assigned; a second reviewer added if this touches `inc/security.php`, advocate PII, or KYC/verification logic

## How was this verified?

<!--
No CI yet — say what you actually did: local URL(s) tested, curl output,
screenshot, or "n/a, doc-only change".
-->

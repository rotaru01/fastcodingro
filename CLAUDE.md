# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Static marketing website for **Fast Coding Agency** (fastcodingagency.ro) — a Romanian software development agency. Built with vanilla HTML, Tailwind CSS (CDN), and plain JavaScript. No build system, no package manager, no frameworks.

## Deployment

- **Auto-deploys** on push to `master` via GitHub Actions (`.github/workflows/deploy.yml`)
- Uses FTP deployment (`SamKirkland/FTP-Deploy-Action@v4.3.5`) to `fastcodingagency.ro`
- FTP credentials stored in GitHub Secrets: `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`
- No build step — files are deployed as-is

## Architecture

```
index.html          — Main homepage (hero, portfolio, services, contact form, chat widget)
about.html          — Company info (AMZ Werrox SRL, CUI: 39180179)
privacy.html        — GDPR privacy policy
terms.html          — Terms & conditions
css/style.css       — Custom animations (slide-up, pulse-dot, bounce-dot) + Google Fonts imports
js/main.js          — All JS: navbar, mobile menu, contact form, AI chat widget, cookie consent
images/             — Static assets
progress/server68/  — Client progress page
```

## Key Integration Points

- **Backend API**: `https://fast-coding-agency--fast-coding-d1143.europe-west4.hosted.app`
  - `POST /api/contact` — contact form submissions
  - `POST /api/chat` — AI chat widget (Claude-powered, Romanian language)
- **Google Analytics**: GA4 tag `G-ZW0EZSH2SS`
- **Leadsy AI**: Lead generation widget embedded in pages
- **Cookie consent**: Managed via localStorage (`cookieConsent` key)

## Development Notes

- All styling uses Tailwind utility classes inline; `css/style.css` only handles animations and font imports
- The site is in **Romanian** — all user-facing text should remain in Romanian
- No local dev server configured — open HTML files directly or use any static server
- No tests or linting configured

# CRM Software Nepal — Build Status

## ⚠️ Two things I couldn't do because inputs were missing
1. **No existing CodeIgniter 4 codebase was uploaded.** This is a fresh CI4-structured
   scaffold, not an extension of your real site. Once you share the actual repo, the
   next pass should merge into it rather than replace it.
2. **No `logo.png` was uploaded**, so I could not extract real brand colors. The theme
   uses a **placeholder** palette (deep teal `#0F6E63` + warm orange `#F2994A`) defined
   entirely in `public/assets/css/theme.css`. Every color in the site references those
   CSS variables, so swapping to your real logo colors later is a one-file edit.

## What's built in this pass (Build Order steps 1–2, plus the two forms from step 3)

**Step 1 — Structure & theme**
- CI4-standard folder layout (`app/`, `public/index.php`, `app/Config/Routes.php`, `app/Config/Paths.php`)
- `composer.json` declaring the CodeIgniter 4 framework dependency
- `theme.css` (color/font/spacing variables) + `style.css` (all component styles)
- `database/schema.sql` — the minimum table list from Part 3 (leads, clients,
  demo_requests, contact_inquiries, subscriptions, payments, invoices,
  support_tickets, testimonials, faqs, blog_posts, blog_categories, users, activity_logs)
- `robots.txt` (admin disallowed, sitemap referenced — `sitemap.xml` itself is
  generated from published blog/page data, so it's deferred to the CMS pass)

**Step 2 — Public homepage, nav, footer**
- `app/Views/partials/nav.php` — sticky nav with all required links + Request a Demo CTA
- `app/Views/partials/footer.php` — Company / Product / Resources / Legal / Contact columns
- `app/Views/pages/home.php` via `Home::index()` — hero, trust stats (marked `TBD`),
  10 pain points, 7 feature groups, 5-step "How It Works", 8-tile screenshot
  placeholder grid, CTA band. Fully responsive.

**Step 3 (partial) — Demo request & contact forms**
- `Pages::demo()` / `Pages::demoSubmit()` and `Pages::contact()` / `Pages::contactSubmit()`
  with full field sets, CSRF (`csrf_field()`), and CI4 server-side validation rules.
- **Not yet wired**: actual DB save, lead auto-creation, admin notification, confirmation
  email, and follow-up task creation — each is marked with a `// TODO (next pass)` in
  `app/Controllers/Pages.php` pointing at exactly what model/service to add.
- About Us page is fully written (with `TBD` marker on the copy itself — replace
  with approved company content).
- Features, Solutions, Pricing, FAQ, and Blog routes exist and render a clearly
  labeled "coming soon" placeholder — each depends on the admin Content CMS
  (Part 2, item 13) so building the final version now would mean immediately
  rebuilding it once the CMS models exist.
- Legal pages (Privacy/Terms/Refund/Cookie) exist as routed pages with placeholder
  copy, ready for either static text or later CMS wiring.

## Not yet built (per your build order, this is next)
- Testimonials CRUD + display, FAQ CMS, full Blog CMS
- Admin login (with CAPTCHA, lockout, login logging, session timeout)
- Admin dashboard (KPI cards + charts + activity feed) — the most important screen,
  and correctly the next thing to build per your instructions
- Admin modules: Leads, Clients, Pipeline (kanban), Payments/Invoices, Demo Requests,
  Support Tickets, User Management, Content CMS, Reports
- Wiring the demo/contact form TODOs above into real models + email

## A note on running this
This sandbox has no network access to Packagist, so I could not run
`composer install` to pull the actual CodeIgniter 4 framework into `/vendor`.
The code here is written in standard CI4 idiom (namespaced controllers, `Routes.php`,
`view()` calls) so it will run as-is once you:

```bash
composer install
cp .env.example .env
# edit .env with your DB + mail credentials
mysql -u root -p your_db < database/schema.sql
php spark serve
```

## What still needs real data before launch
- Real logo.png → extracted hex colors in `theme.css`
- Real trust stats (client count, years in business, leads managed, uptime)
- Real product screenshots (8 placeholders in the homepage screenshots grid)
- Real testimonials, FAQ content, About Us copy, legal policy text
- Real company address/phone in the footer

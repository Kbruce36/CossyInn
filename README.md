# The Cosy Inn Kiwenda

Website for The Cosy Inn Kiwenda, Wakiso District, Uganda.

Plain PHP 8, no database, no framework. Upload `public_html/` to any cPanel
host and it runs. It also deploys to a static host such as Netlify, by
rendering the pages to HTML first; see **Deploying** below.

---

## Before you go live

Six things are placeholders. The site works without changing them, but it will
be wrong in public until you do. All of them live in **one file**:
`public_html/includes/config.php`.

| What | Current value | Why it matters |
|---|---|---|
| Domain | `https://www.cosyinnkiwenda.com` | Every canonical URL, the sitemap and all Open Graph tags are built from this. Set it the day you buy the domain. |
| Second phone line | `+256 772 000 000` | Invented. Replace it or delete the constant. |
| Email | `info@cosyinnkiwenda.com` | Invented. Create a real mailbox on your domain. |
| GPS pin | `0.48330, 32.60000` | **Approximate.** A wrong pin sends guests to the wrong place and stops Google matching this site to your Business Profile. Check it on Google Maps and paste the real figures. |
| Social links | all `#` | Placeholder links render as greyed-out buttons and are left out of the structured data, so nothing breaks. Paste the real profile URLs when ready. |
| Room rates | all three at `$50` | You gave one rate, so all three tiers show `$50`. Three tiers at the same price gives a guest no reason to pick the dearer one. Set real rates in `includes/content.php`. |

The WhatsApp number `+256 709 667 270` is **real** and already wired into every
Book Now button on the site.

### Also worth knowing

- **Guest reviews on the homepage are invented samples.** They are clearly
  labelled on the page and are deliberately *not* published as structured data.
  Adding fake review markup breaches Google's policy and risks a manual penalty,
  which would cost you far more than the star ratings would earn. Swap in real
  reviews in `includes/content.php`, then ask me to add the markup.
- **There is no swimming pool on this site**, although the original mockup showed
  one. The property does not have a pool, and advertising one guarantees angry
  arrivals.
- **Attraction distances are estimates.** Check them before launch.

---

## Deploying to Jubilee (or any cPanel host)

1. In cPanel, open **File Manager** and go to your domain's document root
   (usually `public_html`).
2. Upload the **contents** of this repo's `public_html/` folder into it.
   Upload the folder's contents, not the folder itself, or every URL gains an
   extra `/public_html/`.
3. Make sure hidden files are shown so `.htaccess` is uploaded too. In cPanel
   File Manager this is *Settings → Show Hidden Files*. Without it, clean URLs,
   compression and caching all silently stop working.
4. Set the PHP version to **8.0 or newer** (cPanel → *Select PHP Version*).
5. Issue the free **Let's Encrypt SSL** certificate for the domain.
6. Only once SSL is active, the HTTPS redirect in `.htaccess` is safe. It is
   enabled by default, so if you visit the site before the certificate is
   issued you will hit a browser warning. Comment that block out if you need to
   preview over plain HTTP first.

Do **not** upload `router.php`, `src/`, `tools/` or this README. They are for
development only. `public_html/` is the entire live site.

### After it is live

1. **Cloudflare (free plan).** Point the domain's nameservers at Cloudflare.
   This does more for speed in Uganda than any code change, because it caches
   pages and images at edge locations rather than serving every request from
   one shared server.
2. **Google Search Console.** Verify the domain, then submit
   `https://yourdomain/sitemap.xml`.
3. **Google Business Profile.** For a local business this drives more traffic
   than the website itself. The name, address and phone must match this site
   *character for character*, because Google cross-checks them.
4. **Bing Webmaster Tools.** Two minutes, imports from Search Console.

---

## Editing content

No admin panel and no database, by design. Everything is in two files:

- `public_html/includes/config.php` — contact details, address, domain, rates
- `public_html/includes/content.php` — rooms, menu, gallery, attractions, FAQs

To change a dish price, edit the number in `content.php`. That is the whole
process. Menu prices are already transcribed from your printed flyer.

---

## Project layout

```
public_html/            <- upload this, and only this
  index.php  rooms.php  dining.php  attractions.php
  gallery.php  about.php  directions.php  contact.php
  credits.php  404.php  sitemap.php
  .htaccess             <- clean URLs, HTTPS, caching, compression
  robots.txt  site.webmanifest
  includes/
    config.php          <- EDIT: contact details and domain
    content.php         <- EDIT: rooms, menu, gallery, attractions, FAQs
    bootstrap.php       loads everything, sets security headers
    functions.php       escaping, responsive images, icons
    schema.php          all JSON-LD structured data
    head.php  header.php  footer.php
    images.php          GENERATED, do not hand-edit
  assets/
    css/site.css  css/fonts.css
    js/site.js
    fonts/              self-hosted variable fonts
    img/photos/         the inn's own photography
    img/stock/          licensed attraction and food photos
    img/brand/          logo, favicon, app icons

src/assets/             full-size image masters (not deployed)
tools/
  build_images.py       regenerates every image size and images.php
  build_static.php      renders the site to dist/ for static hosts
router.php              local dev server only (not deployed)
netlify.toml            build command, publish dir, headers
dist/                   GENERATED by build_static.php, gitignored
```

## Running it locally

```bash
php -S localhost:8484 -t public_html router.php
```

`router.php` reproduces the `.htaccess` clean-URL rules so the dev server
behaves like Apache does on the host.

## Deploying

Two hosts, one codebase.

### cPanel, Apache, Jubilee

Upload `public_html/` over FTP. PHP runs on the server, `.htaccess` handles
clean URLs, caching and compression. No build step.

### Netlify, Cloudflare Pages, any static host

These serve files and never execute PHP, so the pages are rendered once at
deploy time instead:

```bash
php tools/build_static.php
```

That writes `dist/`: nine pages as flat HTML, plus `404.html`, `sitemap.xml`,
`robots.txt`, the assets and a generated `_redirects` giving the same clean
URLs Apache gives. `dist/` is gitignored, because Netlify runs the build
itself. `netlify.toml` already points at it, and Netlify's build image ships
PHP, selected there with `PHP_VERSION`.

Nothing about the site is actually dynamic. There is no database and no form
handler, and the only per-request logic is which nav link gets highlighted, so
the rendered HTML is identical to what the PHP host would emit.

`includes/content.php` stays the one place to edit rooms, menus and FAQs
either way. Edit, push, and Netlify rebuilds.

**The domain.** Set the `SITE_URL` environment variable to override
`SITE_URL` in `includes/config.php` for a build, which is what keeps canonical
tags, Open Graph URLs, the sitemap and robots.txt agreeing with wherever the
build is served from:

```bash
SITE_URL=https://your-site.netlify.app php tools/build_static.php
```

On Netlify it is set in `netlify.toml`, currently left at the real domain so
that a preview deploy does not get indexed as a competing copy of the site.

## Rebuilding images

Drop new photos into `src/assets/photos/`, then:

```bash
python tools/build_images.py
```

This regenerates every size in WebP and JPEG and rewrites
`public_html/includes/images.php`, which is what lets each `<img>` carry its
real `width` and `height`. Those attributes are why the layout never jumps
while images load, and layout stability is a ranking factor.

---

## What was done for SEO

- Unique title (50 to 60 chars) and meta description (130 to 160) per page
- Canonical URL on every page, one `<h1>` per page, semantic headings
- Linked JSON-LD `@graph`: `Hotel` / `LodgingBusiness`, `Restaurant` with the
  full `Menu`, `HotelRoom` with `Offer` per tier, `FAQPage`, `BreadcrumbList`,
  `ItemList` of attractions, `ImageGallery`, `Organization`, `WebSite`
- Geo meta tags and a name/address/phone kept identical across the footer,
  the meta tags and the structured data
- Generated `sitemap.xml` with honest `lastmod` dates, plus `robots.txt`
- Open Graph and Twitter card tags for link previews
- Descriptive alt text on every image
- Self-hosted variable fonts, so no third-party connection on first paint
- Responsive WebP with JPEG fallback, correctly sized per viewport
- `width`/`height` on every image: measured Cumulative Layout Shift is **0**
- Google Maps iframe deferred until scrolled near, so it cannot drag down the
  mobile score
- Homepage weighs ~236KB over 8 requests
- Verified: no horizontal overflow at 320, 360, 414, 768 or 1024 px

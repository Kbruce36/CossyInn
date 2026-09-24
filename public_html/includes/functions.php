<?php
/**
 * Shared helpers. No framework, no dependencies, no database.
 */

declare(strict_types=1);

/** Escape for HTML output. Used on every dynamic value without exception. */
function e(?string $s): string
{
    return htmlspecialchars($s ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Absolute URL for a site-relative path. */
function url(string $path = '/'): string
{
    return SITE_URL . '/' . ltrim($path, '/');
}

/** The current request path, normalised to a leading slash and no trailing slash. */
function current_path(): string
{
    $p = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $p = '/' . trim($p, '/');
    // tolerate both /rooms and /rooms.php
    return preg_replace('/\.php$/', '', $p) ?: '/';
}

/** True when $path is the page being viewed, for nav highlighting. */
function is_active(string $path): bool
{
    return current_path() === rtrim($path, '/') || ($path === '/' && current_path() === '/');
}

/** WhatsApp click-to-chat link with a prefilled message. */
function whatsapp_link(?string $message = null): string
{
    $msg = $message ?? WHATSAPP_MESSAGE;
    return 'https://wa.me/' . WHATSAPP_NUMBER . '?text=' . rawurlencode($msg);
}

/** Uganda Shillings, formatted the way the printed menu writes them. */
function ugx(?int $amount): string
{
    return $amount === null ? '' : number_format($amount) . '/=';
}

/**
 * Responsive <picture> element.
 *
 * Emits WebP with a JPEG fallback, a srcset across the generated widths, and
 * explicit width/height so the browser reserves the right space before the
 * image arrives. That last part is what keeps Cumulative Layout Shift at zero.
 *
 * @param string $key    manifest key, e.g. 'photos/entrance'
 * @param string $alt    alternative text, required, describe the actual photo
 * @param array  $opts   sizes, class, loading, fetchpriority, ratio
 */
function picture(string $key, string $alt, array $opts = []): string
{
    static $manifest = null;
    if ($manifest === null) {
        $manifest = require __DIR__ . '/images.php';
    }

    if (!isset($manifest[$key])) {
        // Fail loudly in development, quietly in production.
        return '<!-- missing image: ' . e($key) . ' -->';
    }

    $m       = $manifest[$key];
    $sizes   = $opts['sizes']  ?? '100vw';
    $class   = $opts['class']  ?? '';
    $loading = $opts['loading'] ?? 'lazy';
    $fetch   = $opts['fetchpriority'] ?? null;
    $widths  = $m['sizes'];
    $largest = end($widths);
    $base    = '/assets/img/' . $key;

    $mk = static fn(string $ext): string => implode(', ', array_map(
        static fn(int $w): string => "{$base}-{$w}.{$ext} {$w}w",
        $widths
    ));

    // Intrinsic size, scaled to the largest file we actually generated.
    $w = $largest;
    $h = (int) round($m['h'] * $largest / $m['w']);

    $attrs = sprintf(
        'src="%s-%d.jpg" srcset="%s" sizes="%s" width="%d" height="%d" alt="%s" loading="%s" decoding="async"',
        $base, $largest, $mk('jpg'), e($sizes), $w, $h, e($alt), e($loading)
    );
    if ($fetch) {
        $attrs .= ' fetchpriority="' . e($fetch) . '"';
    }
    if ($class !== '') {
        $attrs .= ' class="' . e($class) . '"';
    }

    return '<picture>'
         . '<source type="image/webp" srcset="' . $mk('webp') . '" sizes="' . e($sizes) . '">'
         . '<img ' . $attrs . '>'
         . '</picture>';
}

/**
 * imagesrcset/imagesizes attributes for a responsive <link rel="preload">.
 * Mirrors exactly what picture() emits for the same key, so the preloader and
 * the parser agree on which file to fetch.
 */
function preload_image_attrs(string $key, string $sizes = '100vw'): string
{
    static $manifest = null;
    if ($manifest === null) {
        $manifest = require __DIR__ . '/images.php';
    }
    if (!isset($manifest[$key])) {
        return '';
    }
    $srcset = implode(', ', array_map(
        static fn(int $w): string => "/assets/img/{$key}-{$w}.webp {$w}w",
        $manifest[$key]['sizes']
    ));
    return 'imagesrcset="' . $srcset . '" imagesizes="' . e($sizes) . '"';
}

/** The URL of an image at a given width, for Open Graph and JSON-LD. */
function image_url(string $key, int $width = 1200): string
{
    static $manifest = null;
    if ($manifest === null) {
        $manifest = require __DIR__ . '/images.php';
    }
    if (!isset($manifest[$key])) {
        return url('/assets/img/photos/entrance-1200.jpg');
    }
    $widths = $manifest[$key]['sizes'];
    // pick the closest generated width at or below the request
    $pick = $widths[0];
    foreach ($widths as $w) {
        if ($w <= $width) {
            $pick = $w;
        }
    }
    return url("/assets/img/{$key}-{$pick}.jpg");
}

/** Inline SVG icon set. Inline so there is no extra request and no icon font. */
function icon(string $name, string $class = 'icon'): string
{
    $paths = [
        'bed'       => '<path d="M2 17v-6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6M2 17h20M2 17v3M22 17v3M6 9V7a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/>',
        'dish'      => '<path d="M3 17h18M5 17a7 7 0 0 1 14 0M12 7V5M9 21h6"/>',
        'wifi'      => '<path d="M5 12.5a10 10 0 0 1 14 0M8.5 16a5.5 5.5 0 0 1 7 0"/><circle cx="12" cy="19.5" r=".7" fill="currentColor"/>',
        'users'     => '<circle cx="9" cy="8" r="3"/><path d="M2 20a7 7 0 0 1 14 0M17 5.5a3 3 0 0 1 0 5.8M18 20a6 6 0 0 0-2-4.5"/>',
        'car'       => '<path d="M4 16v3M20 16v3M3 16h18v-4l-2-5H5L3 12v4Z"/><circle cx="7.5" cy="16" r="1.2"/><circle cx="16.5" cy="16" r="1.2"/>',
        'tag'       => '<path d="M3 11V4h7l11 11-7 7L3 11Z"/><circle cx="7.5" cy="7.5" r="1.2"/>',
        'whatsapp'  => '<path d="M12 2a10 10 0 0 0-8.6 15L2 22l5.2-1.4A10 10 0 1 0 12 2Z"/><path d="M8.5 7.8c.2-.4.4-.4.7-.4h.5c.2 0 .4 0 .6.5l.8 1.9c.1.2 0 .4-.1.6l-.4.5c-.1.2-.3.3-.1.6a7 7 0 0 0 3.2 2.8c.3.1.5 0 .6-.1l.6-.7c.2-.2.3-.2.6-.1l1.8.9c.3.1.4.3.4.5a2 2 0 0 1-1.4 1.6c-.5.2-1.2.2-3.4-.8a11 11 0 0 1-4.5-4.3c-.7-1.3-.7-2.3-.6-2.8a2 2 0 0 1 .7-1.1Z"/>',
        'phone'     => '<path d="M5 3h3l2 5-2.5 1.5a12 12 0 0 0 6 6L15 13l5 2v3a2 2 0 0 1-2.2 2A16 16 0 0 1 3 5.2 2 2 0 0 1 5 3Z"/>',
        'mail'      => '<rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'pin'       => '<path d="M12 21s7-6 7-11a7 7 0 1 0-14 0c0 5 7 11 7 11Z"/><circle cx="12" cy="10" r="2.6"/>',
        'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5.5l3.5 2"/>',
        'arrow'     => '<path d="M5 12h13M13 6l6 6-6 6"/>',
        'star'      => '<path d="m12 3 2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9L12 3Z"/>',
        'check'     => '<path d="m4 12.5 5 5L20 6.5"/>',
        'menu'      => '<path d="M3 6h18M3 12h18M3 18h18"/>',
        'close'     => '<path d="M6 6l12 12M18 6 6 18"/>',
        'chevron-l' => '<path d="M15 5l-7 7 7 7"/>',
        'chevron-r' => '<path d="M9 5l7 7-7 7"/>',
        'facebook'  => '<path d="M14 8.5V7c0-.8.2-1.2 1.3-1.2H17V3h-2.5C11.8 3 11 4.3 11 6.6v1.9H9V12h2v9h3v-9h2.3l.4-3.5H14Z" fill="currentColor" stroke="none"/>',
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1.1" fill="currentColor" stroke="none"/>',
        'tiktok'    => '<path d="M15 3c.3 2.3 1.7 3.8 4 4v3c-1.5.1-2.9-.3-4-1.1V15a6 6 0 1 1-6-6c.4 0 .7 0 1 .1v3.2A2.8 2.8 0 1 0 12 15V3h3Z" fill="currentColor" stroke="none"/>',
        'youtube'   => '<rect x="2.5" y="5.5" width="19" height="13" rx="4"/><path d="m10.5 9.5 5 2.5-5 2.5Z" fill="currentColor"/>',
    ];

    $body = $paths[$name] ?? '';
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" fill="none" '
         . 'stroke="currentColor" stroke-width="1.6" stroke-linecap="round" '
         . 'stroke-linejoin="round" aria-hidden="true" focusable="false">'
         . $body . '</svg>';
}

/**
 * One attraction card.
 *
 * Used by the attractions page and by the homepage teaser, which differ only
 * in heading level and whether the distance chip is shown. It lived in both
 * files as copied markup until the two drifted apart once too often.
 *
 * @param array $a    one entry from $ATTRACTIONS
 * @param array $opts heading ('h2' or 'h3'), delay (ms), distance (bool)
 */
function attraction_card(array $a, array $opts = []): string
{
    $heading  = $opts['heading'] ?? 'h2';
    $delay    = (int) ($opts['delay'] ?? 0);
    $showDist = $opts['distance'] ?? true;

    $img = picture($a['img'], $a['alt'], [
        'sizes' => '(min-width:1000px) 380px, (min-width:720px) 50vw, 100vw',
    ]);

    $foot = '';
    if ($showDist) {
        $foot = '              <div class="card__foot">' . "\n"
              . '                <span class="chip">' . icon('car', 'icon icon--sm')
              . ' ' . e($a['dist']) . '</span>' . "\n"
              . '              </div>' . "\n";
    }

    // Indentation and the trailing newline are baked in so the call site can be
    // a one-line `foreach ... echo`. PHP swallows the newline that follows a
    // closing tag, so emitting these from a multi-line template block instead
    // would run every card onto a single line.
    return sprintf(
        '          <article class="card reveal" data-reveal-delay="%d">' . "\n"
        . '            <div class="card__media">' . "\n"
        . '              %s' . "\n"
        . '              <span class="card__badge">%s</span>' . "\n"
        . '            </div>' . "\n"
        . '            <div class="card__body">' . "\n"
        . '              <%s class="card__title">%s</%s>' . "\n"
        . '              <p class="card__text">%s</p>' . "\n"
        . '%s'
        . '            </div>' . "\n"
        . '          </article>' . "\n",
        $delay,
        $img,
        e($a['time']),
        $heading,
        e($a['name']),
        $heading,
        e($a['blurb']),
        $foot
    );
}

/** Social profiles that have a real URL set. '#' entries are placeholders. */
function active_socials(array $socials): array
{
    return array_filter($socials, static fn(array $s): bool => ($s['url'] ?? '#') !== '#');
}

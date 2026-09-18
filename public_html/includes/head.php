<?php
/**
 * Document head. Every page sets $page before including this:
 *
 *   $page = [
 *     'title'       => 'Rooms & Rates',           // without the site name
 *     'description' => 'One sentence, 140-160 chars, written for a human.',
 *     'path'        => '/rooms',
 *     'image'       => image_url('photos/room-executive', 1200),  // optional
 *     'schema'      => [ ...extra JSON-LD nodes... ],             // optional
 *     'breadcrumbs' => ['Home' => '/', 'Rooms' => '/rooms'],      // optional
 *     'preload'     => 'photos/entrance',                         // optional LCP image
 *   ];
 */

declare(strict_types=1);

// 'titleFull' wins outright, for pages where "Page | Site Name" reads badly.
// Aim for 50 to 60 rendered characters: shorter wastes the snippet, longer
// gets truncated with an ellipsis in the results page.
$title = $page['titleFull']
    ?? (($page['title'] ?? '') === ''
        ? SITE_NAME . ' | ' . SITE_TAGLINE
        : $page['title'] . ' | ' . SITE_SHORTNAME);

$description = $page['description'] ?? '';
$canonical   = url($page['path'] ?? '/');
$ogImage     = $page['image'] ?? image_url('photos/entrance', 1200);

$schemaNodes = $page['schema'] ?? [];
if (!empty($page['breadcrumbs'])) {
    $schemaNodes[] = schema_breadcrumbs($page['breadcrumbs']);
}
?>
<!DOCTYPE html>
<html lang="en-UG">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= e($title) ?></title>
<meta name="description" content="<?= e($description) ?>">
<link rel="canonical" href="<?= e($canonical) ?>">

<meta name="robots" content="<?= e($page['robots'] ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1') ?>">
<meta name="theme-color" content="#7C1823">

<!-- Local signals. Kept consistent with the address in the footer and in JSON-LD,
     because Google cross-checks name, address and phone across all three. -->
<meta name="geo.region" content="UG-WAK">
<meta name="geo.placename" content="<?= e(ADDR_LOCALITY) ?>">
<meta name="geo.position" content="<?= e(GEO_LAT) ?>;<?= e(GEO_LNG) ?>">
<meta name="ICBM" content="<?= e(GEO_LAT) ?>, <?= e(GEO_LNG) ?>">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
<meta property="og:locale" content="en_UG">
<meta property="og:title" content="<?= e($title) ?>">
<meta property="og:description" content="<?= e($description) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="675">
<meta property="og:image:alt" content="<?= e(SITE_NAME) ?>">

<!-- Twitter / X -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($title) ?>">
<meta name="twitter:description" content="<?= e($description) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">

<!-- Fonts are self-hosted, so there is no third-party connection to set up and
     no extra DNS lookup on a slow mobile connection. -->
<link rel="preload" href="/assets/fonts/inter.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/fonts/playfair.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="/assets/css/fonts.css">
<link rel="stylesheet" href="/assets/css/site.css">

<?php if (!empty($page['preload'])):
    /*
     * The preload has to offer the SAME candidate set as the <picture> below,
     * or the browser preloads one size and then downloads a different one,
     * paying for the hero image twice. imagesrcset/imagesizes keep them in
     * step so exactly one file is fetched, at the size this screen needs.
     */
    $pl = preload_image_attrs($page['preload'], '100vw');
    if ($pl !== ''): ?>
<link rel="preload" as="image" type="image/webp" <?= $pl ?> fetchpriority="high">
<?php endif; endif; ?>

<link rel="icon" href="/assets/img/brand/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/assets/img/brand/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">

<?= render_schema([
    'title'       => $title,
    'description' => $description,
    'path'        => $page['path'] ?? '/',
    'image'       => $ogImage,
], $schemaNodes) ?>
</head>
<body<?= isset($page['bodyClass']) ? ' class="' . e($page['bodyClass']) . '"' : '' ?>>
<a class="skip-link" href="#main">Skip to content</a>

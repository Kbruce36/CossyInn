<?php
/**
 * XML sitemap, generated rather than hand-maintained so it can never drift
 * out of step with the navigation. Served at /sitemap.xml via .htaccess.
 *
 * lastmod is taken from each page file's modification time, which is honest:
 * it changes when the page actually changes, not every time it is requested.
 * Lying about lastmod teaches Google to ignore the field.
 */

declare(strict_types=1);
// require_once, and via the same path every other page uses. This file used to
// require config.php directly with require, so rendering it after another page
// in one process redefined every constant.
require_once __DIR__ . '/includes/config.php';

if (PHP_SAPI !== 'cli') {
    header('Content-Type: application/xml; charset=utf-8');
}

/** path => [file, changefreq, priority] */
$urls = [
    '/'            => ['index.php',       'weekly',  '1.0'],
    '/rooms'       => ['rooms.php',       'weekly',  '0.9'],
    '/dining'      => ['dining.php',      'weekly',  '0.9'],
    '/attractions' => ['attractions.php', 'monthly', '0.7'],
    '/gallery'     => ['gallery.php',     'monthly', '0.7'],
    '/about'       => ['about.php',       'monthly', '0.6'],
    '/directions'  => ['directions.php',  'monthly', '0.7'],
    '/contact'     => ['contact.php',     'monthly', '0.8'],
    '/credits'     => ['credits.php',     'yearly',  '0.2'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $path => [$file, $freq, $priority]):
    $full = __DIR__ . '/' . $file;
    $mtime = is_file($full) ? filemtime($full) : time();
?>
  <url>
    <loc><?= htmlspecialchars(SITE_URL . $path, ENT_XML1) ?></loc>
    <lastmod><?= date('Y-m-d', $mtime) ?></lastmod>
    <changefreq><?= $freq ?></changefreq>
    <priority><?= $priority ?></priority>
  </url>
<?php endforeach; ?>
</urlset>

<?php
/**
 * Prerender the site to flat HTML in dist/.
 *
 * Why this exists
 * ---------------
 * The site is PHP because the host it was written for (Jubilee, cPanel,
 * Apache) runs PHP. Netlify does not: it serves files off a CDN and never
 * executes anything, so `index.php` is delivered as a download at best and a
 * 404 at worst. Nothing on the site is actually dynamic, though. There is no
 * database, no form handler and no per-request logic beyond highlighting the
 * current nav item, so every page can be rendered once at build time and
 * shipped as HTML.
 *
 * This keeps PHP as the authoring layer. `includes/content.php` stays the one
 * place rooms, menus and FAQs are edited, and nobody hand-maintains nine
 * copies of the header.
 *
 * Usage
 * -----
 *   php tools/build_static.php
 *
 * Output goes to dist/, which is gitignored: Netlify runs this command on
 * every deploy rather than the HTML being committed. Set the SITE_URL
 * environment variable to point canonical URLs, the sitemap and robots.txt at
 * whatever domain is actually serving the build.
 *
 * Every page is rendered in this one process, at global scope. See the render
 * loop below for why both of those matter.
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$src  = $root . '/public_html';
$out  = $root . '/dist';

/**
 * Public path => source file. The path is what the visitor asks for and what
 * the page tells Google is canonical, so it is also what the nav highlighting
 * is fed while rendering.
 */
const PAGES = [
    '/'            => 'index.php',
    '/rooms'       => 'rooms.php',
    '/dining'      => 'dining.php',
    '/attractions' => 'attractions.php',
    '/gallery'     => 'gallery.php',
    '/about'       => 'about.php',
    '/directions'  => 'directions.php',
    '/contact'     => 'contact.php',
    '/credits'     => 'credits.php',
];

/** Rendered, but not pages in the navigation sense. */
const EXTRAS = [
    '/404'         => ['404.php',     '404.html'],
    '/sitemap.xml' => ['sitemap.php', 'sitemap.xml'],
];

/** Copied verbatim. Everything else in public_html/ is PHP or server config. */
const VERBATIM = ['assets', 'site.webmanifest'];

// ---------------------------------------------------------------------------
// Warnings are build failures.
// ---------------------------------------------------------------------------
// A notice or warning still produces usable-looking HTML, which is exactly why
// it must not be allowed through: an undefined array key in a template is a
// missing price or a missing link that nobody notices until a guest does.
// Collected rather than thrown so one run reports every page that is unhappy.
$buildWarnings = [];
set_error_handler(static function (int $no, string $msg, string $f, int $line) use (&$buildWarnings): bool {
    global $buildCurrent;
    $buildWarnings[] = sprintf('%s: %s (%s:%d)', $buildCurrent ?? 'startup', $msg, basename($f), $line);
    return true;
});

function write_file(string $path, string $contents): void
{
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0o777, true) && !is_dir($dir)) {
        fail("could not create $dir");
    }
    if (file_put_contents($path, $contents) === false) {
        fail("could not write $path");
    }
}

/** Recursive copy, used for assets/. */
function copy_tree(string $from, string $to): int
{
    $count = 0;
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($items as $item) {
        /** @var SplFileInfo $item */
        $target = $to . DIRECTORY_SEPARATOR . $items->getSubPathName();
        if ($item->isDir()) {
            if (!is_dir($target)) {
                mkdir($target, 0o777, true);
            }
            continue;
        }
        if (!copy($item->getPathname(), $target)) {
            fail('could not copy ' . $item->getPathname());
        }
        $count++;
    }
    return $count;
}

function remove_tree(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($items as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }
    rmdir($dir);
}

function fail(string $message): never
{
    fwrite(STDERR, "build_static: $message\n");
    exit(1);
}

// --- the domain this build is for -------------------------------------------
// config.php reads the same variable, so canonical tags, Open Graph URLs, the
// sitemap and robots.txt all agree with each other and with where the build
// is actually served from.
$siteUrl = rtrim(getenv('SITE_URL') ?: 'https://www.cosyinnkiwenda.com', '/');

echo "Building the Cosy Inn site for $siteUrl\n";

remove_tree($out);
mkdir($out, 0o777, true);

// --- pages -------------------------------------------------------------------
// Two things about this loop are deliberate.
//
// It renders at GLOBAL scope. schema.php reaches for the content arrays with
// `global $MENU`, `global $ROOMS` and so on, so the arrays that config.php and
// content.php create have to land in the global scope, which means the page
// files have to be required from it too. Move this into a function and the
// pages still render, but their structured data quietly comes out empty.
//
// It renders every page in THIS process, which is only safe because
// bootstrap.php requires its four includes with require_once. Those files
// declare constants and functions, so before that change a second page in the
// same process was a redeclaration fatal, and this script had to fork a PHP
// child per page to get around it.
//
// Loop variables are prefixed because the pages share this scope: header.php
// and footer.php both do `foreach ($NAV as $path => $label)`, and sitemap.php
// uses $file. A plain $path here would be clobbered mid-build.
require_once "$src/includes/bootstrap.php";

$buildJobs = [];
foreach (PAGES as $buildPath => $buildFile) {
    // '/' is the only page that must keep its directory-index filename;
    // everything else is flat, so /rooms is served by rooms.html with no
    // trailing-slash redirect to muddy the canonical URL.
    $buildJobs[$buildPath] = [$buildFile, $buildPath === '/' ? 'index.html' : trim($buildPath, '/') . '.html'];
}
foreach (EXTRAS as $buildPath => [$buildFile, $buildName]) {
    $buildJobs[$buildPath] = [$buildFile, $buildName];
}

foreach ($buildJobs as $buildPath => [$buildFile, $buildName]) {
    // functions.php reads REQUEST_URI to decide which nav link is active.
    // Without this every page would render with the homepage highlighted.
    $_SERVER['REQUEST_URI']     = $buildPath;
    $_SERVER['REQUEST_METHOD']  = 'GET';
    $_SERVER['HTTP_HOST']       = 'localhost';
    $_SERVER['SCRIPT_FILENAME'] = "$src/$buildFile";

    $buildCurrent = $buildFile;
    ob_start();
    require "$src/$buildFile";
    $buildHtml = (string) ob_get_clean();

    if (trim($buildHtml) === '') {
        fail("rendering $buildFile produced no output");
    }
    write_file("$out/$buildName", $buildHtml);
    echo "  $buildPath -> $buildName\n";
}
$buildCurrent = null;

// --- static files ------------------------------------------------------------
foreach (VERBATIM as $item) {
    $from = "$src/$item";
    if (is_dir($from)) {
        $n = copy_tree($from, "$out/$item");
        echo "  copied $item/ ($n files)\n";
    } elseif (is_file($from)) {
        copy($from, "$out/$item");
        echo "  copied $item\n";
    }
}

// robots.txt carries the domain in two places: a comment and the Sitemap
// line. Rewriting it here is what keeps it honest when SITE_URL is overridden.
$robots = (string) file_get_contents("$src/robots.txt");
$robots = str_replace('https://www.cosyinnkiwenda.com', $siteUrl, $robots);
write_file("$out/robots.txt", $robots);
echo "  wrote robots.txt\n";

// --- redirects ---------------------------------------------------------------
// Netlify's own pretty-URL handling would cover most of this, but it is a
// per-site toggle. Spelling the rules out here means the build behaves the
// same whatever that toggle says, and mirrors the .htaccess rules that Apache
// applies on the PHP host.
$redirects = [
    "# Generated by tools/build_static.php. Do not edit.",
    "",
    "# The .php URLs never become the canonical ones.",
    "/index.php    /    301!",
];
foreach (PAGES as $path => $file) {
    if ($path === '/') {
        continue;
    }
    $redirects[] = sprintf('%-13s %-13s 301!', '/' . trim($path, '/') . '.php', $path);
}
$redirects[] = "";
$redirects[] = "# Clean URLs: serve rooms.html at /rooms without a redirect.";
foreach (PAGES as $path => $file) {
    if ($path === '/') {
        continue;
    }
    $redirects[] = sprintf('%-13s %-13s 200', $path, '/' . trim($path, '/') . '.html');
}
$redirects[] = "";
$redirects[] = "# Apache served the generated sitemap from sitemap.php.";
$redirects[] = "/sitemap.php  /sitemap.xml  301!";
write_file("$out/_redirects", implode("\n", $redirects) . "\n");
echo "  wrote _redirects\n";

restore_error_handler();
if ($buildWarnings !== []) {
    fwrite(STDERR, "\nbuild_static: " . count($buildWarnings) . " warning(s) while rendering:\n");
    foreach ($buildWarnings as $w) {
        fwrite(STDERR, "  ! $w\n");
    }
    fail('refusing to publish a build that produced warnings');
}

echo "Done. Publish directory: dist/\n";

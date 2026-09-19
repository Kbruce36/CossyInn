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
 * Each page is rendered in its own PHP process. Every page requires
 * bootstrap.php, which declares constants and functions unconditionally, so
 * rendering two pages in one process is a redeclaration fatal.
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
// Child mode: render one page and write it to stdout.
// ---------------------------------------------------------------------------
if (($argv[1] ?? '') === '--render') {
    $file = $argv[2];
    $uri  = $argv[3];

    // functions.php reads REQUEST_URI to decide which nav link is active.
    // Without this every page would render with the homepage highlighted.
    $_SERVER['REQUEST_URI']    = $uri;
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['HTTP_HOST']      = 'localhost';
    $_SERVER['SCRIPT_FILENAME'] = $file;

    require $file;
    exit(0);
}

// ---------------------------------------------------------------------------
// Parent mode.
// ---------------------------------------------------------------------------

/** Render one page in a child process and return its output. */
function render(string $file, string $uri): string
{
    $proc = proc_open(
        [PHP_BINARY, __FILE__, '--render', $file, $uri],
        [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
        $pipes
    );
    if (!is_resource($proc)) {
        fail("could not start PHP to render $file");
    }

    $html = stream_get_contents($pipes[1]);
    $err  = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $code = proc_close($proc);

    // A warning on stderr still produces usable HTML, but it means something
    // is wrong with the page, so it is not swallowed.
    if ($err !== '') {
        fwrite(STDERR, "  ! $file wrote to stderr:\n" . rtrim($err) . "\n");
    }
    if ($code !== 0 || trim((string) $html) === '') {
        fail("rendering $file failed (exit $code)");
    }

    return (string) $html;
}

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
foreach (PAGES as $path => $file) {
    // '/' is the only page that must keep its directory-index filename;
    // everything else is flat, so /rooms is served by rooms.html with no
    // trailing-slash redirect to muddy the canonical URL.
    $name = $path === '/' ? 'index.html' : trim($path, '/') . '.html';
    write_file("$out/$name", render("$src/$file", $path));
    echo "  $path -> $name\n";
}

foreach (EXTRAS as $path => [$file, $name]) {
    write_file("$out/$name", render("$src/$file", $path));
    echo "  $path -> $name\n";
}

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

echo "Done. Publish directory: dist/\n";

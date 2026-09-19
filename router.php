<?php
/**
 * Dev-server router. Mimics the .htaccess clean-URL rules so that
 * `php -S` behaves the same way Jubilee's Apache will.
 * This file is NOT uploaded to the host.
 */
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// serve real files (css, js, images, fonts) straight from disk
if ($path !== '/' && file_exists(__DIR__ . '/public_html' . $path)) {
    return false;
}

$clean = trim($path, '/');
if ($clean === '') {
    $clean = 'index';
}

// Apache serves the generated sitemap at /sitemap.xml, and so does the static
// build. Without this the dev server was the only place that 404'd on it.
if ($clean === 'sitemap.xml') {
    $clean = 'sitemap';
}

$candidate = __DIR__ . '/public_html/' . $clean . '.php';
if (file_exists($candidate)) {
    $_SERVER['SCRIPT_FILENAME'] = $candidate;
    require $candidate;
    return true;
}

http_response_code(404);
$notFound = __DIR__ . '/public_html/404.php';
if (file_exists($notFound)) {
    require $notFound;
}
return true;

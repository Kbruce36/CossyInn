<?php
/**
 * Loaded first by every page. Pulls in configuration, helpers, content and
 * the structured-data builders, in that order, and sets sane response headers.
 */

declare(strict_types=1);

// require_once, not require. These four files declare constants and functions,
// so running any of them twice in one process is a fatal redeclaration. That
// only happens outside a web request, where one process renders several pages:
// tools/build_static.php does exactly that.
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/content.php';
require_once __DIR__ . '/schema.php';

// Only when actually serving a request. Under the CLI there is no response to
// put headers on, and tools/build_static.php has already written to stdout by
// the time it renders a page, so every one of these would warn.
// Netlify gets the same headers from netlify.toml instead.
if (PHP_SAPI !== 'cli') {
    header('Content-Type: text/html; charset=utf-8');

    // Conservative security headers. These cost nothing and stop the site being
    // framed by someone else or sniffed into a different content type.
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Frame-Options: SAMEORIGIN');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
}

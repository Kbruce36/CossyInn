<?php
/**
 * Loaded first by every page. Pulls in configuration, helpers, content and
 * the structured-data builders, in that order, and sets sane response headers.
 */

declare(strict_types=1);

require __DIR__ . '/config.php';
require __DIR__ . '/functions.php';
require __DIR__ . '/content.php';
require __DIR__ . '/schema.php';

header('Content-Type: text/html; charset=utf-8');

// Conservative security headers. These cost nothing and stop the site being
// framed by someone else or sniffed into a different content type.
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('X-Frame-Options: SAMEORIGIN');
header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

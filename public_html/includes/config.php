<?php
/**
 * Site-wide configuration for The Cosy Inn Kiwenda.
 *
 * ---------------------------------------------------------------------------
 * THIS IS THE ONLY FILE YOU NEED TO EDIT FOR CONTACT DETAILS AND THE DOMAIN.
 *
 * Anything marked PLACEHOLDER is invented and must be replaced before launch.
 * The WhatsApp number is real. Everything else marked PLACEHOLDER is not.
 * ---------------------------------------------------------------------------
 */

declare(strict_types=1);

// --- Domain -----------------------------------------------------------------
// PLACEHOLDER: set this to the domain you buy, with no trailing slash.
// Every canonical URL, sitemap entry, Open Graph tag and JSON-LD @id is built
// from this one value, so changing it here updates the whole site.
define('SITE_URL', 'https://www.cosyinnkiwenda.com');

// --- Identity ---------------------------------------------------------------
define('SITE_NAME',      'The Cosy Inn Kiwenda');
define('SITE_SHORTNAME', 'Cosy Inn Kiwenda');
define('SITE_TAGLINE',   'Your Home of Comfort');
define('SITE_STRAPLINE', "Relax • Refresh • Belong");

// --- Contact ----------------------------------------------------------------
// REAL: supplied by the owner.
define('WHATSAPP_NUMBER',  '256709667270');   // international, digits only
define('WHATSAPP_DISPLAY', '+256 709 667 270');
define('WHATSAPP_MESSAGE', 'Hello Cosy Inn Kiwenda, I would like to enquire about a room.');

define('PHONE_PRIMARY',         '+256709667270');
define('PHONE_PRIMARY_DISPLAY', '+256 709 667 270');

// PLACEHOLDER: second reception line. Replace or delete.
define('PHONE_SECONDARY',         '+256772000000');
define('PHONE_SECONDARY_DISPLAY', '+256 772 000 000');

// PLACEHOLDER: use a mailbox on the domain you buy.
define('EMAIL_PRIMARY', 'info@cosyinnkiwenda.com');

// --- Address and geo --------------------------------------------------------
// PLACEHOLDER: refine the street line and confirm the pin before launch.
// Wrong coordinates are actively harmful, guests are navigated to the wrong place
// and Google Business Profile will not match the site to the listing.
define('ADDR_STREET',   'Kiwenda, Gayaza-Zirobwe Road');
define('ADDR_LOCALITY', 'Kiwenda');
define('ADDR_REGION',   'Wakiso District');
define('ADDR_COUNTRY',  'UG');
define('ADDR_FULL',     'Kiwenda, Gayaza-Zirobwe Road, Wakiso District, Uganda');

define('GEO_LAT', '0.48330');   // PLACEHOLDER, approximate
define('GEO_LNG', '32.60000');  // PLACEHOLDER, approximate

// --- Commercial -------------------------------------------------------------
define('CURRENCY',      'USD');
define('PRICE_FROM',    50);          // USD per room per night, supplied by owner
define('PRICE_RANGE',   '$$');        // schema.org priceRange hint
define('CHECK_IN',      '12:00');
define('CHECK_OUT',     '10:00');

// --- Social -----------------------------------------------------------------
// PLACEHOLDER: swap '#' for the real profile URLs. Any entry left as '#'
// renders as a disabled button rather than a dead link, and is omitted from
// the sameAs array in structured data so Google is not fed a bad signal.
$SOCIAL = [
    'facebook'  => ['label' => 'Facebook',  'url' => '#'],
    'instagram' => ['label' => 'Instagram', 'url' => '#'],
    'tiktok'    => ['label' => 'TikTok',    'url' => '#'],
    'youtube'   => ['label' => 'YouTube',   'url' => '#'],
];

// --- Navigation -------------------------------------------------------------
$NAV = [
    '/'             => 'Home',
    '/rooms'        => 'Rooms & Rates',
    '/dining'       => 'Dining',
    '/attractions'  => 'Attractions',
    '/gallery'      => 'Gallery',
    '/about'        => 'About',
    '/directions'   => 'Directions',
    '/contact'      => 'Contact',
];

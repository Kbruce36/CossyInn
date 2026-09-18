<?php
/**
 * JSON-LD structured data.
 *
 * Every page emits a linked @graph rather than several disconnected blobs, so
 * Google can see that the Hotel, the Restaurant, the WebSite and the current
 * WebPage all belong to one business.
 *
 * DELIBERATE OMISSION: there is no Review or AggregateRating markup anywhere.
 * The testimonials on the site are placeholders. Marking up invented reviews
 * breaches Google's structured data policy and can earn a manual action, which
 * would cost far more ranking than the stars would ever win. Add Review markup
 * only once real, attributable guest reviews exist.
 */

declare(strict_types=1);

/** Stable @id values, so nodes can reference each other across pages. */
function schema_ids(): array
{
    return [
        'org'        => SITE_URL . '/#organisation',
        'hotel'      => SITE_URL . '/#hotel',
        'restaurant' => SITE_URL . '/#restaurant',
        'website'    => SITE_URL . '/#website',
    ];
}

/** The business itself: a LodgingBusiness that also operates a Restaurant. */
function schema_hotel(): array
{
    global $SOCIAL, $AMENITIES;
    $id = schema_ids();

    $sameAs = array_values(array_map(
        static fn(array $s): string => $s['url'],
        active_socials($SOCIAL ?? [])
    ));

    $amenities = array_map(static fn(array $a): array => [
        '@type' => 'LocationFeatureSpecification',
        'name'  => $a['title'],
        'value' => true,
    ], $AMENITIES ?? []);

    $node = [
        '@type'       => ['Hotel', 'LodgingBusiness'],
        '@id'         => $id['hotel'],
        'name'        => SITE_NAME,
        'alternateName' => SITE_SHORTNAME,
        'slogan'      => SITE_TAGLINE,
        'url'         => SITE_URL . '/',
        'description' => 'A quiet, family-run inn in Kiwenda, Wakiso District, Uganda, '
                       . 'with clean en-suite rooms, a restaurant serving local and '
                       . 'continental food, a bar and secure parking.',
        'image'       => [
            image_url('photos/entrance', 1200),
            image_url('photos/courtyard', 1200),
            image_url('photos/room-executive', 1200),
        ],
        'logo'        => url('/assets/img/brand/logo.svg'),
        'telephone'   => PHONE_PRIMARY,
        'email'       => EMAIL_PRIMARY,
        'priceRange'  => PRICE_RANGE,
        'currenciesAccepted' => 'UGX, USD',
        'paymentAccepted'    => 'Cash, Mobile Money',
        'checkinTime'  => CHECK_IN,
        'checkoutTime' => CHECK_OUT,
        'numberOfRooms' => count($GLOBALS['ROOMS'] ?? []),
        'petsAllowed'  => false,
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => ADDR_STREET,
            'addressLocality' => ADDR_LOCALITY,
            'addressRegion'   => ADDR_REGION,
            'addressCountry'  => ADDR_COUNTRY,
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => GEO_LAT,
            'longitude' => GEO_LNG,
        ],
        'hasMap' => 'https://www.google.com/maps/search/?api=1&query=' . GEO_LAT . ',' . GEO_LNG,
        'openingHoursSpecification' => [[
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday',
                            'Friday', 'Saturday', 'Sunday'],
            'opens'     => '00:00',
            'closes'    => '23:59',
        ]],
        'amenityFeature' => $amenities,
        'parentOrganization' => ['@id' => $id['org']],
    ];

    if ($sameAs !== []) {
        $node['sameAs'] = $sameAs;
    }

    return $node;
}

/** The restaurant and bar, linked to the hotel. */
function schema_restaurant(bool $withMenu = false): array
{
    global $MENU;
    $id = schema_ids();

    $node = [
        '@type'       => ['Restaurant', 'BarOrPub'],
        '@id'         => $id['restaurant'],
        'name'        => 'The Cosy Inn Restaurant & The Cosy Bar',
        'url'         => url('/dining'),
        'servesCuisine' => ['Ugandan', 'East African', 'Continental'],
        'priceRange'  => PRICE_RANGE,
        'telephone'   => PHONE_PRIMARY,
        'image'       => [image_url('photos/cosy-bar', 1200),
                          image_url('photos/dining-table', 1200)],
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => ADDR_STREET,
            'addressLocality' => ADDR_LOCALITY,
            'addressRegion'   => ADDR_REGION,
            'addressCountry'  => ADDR_COUNTRY,
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => GEO_LAT,
            'longitude' => GEO_LNG,
        ],
        'containedInPlace' => ['@id' => $id['hotel']],
    ];

    if ($withMenu && !empty($MENU)) {
        $sections = [];
        foreach ($MENU as $section) {
            $items = [];
            foreach ($section['items'] as $item) {
                $entry = ['@type' => 'MenuItem', 'name' => $item['name']];
                if ($item['price'] !== null) {
                    $entry['offers'] = [
                        '@type'         => 'Offer',
                        'price'         => (string) $item['price'],
                        'priceCurrency' => 'UGX',
                    ];
                }
                $items[] = $entry;
            }
            $sections[] = [
                '@type'           => 'MenuSection',
                'name'            => $section['name'],
                'description'     => $section['note'],
                'hasMenuItem'     => $items,
            ];
        }
        $node['hasMenu'] = [
            '@type'           => 'Menu',
            'name'            => 'The Cosy Inn Kiwenda Menu',
            'inLanguage'      => 'en',
            'hasMenuSection'  => $sections,
        ];
    }

    return $node;
}

/** One Offer per room type, so rates can surface in search. */
function schema_rooms(): array
{
    global $ROOMS;
    $id = schema_ids();
    $nodes = [];

    foreach ($ROOMS ?? [] as $room) {
        $nodes[] = [
            '@type'       => 'HotelRoom',
            '@id'         => url('/rooms#' . $room['slug']),
            'name'        => $room['name'],
            'description' => $room['blurb'],
            'image'       => image_url($room['image'], 1200),
            'bed'         => ['@type' => 'BedDetails', 'typeOfBed' => $room['bed']],
            'occupancy'   => ['@type' => 'QuantitativeValue', 'maxValue' => $room['sleeps']],
            'amenityFeature' => array_map(static fn(string $f): array => [
                '@type' => 'LocationFeatureSpecification', 'name' => $f, 'value' => true,
            ], $room['features']),
            'containedInPlace' => ['@id' => $id['hotel']],
            'potentialAction'  => [
                '@type'  => 'ReserveAction',
                'target' => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => whatsapp_link(
                        'Hello Cosy Inn Kiwenda, I would like to book the ' . $room['name'] . '.'
                    ),
                    'actionPlatform' => ['http://schema.org/MobileWebPlatform'],
                ],
                'result' => ['@type' => 'Reservation', 'name' => 'Room enquiry'],
            ],
            'offers' => [
                '@type'         => 'Offer',
                'price'         => (string) $room['price'],
                'priceCurrency' => CURRENCY,
                'availability'  => 'https://schema.org/InStock',
                'url'           => url('/rooms#' . $room['slug']),
            ],
        ];
    }

    return $nodes;
}

/** Breadcrumbs from a simple [label => path] trail. */
function schema_breadcrumbs(array $trail): array
{
    $items = [];
    $i = 1;
    foreach ($trail as $label => $path) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i++,
            'name'     => $label,
            'item'     => url($path),
        ];
    }
    return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

/** FAQPage from the $FAQS array. Answers must be truthful, Google spot-checks. */
function schema_faq(array $faqs): array
{
    return [
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(static fn(array $f): array => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faqs),
    ];
}

/**
 * Assemble and render the full @graph for a page.
 *
 * @param array $page  ['title' => , 'description' => , 'path' => , 'image' => ]
 * @param array $extra additional nodes for this page only
 */
function render_schema(array $page, array $extra = []): string
{
    $id = schema_ids();

    $graph = [
        [
            '@type' => 'Organization',
            '@id'   => $id['org'],
            'name'  => SITE_NAME,
            'url'   => SITE_URL . '/',
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => url('/assets/img/brand/logo.svg'),
            ],
            'contactPoint' => [[
                '@type'             => 'ContactPoint',
                'telephone'         => PHONE_PRIMARY,
                'contactType'       => 'reservations',
                'areaServed'        => 'UG',
                'availableLanguage' => ['en', 'lg'],
            ]],
        ],
        [
            '@type'    => 'WebSite',
            '@id'      => $id['website'],
            'url'      => SITE_URL . '/',
            'name'     => SITE_NAME,
            'publisher' => ['@id' => $id['org']],
            'inLanguage' => 'en-UG',
        ],
        schema_hotel(),
        [
            '@type'      => 'WebPage',
            '@id'        => url($page['path']) . '#webpage',
            'url'        => url($page['path']),
            'name'       => $page['title'],
            'description' => $page['description'],
            'isPartOf'   => ['@id' => $id['website']],
            'about'      => ['@id' => $id['hotel']],
            'inLanguage' => 'en-UG',
            'primaryImageOfPage' => [
                '@type' => 'ImageObject',
                'url'   => $page['image'] ?? image_url('photos/entrance', 1200),
            ],
        ],
    ];

    foreach ($extra as $node) {
        $graph[] = $node;
    }

    $json = json_encode(
        ['@context' => 'https://schema.org', '@graph' => $graph],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );

    return '<script type="application/ld+json">' . $json . '</script>';
}

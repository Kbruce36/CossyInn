<?php
/**
 * All site content lives here as plain arrays.
 *
 * To change a room rate, a dish price or a gallery caption, edit this file.
 * Nothing else needs to be touched and there is no database to update.
 *
 * MENU PRICES ARE REAL, transcribed from the printed Cosy Inn menu flyer.
 * ROOM RATES come from the owner (USD 50). Room descriptions are PLACEHOLDER.
 * TESTIMONIALS are PLACEHOLDER and are deliberately NOT marked up as
 * structured data, see the note in includes/schema.php.
 */

declare(strict_types=1);

// ---------------------------------------------------------------------------
// ROOMS
// ---------------------------------------------------------------------------
// NOTE FOR THE OWNER: all three tiers are currently priced at USD 50 because
// that is the single rate supplied. Three tiers at an identical price looks
// like a mistake to guests and gives them no reason to choose the higher one.
// Set genuinely different rates here when you have them.
$ROOMS = [
    'standard' => [
        'name'    => 'Standard Room',
        'slug'    => 'standard',
        'tagline' => 'Comfort at great value',
        'price'   => 50,
        'image'   => 'photos/room-deluxe',
        'alt'     => 'Standard room at The Cosy Inn Kiwenda with a king bed, armchair and garden-facing window',
        'sleeps'  => 2,
        'bed'     => 'King bed',
        'size'    => '18 m²',
        'blurb'   => 'A bright, quiet room with a king bed, a private bathroom with '
                   . 'hot water, and a window onto the garden courtyard. Everything '
                   . 'you need for an easy night’s rest, nothing you don’t.',
        'features' => ['King bed', 'Private bathroom', 'Instant hot water', 'Free Wi-Fi',
                       'Desk and chair', 'Daily housekeeping', 'Garden view'],
    ],
    'deluxe' => [
        'name'    => 'Deluxe Room',
        'slug'    => 'deluxe',
        'tagline' => 'More space, more comfort',
        'price'   => 50,
        'image'   => 'photos/room-executive',
        'alt'     => 'Deluxe room at The Cosy Inn Kiwenda with a draped four-poster bed and brick feature wall',
        'sleeps'  => 2,
        'bed'     => 'King bed',
        'size'    => '24 m²',
        'blurb'   => 'A larger room with a draped four-poster bed, a seating corner '
                   . 'and a brick feature wall. The pick for a longer stay or for '
                   . 'guests who want room to spread out.',
        'features' => ['Four-poster king bed', 'Seating area', 'Private bathroom',
                       'Instant hot water', 'Free Wi-Fi', 'Wardrobe', 'Daily housekeeping'],
    ],
    'executive' => [
        'name'    => 'Executive Room',
        'slug'    => 'executive',
        'tagline' => 'A premium experience',
        'price'   => 50,
        'image'   => 'photos/courtyard',
        'alt'     => 'Executive rooms at The Cosy Inn Kiwenda opening onto the planted garden courtyard',
        'sleeps'  => 2,
        'bed'     => 'King bed',
        'size'    => '28 m²',
        'blurb'   => 'Our most private rooms, opening directly onto the planted '
                   . 'courtyard with a veranda of their own. Quiet, shaded and a '
                   . 'few steps from the restaurant and bar.',
        'features' => ['King bed', 'Private veranda', 'Courtyard access', 'Private bathroom',
                       'Instant hot water', 'Free Wi-Fi', 'Seating area', 'Daily housekeeping'],
    ],
];

// ---------------------------------------------------------------------------
// AMENITIES  (the six-icon strip, mirrors the signage at reception)
// ---------------------------------------------------------------------------
$AMENITIES = [
    ['icon' => 'bed',      'title' => 'Comfortable Stay',    'text' => 'Clean, quiet rooms with hot water and daily housekeeping.'],
    ['icon' => 'dish',     'title' => 'Great Food',          'text' => 'Local and continental dishes cooked to order all day.'],
    ['icon' => 'wifi',     'title' => 'Free Wi-Fi',          'text' => 'Complimentary internet throughout the property.'],
    ['icon' => 'users',    'title' => 'Events & Gatherings',  'text' => 'Garden courtyard and lounge for small functions.'],
    ['icon' => 'car',      'title' => 'Secure Parking',      'text' => 'Free off-street parking inside the gated compound.'],
    ['icon' => 'tag',      'title' => 'Affordable Rates',    'text' => 'Honest pricing with no surprises at checkout.'],
];

// ---------------------------------------------------------------------------
// RESTAURANT MENU  (REAL prices, transcribed from the printed flyer)
// ---------------------------------------------------------------------------
// Prices are Uganda Shillings. '20,000/=' on the flyer means UGX 20,000.
$MENU = [
    [
        'name'  => 'Lunch & Dinner',
        'note'  => 'Served with wedges, chips, cassava, mashed potatoes etc.',
        'items' => [
            ['name' => 'Chips & Chicken',            'price' => 20000],
            ['name' => 'Chips & Beef',               'price' => 15000],
            ['name' => 'Chips & Goat’s Meat', 'price' => 20000],
            ['name' => 'Chips, Wedges & Sausage',    'price' => 15000],
            ['name' => 'Beef Katogo',                'price' => 18000],
            ['name' => 'Chicken Katogo',             'price' => 18000],
            ['name' => 'Spaghetti Bolognese',        'price' => 15000],
            ['name' => 'Deep Fried Fish',            'price' => 35000],
        ],
    ],
    [
        'name'  => 'From the Grill & Pot',
        'note'  => null,
        'items' => [
            ['name' => 'Steamed Fish in Foil',          'price' => 35000],
            ['name' => 'Boiled Chicken (full)',         'price' => 40000],
            ['name' => 'Half Chicken',                  'price' => 20000],
            ['name' => 'Quarter Chicken',               'price' => 10000],
            ['name' => 'Posho & Fried Goat’s Meat', 'price' => 20000],
        ],
    ],
    [
        'name'  => 'Breakfast',
        'note'  => 'Served every morning.',
        'items' => [
            ['name' => 'African Tea, African Coffee, Bread & Omelette', 'price' => 10000],
        ],
    ],
    [
        'name'  => 'Juices & Drinks',
        'note'  => 'Passion, mango, melon, pineapple and orange. Cocktails available at the bar.',
        'items' => [
            ['name' => 'Fresh Fruit Juice', 'price' => null],
            ['name' => 'Cocktails',         'price' => null],
        ],
    ],
];

// ---------------------------------------------------------------------------
// GALLERY
// ---------------------------------------------------------------------------
$GALLERY = [
    ['img' => 'photos/entrance',          'cat' => 'property', 'alt' => 'The lit entrance and reception of The Cosy Inn Kiwenda at dusk'],
    ['img' => 'photos/aerial-property',   'cat' => 'property', 'alt' => 'Aerial view of The Cosy Inn Kiwenda showing the courtyard and surrounding greenery'],
    ['img' => 'photos/courtyard',         'cat' => 'property', 'alt' => 'Planted garden courtyard with paved walkways between the guest rooms'],
    ['img' => 'photos/exterior-gate',     'cat' => 'property', 'alt' => 'The gated entrance and secure parking at The Cosy Inn Kiwenda'],
    ['img' => 'photos/room-deluxe',       'cat' => 'rooms',    'alt' => 'Guest room with a king bed, armchair and garden-facing window'],
    ['img' => 'photos/room-executive',    'cat' => 'rooms',    'alt' => 'Guest room with a draped four-poster bed and brick feature wall'],
    ['img' => 'photos/bathroom',          'cat' => 'rooms',    'alt' => 'Tiled private bathroom with instant hot water shower'],
    ['img' => 'photos/cosy-bar',          'cat' => 'dining',   'alt' => 'Guests at the counter of The Cosy Bar with the bartender serving drinks'],
    ['img' => 'photos/dining-table',      'cat' => 'dining',   'alt' => 'Round dining table laid for six in the restaurant'],
    ['img' => 'photos/breakfast-service', 'cat' => 'dining',   'alt' => 'Staff serving breakfast to guests in the dining room'],
    ['img' => 'photos/lounge',            'cat' => 'property', 'alt' => 'Lounge with leather sofas and warm textured walls'],
    ['img' => 'photos/team',              'cat' => 'property', 'alt' => 'The Cosy Inn Kiwenda team in branded uniforms at reception'],
];

$GALLERY_CATS = [
    'all'      => 'All',
    'property' => 'The Property',
    'rooms'    => 'Rooms',
    'dining'   => 'Dining & Bar',
];

// ---------------------------------------------------------------------------
// ATTRACTIONS
// ---------------------------------------------------------------------------
// PLACEHOLDER distances. These are rough road estimates from Kiwenda and must
// be checked before launch, guests plan their day around them.
$ATTRACTIONS = [
    [
        'name'  => 'Namugongo Martyrs Shrine',
        'img'   => 'stock/attraction-namugongo',
        'alt'   => 'The conical roof of the Uganda Martyrs Shrine at Namugongo',
        'dist'  => 'approx. 20 km',
        'time'  => '40 min drive',
        'blurb' => 'The basilica built where the Uganda Martyrs were killed in 1886, '
                 . 'and the destination of one of Africa’s largest annual pilgrimages '
                 . 'each June. Its copper-clad conical roof echoes a traditional Kiganda hut.',
    ],
    [
        'name'  => 'Kampala City',
        'img'   => 'stock/attraction-kampala',
        'alt'   => 'The Kampala city skyline',
        'dist'  => 'approx. 25 km',
        'time'  => '1 hr drive',
        'blurb' => 'Uganda’s capital, with the Uganda Museum, the Gaddafi National '
                 . 'Mosque, the Kasubi Tombs and the sprawl of Owino Market. Close '
                 . 'enough for a day in town, far enough to sleep in quiet.',
    ],
    [
        'name'  => 'Ssezibwa Falls',
        'img'   => 'stock/attraction-ssezibwa-falls',
        'alt'   => 'Water dropping over the rocks at Ssezibwa Falls, surrounded by forest',
        'dist'  => 'approx. 45 km',
        'time'  => '1 hr 15 min drive',
        'blurb' => 'A set of falls on the Ssezibwa river that is both a scenic picnic '
                 . 'spot and an important cultural site for the Baganda. Short forest '
                 . 'walks, birdlife and rock outcrops to climb.',
    ],
    [
        'name'  => 'Entebbe Botanical Gardens',
        'img'   => 'stock/attraction-entebbe-gardens',
        'alt'   => 'Palms and lawns at the Entebbe Botanical Gardens on the shore of Lake Victoria',
        'dist'  => 'approx. 60 km',
        'time'  => '1 hr 45 min drive',
        'blurb' => 'Lakeshore gardens laid out in 1898, full of mature palms, monkeys '
                 . 'and birds, right beside Lake Victoria and a short hop from '
                 . 'Entebbe International Airport.',
    ],
    [
        'name'  => 'Lake Victoria',
        'img'   => 'stock/attraction-lake-victoria',
        'alt'   => 'The shoreline of Lake Victoria with boats and green vegetation',
        'dist'  => 'approx. 55 km',
        'time'  => '1 hr 30 min drive',
        'blurb' => 'Africa’s largest lake, with boat trips to the Ssese Islands, '
                 . 'fishing villages and some of the best sunsets in the country.',
    ],
    [
        'name'  => 'Mabira Forest',
        'img'   => 'stock/attraction-mabira',
        'alt'   => 'A stream running through the dense canopy of Mabira Forest',
        'dist'  => 'approx. 70 km',
        'time'  => '1 hr 45 min drive',
        'blurb' => 'One of Uganda’s largest surviving rainforests, with marked '
                 . 'walking trails, a zip line through the canopy and over 300 '
                 . 'recorded bird species.',
    ],
];

// ---------------------------------------------------------------------------
// TESTIMONIALS  --  PLACEHOLDER, every one of these is invented
// ---------------------------------------------------------------------------
// Replace with real guest feedback before launch. These are shown on the page
// but are deliberately NOT emitted as Review structured data. Marking up
// invented reviews violates Google's structured data policy and risks a manual
// action, which is the opposite of what good SEO is for.
$TESTIMONIALS = [
    ['quote' => 'A clean, quiet and welcoming place. The staff are very friendly and '
              . 'the food is excellent. I would happily stay again.',
     'name'  => 'Sample Guest', 'from' => 'Kampala'],
    ['quote' => 'The garden is beautiful and the rooms are spotless. Breakfast was '
              . 'ready early which made our drive to the airport easy.',
     'name'  => 'Sample Guest', 'from' => 'Nairobi'],
    ['quote' => 'Good value, secure parking and genuinely kind people at reception. '
              . 'A proper home away from home.',
     'name'  => 'Sample Guest', 'from' => 'Jinja'],
];

// ---------------------------------------------------------------------------
// FAQ  (feeds the FAQPage structured data, so keep answers truthful)
// ---------------------------------------------------------------------------
$FAQS = [
    ['q' => 'Where exactly is The Cosy Inn Kiwenda?',
     'a' => 'We are in Kiwenda, off the Gayaza-Zirobwe road in Wakiso District, '
          . 'about an hour north of central Kampala.'],
    ['q' => 'How do I book a room?',
     'a' => 'Message us on WhatsApp at ' . WHATSAPP_DISPLAY . ' or call the same '
          . 'number. We confirm availability directly with you.'],
    ['q' => 'What are your check-in and check-out times?',
     'a' => 'Check-in is from ' . CHECK_IN . ' and check-out is by ' . CHECK_OUT . '. '
          . 'Let us know in advance if you need to arrive late.'],
    ['q' => 'Is there parking?',
     'a' => 'Yes. Parking is free, off-street and inside the gated compound.'],
    ['q' => 'Is Wi-Fi included?',
     'a' => 'Yes, Wi-Fi is free for all guests throughout the property.'],
    ['q' => 'Do you serve food to people who are not staying overnight?',
     'a' => 'Yes. The restaurant and The Cosy Bar are open to everyone, not only '
          . 'to overnight guests.'],
    ['q' => 'Can you cater for a special request or a large order?',
     'a' => 'Yes. Our kitchen takes special orders. Message us on WhatsApp ahead '
          . 'of time so the team can prepare.'],
];

// ---------------------------------------------------------------------------
// PHOTO CREDITS  (Creative Commons images require attribution, this is not optional)
// ---------------------------------------------------------------------------
$PHOTO_CREDITS = [
    ['file' => 'attraction-ssezibwa-falls', 'title' => 'Ssezibwa Falls1.jpg',
     'author' => 'Wikimedia Commons contributor', 'licence' => 'CC BY-SA 4.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:Ssezibwa_Falls1.jpg'],
    ['file' => 'attraction-namugongo', 'title' => 'Namugongo Martyrs Shrine exterior view.jpg',
     'author' => 'Wikimedia Commons contributor', 'licence' => 'CC BY 2.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:Namugongo_Martyrs_Shrine_exterior_view.jpg'],
    ['file' => 'attraction-lake-victoria', 'title' => 'Shores of Lake Victoria at Ssese Islands.jpg',
     'author' => 'Wikimedia Commons contributor', 'licence' => 'CC BY-SA 4.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:Shores_of_Lake_Victoria_at_Ssese_Islands.jpg'],
    ['file' => 'attraction-kampala', 'title' => 'Kampala skyline.jpg',
     'author' => 'Wikimedia Commons contributor', 'licence' => 'CC BY 2.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:Kampala_skyline.jpg'],
    ['file' => 'attraction-entebbe-gardens', 'title' => 'Entebbe Botanical Gardens 3.jpg',
     'author' => 'Wikimedia Commons contributor', 'licence' => 'CC BY 2.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:Entebbe_Botanical_Gardens_3.jpg'],
    ['file' => 'attraction-mabira', 'title' => 'A stagnant stream in Mabira Forest.jpg',
     'author' => 'Wikimedia Commons contributor', 'licence' => 'CC BY-SA 4.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:A_stagnant_stream_in_Mabira_Forest.jpg'],
    ['file' => 'food & drink photography', 'title' => 'Various',
     'author' => 'Unsplash contributors', 'licence' => 'Unsplash Licence',
     'source' => 'https://unsplash.com'],
];

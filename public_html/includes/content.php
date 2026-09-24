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
// Ordered by distance from the gate, nearest first. The homepage shows the
// first three, so the closest places are the ones a guest sees first.
//
// PLACEHOLDER distances. Every 'dist' and 'time' below is a road estimate and
// must be driven or checked on Google Maps before launch. Guests plan a day
// around these numbers, and the near ones are the easiest to get wrong.
$ATTRACTIONS = [
    [
        'name'  => 'Theron Leisure Park',
        'img'   => 'stock/attraction-theron',
        'alt'   => 'A tyre obstacle on the high ropes course at Theron Leisure Park, strung between eucalyptus trees',
        'dist'  => 'approx. 2 km',
        'time'  => '5 min drive',
        'blurb' => 'Our nearest neighbour on the Gayaza-Zirobwe road. A dual 250 m '
                 . 'zipline, a high ropes course, jungle paintball and a pool, all '
                 . 'set in eucalyptus woodland. The easiest half day you can have '
                 . 'from here.',
    ],
    [
        'name'  => 'Bugema University',
        'img'   => 'stock/attraction-bugema',
        'alt'   => 'A red brick building with clipped hedges and mature palms on the Bugema University campus',
        'dist'  => 'approx. 5 km',
        'time'  => '10 min drive',
        'blurb' => 'A Seventh-day Adventist university on 640 acres of lawns, brick '
                 . 'chapels and mature palms, and the landmark most people in the '
                 . 'area navigate by. The grounds are pleasant to walk.',
    ],
    [
        'name'  => 'Extreme Adventure Park, Busiika',
        'img'   => 'stock/attraction-extreme-park',
        'alt'   => 'A go-kart on the racing circuit at Extreme Adventure Park in Busiika',
        'dist'  => 'approx. 10 km',
        'time'  => '20 min drive',
        'blurb' => 'Built on the old Busiika motorsport arena, and home to the '
                 . 'largest go-kart track in Africa. Also quad bikes, high ropes, '
                 . 'a zipline, archery, paintball and target shooting.',
    ],
    [
        'name'  => 'Namulonge Golf Club',
        'img'   => 'stock/attraction-namulonge-golf',
        'alt'   => 'Three golfers walking the fairway at the Mary Louise Simkins Memorial Golf Club, Namulonge',
        'dist'  => 'approx. 12 km',
        'time'  => '25 min drive',
        'blurb' => 'The Mary Louise Simkins Memorial course, a 9-hole parkland '
                 . 'layout dating to 1960, laid out on the grounds of the national '
                 . 'crops research institute at Namulonge. Visitors are welcome.',
    ],
    [
        'name'  => 'Ugasil Farm coffee tour',
        'img'   => 'stock/attraction-coffee-tour',
        'alt'   => 'Ripe red coffee cherries spread out to dry on a raised drying bed at a Ugandan farm',
        'dist'  => 'approx. 15 km',
        'time'  => '30 min drive',
        'blurb' => 'Crop to cup on a working farm outside Gayaza. You walk the '
                 . 'coffee garden, pick cherries in season, then dry, roast, grind '
                 . 'and drink what you picked. Uganda is the home of wild robusta.',
    ],
    [
        'name'  => 'The Great Outdoors, Kalanamu',
        'img'   => 'stock/attraction-great-outdoors',
        'alt'   => 'Evening sunlight through the trees over log benches in the forest at The Great Outdoors, Kalanamu',
        'dist'  => 'approx. 18 km',
        'time'  => '35 min drive',
        'blurb' => 'An eco forest resort built for slowing down. Guided nature '
                 . 'walks with a birding guide, cycling, swimming and a bonfire '
                 . 'after dark. Day visitors are welcome for lunch and a walk.',
    ],
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
        'name'  => 'Bahá’í Temple, Kikaaya',
        'img'   => 'stock/attraction-bahai-temple',
        'alt'   => 'The green dome of the Bahá’í House of Worship on Kikaaya Hill, above its gardens',
        'dist'  => 'approx. 22 km',
        'time'  => '40 min drive',
        'blurb' => 'The Mother Temple of Africa, and the only Bahá’í House of '
                 . 'Worship on the continent. Nine sides, nine doors, a green dome '
                 . 'on a hill, and 50 acres of gardens that are open to anyone.',
    ],
    [
        'name'  => 'Kampala City',
        'img'   => 'stock/attraction-kampala',
        'alt'   => 'The Kampala city skyline',
        'dist'  => 'approx. 28 km',
        'time'  => '35 min drive',
        'blurb' => 'Uganda’s capital, with the Uganda Museum, the Gaddafi National '
                 . 'Mosque, the Kasubi Tombs and the sprawl of Owino Market. Close '
                 . 'enough for a day in town, far enough to sleep in quiet.',
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
    // --- Creative Commons, from Wikimedia Commons ---------------------------
    ['file' => 'attraction-namugongo', 'title' => 'Namugongo Martyrs Shrine exterior view.jpg',
     'author' => 'Isabelle Prondzynski', 'licence' => 'CC BY 2.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:Namugongo_Martyrs_Shrine_exterior_view.jpg'],
    ['file' => 'attraction-kampala', 'title' => 'Kampala skyline.jpg',
     'author' => 'Todd Huffman', 'licence' => 'CC BY 2.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:Kampala_skyline.jpg'],
    ['file' => 'attraction-bahai-temple', 'title' => '19 Bahai Temple Kampala Hilltop View 1.jpg',
     'author' => 'Alvinategyeka', 'licence' => 'CC BY 4.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:19_Bahai_Temple_Kampala_Hilltop_View_1.jpg'],
    ['file' => 'attraction-coffee-tour', 'title' => 'Women drying coffee.jpg',
     'author' => 'PHILIP ASEDRI DRADRIO', 'licence' => 'CC BY-SA 4.0',
     'source' => 'https://commons.wikimedia.org/wiki/File:Women_drying_coffee.jpg'],

    // --- Each venue's own photograph, from its own website -------------------
    // NOT openly licensed. Get written permission from each venue before
    // launch, or replace these with photographs of your own. Most venues say
    // yes straight away, a hotel sending them guests is free advertising.
    ['file' => 'attraction-theron', 'title' => 'Theron Leisure Park, high ropes course',
     'author' => 'Theron Leisure Park & Residences', 'licence' => 'Venue photograph',
     'source' => 'https://theronleisurepark.com/'],
    ['file' => 'attraction-extreme-park', 'title' => 'Extreme Adventure Park, go-karting',
     'author' => 'Extreme Adventure Park Busika', 'licence' => 'Venue photograph',
     'source' => 'https://www.extremeadventures.co.ug/product/go-karting/'],
    ['file' => 'attraction-great-outdoors', 'title' => 'The Great Outdoors, forest clearing',
     'author' => 'Great Outdoors Uganda, Kalanamu', 'licence' => 'Venue photograph',
     'source' => 'https://greatoutdoorsuganda.com/'],
    ['file' => 'attraction-bugema', 'title' => 'Bugema University, campus building',
     'author' => 'Bugema University', 'licence' => 'Venue photograph',
     'source' => 'https://bugemauniv.ac.ug/'],
    ['file' => 'attraction-namulonge-golf', 'title' => 'Namulonge Golf Club, on the fairway',
     'author' => 'Mary Louise Simkins Memorial Golf Club', 'licence' => 'Venue photograph',
     'source' => 'https://longegolf.com/'],

    // --- Food and drink ------------------------------------------------------
    ['file' => 'food & drink photography', 'title' => 'Various',
     'author' => 'Unsplash contributors', 'licence' => 'Unsplash Licence',
     'source' => 'https://unsplash.com'],
];

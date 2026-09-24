<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'titleFull'   => 'The Cosy Inn Kiwenda | Hotel & Restaurant near Kampala',
    'description' => 'A quiet family-run inn in Kiwenda, Wakiso District. En-suite rooms '
                   . 'from $' . PRICE_FROM . ' a night, a restaurant, bar, free Wi-Fi and secure '
                   . 'parking, an hour from Kampala.',
    'path'        => '/',
    'image'       => image_url('photos/entrance', 1200),
    'preload'     => 'photos/entrance',
    'schema'      => array_merge(
        [schema_restaurant(), schema_faq($FAQS)],
        schema_rooms()
    ),
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <!-- ===================================================== hero ===== -->
  <section class="hero">
    <div class="hero__media">
      <?= picture('photos/entrance',
            'The lit entrance and reception of The Cosy Inn Kiwenda at dusk',
            ['sizes' => '100vw', 'loading' => 'eager', 'fetchpriority' => 'high']) ?>
    </div>
    <div class="wrap">
      <div class="hero__inner">
        <p class="hero__eyebrow">Welcome to</p>
        <h1 class="hero__title">The Cosy Inn <em>Kiwenda</em></h1>
        <p class="hero__strap"><?= e(SITE_STRAPLINE) ?></p>
        <p class="hero__tagline">&ldquo;<?= e(SITE_TAGLINE) ?>&rdquo;</p>
        <div class="hero__actions">
          <a class="btn btn--gold btn--lg" href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener">
            <?= icon('whatsapp', 'icon icon--sm') ?> Book Your Stay
          </a>
          <a class="btn btn--light btn--lg" href="/rooms">See Rooms &amp; Rates</a>
        </div>
        <p class="hero__note">
          <?= icon('pin', 'icon icon--sm') ?>
          Kiwenda, Wakiso District &middot; about an hour from Kampala
        </p>
      </div>
    </div>
  </section>

  <!-- ================================================= features ===== -->
  <section class="features" aria-label="What we offer">
    <div class="wrap">
      <div class="features__grid">
        <?php foreach ($AMENITIES as $a): ?>
          <div class="feature">
            <span class="feature__icon"><?= icon($a['icon']) ?></span>
            <h2 class="feature__title"><?= e($a['title']) ?></h2>
            <p class="feature__text"><?= e($a['text']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ==================================================== rooms ===== -->
  <section class="section">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">Stay with us</span>
        <h2 class="shead__title">Our <em>Rooms</em></h2>
        <p class="shead__sub">
          Spacious, spotless and quiet, with hot water, free Wi-Fi and a bed
          you will actually sleep in. Every room is en-suite.
        </p>
      </div>

      <div class="grid grid--3">
        <?php $i = 0; foreach ($ROOMS as $room): $i++; ?>
          <article class="card reveal" data-reveal-delay="<?= $i * 90 ?>">
            <div class="card__media">
              <?= picture($room['image'], $room['alt'],
                    ['sizes' => '(min-width:1000px) 380px, (min-width:720px) 50vw, 100vw']) ?>
            </div>
            <div class="card__body">
              <h3 class="card__title"><?= e($room['name']) ?></h3>
              <p class="card__text"><?= e($room['tagline']) ?></p>
              <div class="meta-row">
                <span class="chip"><?= e($room['bed']) ?></span>
                <span class="chip">Sleeps <?= (int) $room['sleeps'] ?></span>
                <span class="chip">En-suite</span>
              </div>
              <div class="card__foot">
                <span class="card__price">
                  $<?= (int) $room['price'] ?><small>/night</small>
                </span>
                <a class="link-arrow" href="/rooms#<?= e($room['slug']) ?>">
                  View details <?= icon('arrow', 'icon icon--sm') ?>
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <p class="center" style="margin-top:2.5rem">
        <a class="btn btn--maroon btn--lg" href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener">
          <?= icon('whatsapp', 'icon icon--sm') ?> Check availability on WhatsApp
        </a>
      </p>
    </div>
  </section>

  <!-- =================================================== dining ===== -->
  <section class="section section--cream">
    <div class="wrap">
      <div class="split split--wide reveal">
        <div class="split__media framed">
          <?= picture('photos/cosy-bar',
                'Guests at the counter of The Cosy Bar with the bartender serving drinks',
                ['sizes' => '(min-width:720px) 50vw, 100vw']) ?>
        </div>
        <div class="split__body">
          <span class="shead__eyebrow">Eat &amp; drink</span>
          <h2 class="shead__title">Good food, <em>good mood</em></h2>
          <p>
            Our kitchen cooks local and continental dishes to order, from chips
            and chicken to katogo, grilled fish and full roast chicken. Breakfast
            is African tea or coffee with bread and an omelette.
          </p>
          <p>
            Next door, The Cosy Bar pours cold beer, spirits, fresh fruit juice
            and cocktails. Both are open to everyone, not only to overnight guests.
          </p>
          <ul class="ticks">
            <li><?= icon('check', 'icon icon--sm') ?> Breakfast from <?= e(ugx(10000)) ?></li>
            <li><?= icon('check', 'icon icon--sm') ?> Local and continental mains all day</li>
            <li><?= icon('check', 'icon icon--sm') ?> Special orders welcome, just ask ahead</li>
          </ul>
          <p style="margin-top:1.5rem">
            <a class="btn btn--maroon" href="/dining">See the full menu</a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================== attractions ===== -->
  <section class="section">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">Around us</span>
        <h2 class="shead__title">Worth the <em>short drive</em></h2>
        <p class="shead__sub">
          Ziplines, go-karts and a golf course, all closer to the gate than
          Kampala is.
        </p>
      </div>

      <div class="grid grid--3">
        <?php $i = 0; foreach (array_slice($ATTRACTIONS, 0, 3) as $a) echo attraction_card($a, ['heading' => 'h3', 'delay' => ++$i * 90, 'distance' => false]); ?>
      </div>

      <p class="center" style="margin-top:2.5rem">
        <a class="link-arrow" href="/attractions">
          See all attractions <?= icon('arrow', 'icon icon--sm') ?>
        </a>
      </p>
    </div>
  </section>

  <!-- ================================================== gallery ===== -->
  <section class="section section--cream">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">A look around</span>
        <h2 class="shead__title">The <em>Gallery</em></h2>
      </div>
      <div class="gallery reveal">
        <?php foreach (array_slice($GALLERY, 0, 8) as $g): ?>
          <figure class="gitem">
            <?= picture($g['img'], $g['alt'], ['sizes' => '(min-width:1000px) 25vw, 50vw']) ?>
          </figure>
        <?php endforeach; ?>
      </div>
      <p class="center" style="margin-top:2rem">
        <a class="btn btn--ghost" href="/gallery">View the full gallery</a>
      </p>
    </div>
  </section>

  <!-- ============================================= testimonials ===== -->
  <section class="section">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">Guest feedback</span>
        <h2 class="shead__title">What our <em>guests say</em></h2>
      </div>

      <div class="quotes reveal" style="max-width:52rem;margin-inline:auto">
        <?php foreach ($TESTIMONIALS as $n => $t): ?>
          <blockquote class="quote<?= $n === 0 ? ' is-active' : '' ?>">
            <div class="quote__stars" aria-hidden="true">
              <?= str_repeat(icon('star', 'icon'), 5) ?>
            </div>
            <p class="quote__text"><?= e($t['quote']) ?></p>
            <footer class="quote__who">
              <?= e($t['name']) ?> &middot; <?= e($t['from']) ?>
            </footer>
          </blockquote>
        <?php endforeach; ?>

        <div class="qnav">
          <button class="qarrow qarrow--prev" type="button" aria-label="Previous review">
            <?= icon('chevron-l', 'icon icon--sm') ?>
          </button>
          <div class="qdots">
            <?php foreach ($TESTIMONIALS as $n => $t): ?>
              <button class="qdot<?= $n === 0 ? ' is-active' : '' ?>" type="button"
                      aria-label="Review <?= $n + 1 ?>"></button>
            <?php endforeach; ?>
          </div>
          <button class="qarrow qarrow--next" type="button" aria-label="Next review">
            <?= icon('chevron-r', 'icon icon--sm') ?>
          </button>
        </div>

        <!-- Remove this note once real guest reviews replace the samples. -->
        <p class="placeholder-note">
          Sample reviews shown while we gather real guest feedback.
        </p>
      </div>
    </div>
  </section>

  <!-- =================================================== findus ===== -->
  <section class="section section--cream">
    <div class="wrap">
      <div class="findus">
        <div class="reveal">
          <span class="shead__eyebrow">Find us</span>
          <h2 class="shead__title">Easy to <em>reach</em></h2>
          <p class="shead__sub" style="margin-bottom:1.75rem">
            We are in Kiwenda, off the Gayaza-Zirobwe road, far enough from town
            to be quiet and close enough to get there.
          </p>

          <div class="infolist">
            <div class="infoitem">
              <span class="infoitem__icon"><?= icon('pin', 'icon icon--sm') ?></span>
              <div>
                <p class="infoitem__label">Address</p>
                <p class="infoitem__value"><?= e(ADDR_FULL) ?></p>
              </div>
            </div>
            <div class="infoitem">
              <span class="infoitem__icon"><?= icon('whatsapp', 'icon icon--sm') ?></span>
              <div>
                <p class="infoitem__label">Bookings</p>
                <p class="infoitem__value">
                  <a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener">
                    <?= e(WHATSAPP_DISPLAY) ?>
                  </a>
                </p>
              </div>
            </div>
            <div class="infoitem">
              <span class="infoitem__icon"><?= icon('clock', 'icon icon--sm') ?></span>
              <div>
                <p class="infoitem__label">Check in / Check out</p>
                <p class="infoitem__value">From <?= e(CHECK_IN) ?> &middot; by <?= e(CHECK_OUT) ?></p>
              </div>
            </div>
          </div>

          <p style="margin-top:1.75rem">
            <a class="btn btn--maroon" href="/directions">Get directions</a>
          </p>
        </div>

        <div class="findus__map reveal"
             data-map-src="https://www.google.com/maps?q=<?= e(GEO_LAT) ?>,<?= e(GEO_LNG) ?>&hl=en&z=14&output=embed">
          <noscript>
            <a href="https://www.google.com/maps/search/?api=1&query=<?= e(GEO_LAT) ?>,<?= e(GEO_LNG) ?>"
               target="_blank" rel="noopener">Open our location in Google Maps</a>
          </noscript>
        </div>
      </div>
    </div>
  </section>

  <!-- ====================================================== cta ===== -->
  <section class="cta">
    <div class="cta__media">
      <?= picture('photos/courtyard',
            'The planted garden courtyard at The Cosy Inn Kiwenda',
            ['sizes' => '100vw']) ?>
    </div>
    <div class="wrap">
      <div class="cta__inner">
        <h2 class="cta__title">Your home of comfort is ready</h2>
        <p class="cta__text">
          Message us on WhatsApp and we will confirm a room for you the same day.
          No forms, no waiting, just tell us the dates.
        </p>
        <div class="cta__actions">
          <a class="btn btn--gold btn--lg" href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener">
            <?= icon('whatsapp', 'icon icon--sm') ?> Book on WhatsApp
          </a>
          <a class="btn btn--light btn--lg" href="tel:<?= e(PHONE_PRIMARY) ?>">
            <?= icon('phone', 'icon icon--sm') ?> <?= e(PHONE_PRIMARY_DISPLAY) ?>
          </a>
        </div>
      </div>
    </div>
  </section>

</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'titleFull'   => 'Contact & Book a Room | The Cosy Inn Kiwenda, Wakiso',
    'description' => 'Book a room at The Cosy Inn Kiwenda on WhatsApp at ' . WHATSAPP_DISPLAY
                   . ', or call the same number. Kiwenda, Wakiso District. Reception open '
                   . 'daily.',
    'path'        => '/contact',
    'image'       => image_url('photos/team', 1200),
    'preload'     => 'photos/team',
    'breadcrumbs' => ['Home' => '/', 'Contact' => '/contact'],
    'schema'      => [schema_faq($FAQS)],
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <section class="phero">
    <div class="phero__media">
      <?= picture('photos/team', '', ['sizes' => '100vw', 'loading' => 'eager']) ?>
    </div>
    <div class="wrap">
      <div class="phero__inner">
        <ol class="crumbs">
          <li><a href="/">Home</a></li>
          <li>Contact</li>
        </ol>
        <h1 class="phero__title">Contact &amp; Booking</h1>
        <p class="phero__sub">
          The fastest way to book is WhatsApp. Send us your dates and we will
          confirm a room the same day.
        </p>
      </div>
    </div>
  </section>

  <!-- ============================================== booking cards ===== -->
  <section class="section">
    <div class="wrap">
      <div class="grid grid--3">

        <article class="card reveal">
          <div class="card__body" style="align-items:flex-start">
            <span class="feature__icon" style="background:#d9f7e4;color:#0f7a3d">
              <?= icon('whatsapp') ?>
            </span>
            <h2 class="card__title" style="font-size:1.2rem">WhatsApp</h2>
            <p class="card__text">
              Message us any time. This is how most of our guests book, and it is
              the quickest way to get an answer.
            </p>
            <a class="btn btn--maroon btn--block" href="<?= e(whatsapp_link()) ?>"
               target="_blank" rel="noopener">
              <?= icon('whatsapp', 'icon icon--sm') ?> <?= e(WHATSAPP_DISPLAY) ?>
            </a>
          </div>
        </article>

        <article class="card reveal" data-reveal-delay="90">
          <div class="card__body" style="align-items:flex-start">
            <span class="feature__icon"><?= icon('phone') ?></span>
            <h2 class="card__title" style="font-size:1.2rem">Call reception</h2>
            <p class="card__text">
              Prefer to speak to someone? Reception answers during the day and
              into the evening, every day of the week.
            </p>
            <a class="btn btn--ghost btn--block" href="tel:<?= e(PHONE_PRIMARY) ?>">
              <?= icon('phone', 'icon icon--sm') ?> <?= e(PHONE_PRIMARY_DISPLAY) ?>
            </a>
          </div>
        </article>

        <article class="card reveal" data-reveal-delay="180">
          <div class="card__body" style="align-items:flex-start">
            <span class="feature__icon"><?= icon('mail') ?></span>
            <h2 class="card__title" style="font-size:1.2rem">Email</h2>
            <p class="card__text">
              For group bookings, events or anything that needs a paper trail,
              email us and we will reply in writing.
            </p>
            <a class="btn btn--ghost btn--block" href="mailto:<?= e(EMAIL_PRIMARY) ?>">
              <?= icon('mail', 'icon icon--sm') ?> <?= e(EMAIL_PRIMARY) ?>
            </a>
          </div>
        </article>

      </div>
    </div>
  </section>

  <!-- =================================================== details ===== -->
  <section class="section section--cream">
    <div class="wrap">
      <div class="findus">
        <div class="reveal">
          <span class="shead__eyebrow">Practical details</span>
          <h2 class="shead__title">Everything <em>in one place</em></h2>

          <div class="infolist" style="margin-top:1.75rem">
            <div class="infoitem">
              <span class="infoitem__icon"><?= icon('pin', 'icon icon--sm') ?></span>
              <div>
                <p class="infoitem__label">Address</p>
                <p class="infoitem__value"><?= e(ADDR_FULL) ?></p>
              </div>
            </div>
            <div class="infoitem">
              <span class="infoitem__icon"><?= icon('clock', 'icon icon--sm') ?></span>
              <div>
                <p class="infoitem__label">Check in / Check out</p>
                <p class="infoitem__value">From <?= e(CHECK_IN) ?> &middot; out by <?= e(CHECK_OUT) ?></p>
              </div>
            </div>
            <div class="infoitem">
              <span class="infoitem__icon"><?= icon('tag', 'icon icon--sm') ?></span>
              <div>
                <p class="infoitem__label">Rates</p>
                <p class="infoitem__value">Rooms from $<?= (int) PRICE_FROM ?> per night</p>
              </div>
            </div>
            <div class="infoitem">
              <span class="infoitem__icon"><?= icon('car', 'icon icon--sm') ?></span>
              <div>
                <p class="infoitem__label">Parking</p>
                <p class="infoitem__value">Free, secure, inside the gate</p>
              </div>
            </div>
          </div>
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

  <!-- ======================================================== faq ===== -->
  <section class="section">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">Before you message</span>
        <h2 class="shead__title">Common <em>questions</em></h2>
      </div>

      <div class="faq reveal">
        <?php foreach ($FAQS as $i => $f): ?>
          <div class="faq__item">
            <h3>
              <button class="faq__q" type="button" aria-expanded="false"
                      id="cfaq-q-<?= $i ?>" aria-controls="cfaq-a-<?= $i ?>">
                <span><?= e($f['q']) ?></span>
                <span class="faq__sign" aria-hidden="true"></span>
              </button>
            </h3>
            <div class="faq__a" id="cfaq-a-<?= $i ?>" role="region" aria-labelledby="cfaq-q-<?= $i ?>">
              <div><p><?= e($f['a']) ?></p></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

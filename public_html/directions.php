<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'titleFull'   => 'How to Find Us from Kampala | The Cosy Inn Kiwenda',
    'description' => 'How to reach The Cosy Inn Kiwenda from Kampala, Entebbe Airport or '
                   . 'Gayaza, by car or by taxi, with a map pin for Kiwenda in Wakiso '
                   . 'District.',
    'path'        => '/directions',
    'image'       => image_url('photos/exterior-gate', 1200),
    'preload'     => 'photos/exterior-gate',
    'breadcrumbs' => ['Home' => '/', 'Directions' => '/directions'],
];

$routes = [
    [
        'from'  => 'From Kampala city centre',
        'time'  => 'about 1 hour',
        'dist'  => 'approx. 25 km',
        'steps' => [
            'Head north out of the city on the Kampala-Gayaza road.',
            'Continue through Kalerwe and Kanyanya towards Gayaza town.',
            'At Gayaza, join the Gayaza-Zirobwe road heading north east.',
            'Continue to Kiwenda trading centre.',
            'The Cosy Inn is signposted on the right. Look for the maroon gate.',
        ],
    ],
    [
        'from'  => 'From Entebbe International Airport',
        'time'  => 'about 1 hour 45 minutes',
        'dist'  => 'approx. 60 km',
        'steps' => [
            'Take the Entebbe-Kampala expressway towards Kampala.',
            'Join the northern bypass to avoid the city centre.',
            'Exit onto the Kampala-Gayaza road heading north.',
            'Continue to Gayaza, then on to Kiwenda as above.',
        ],
    ],
    [
        'from'  => 'By public transport',
        'time'  => 'varies',
        'dist'  => null,
        'steps' => [
            'Take a taxi (matatu) from the Old Taxi Park in Kampala towards Gayaza.',
            'Change at Gayaza for a Zirobwe-bound taxi and ask for Kiwenda.',
            'From Kiwenda trading centre it is a short boda-boda ride to the gate.',
            'Message us on WhatsApp when you set off and we will guide your rider in.',
        ],
    ],
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <section class="phero">
    <div class="phero__media">
      <?= picture('photos/exterior-gate', '', ['sizes' => '100vw', 'loading' => 'eager']) ?>
    </div>
    <div class="wrap">
      <div class="phero__inner">
        <ol class="crumbs">
          <li><a href="/">Home</a></li>
          <li>Directions</li>
        </ol>
        <h1 class="phero__title">Finding Us</h1>
        <p class="phero__sub">
          Kiwenda, off the Gayaza-Zirobwe road in Wakiso District.
          Here is the easiest way in, whichever direction you are coming from.
        </p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap">
      <div class="findus">
        <div class="reveal">
          <span class="shead__eyebrow">The address</span>
          <h2 class="shead__title">Where we <em>are</em></h2>
          <div class="infolist" style="margin-top:1.75rem">
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
                <p class="infoitem__label">Lost? Message us</p>
                <p class="infoitem__value">
                  <a href="<?= e(whatsapp_link('Hello Cosy Inn Kiwenda, I am on my way and need directions.')) ?>"
                     target="_blank" rel="noopener"><?= e(WHATSAPP_DISPLAY) ?></a>
                </p>
              </div>
            </div>
            <div class="infoitem">
              <span class="infoitem__icon"><?= icon('car', 'icon icon--sm') ?></span>
              <div>
                <p class="infoitem__label">Parking</p>
                <p class="infoitem__value">Free and secure, inside the gate</p>
              </div>
            </div>
          </div>
          <p style="margin-top:1.75rem">
            <a class="btn btn--maroon"
               href="https://www.google.com/maps/search/?api=1&query=<?= e(GEO_LAT) ?>,<?= e(GEO_LNG) ?>"
               target="_blank" rel="noopener">
              <?= icon('pin', 'icon icon--sm') ?> Open in Google Maps
            </a>
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

  <section class="section section--cream">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">Getting here</span>
        <h2 class="shead__title">Route by <em>route</em></h2>
      </div>

      <div class="grid grid--3">
        <?php foreach ($routes as $i => $r): ?>
          <article class="card reveal" data-reveal-delay="<?= $i * 90 ?>">
            <div class="card__body">
              <h3 class="card__title" style="font-size:1.2rem"><?= e($r['from']) ?></h3>
              <div class="meta-row">
                <span class="chip"><?= icon('clock', 'icon icon--sm') ?> <?= e($r['time']) ?></span>
                <?php if ($r['dist']): ?>
                  <span class="chip"><?= e($r['dist']) ?></span>
                <?php endif; ?>
              </div>
              <ol class="ticks" style="counter-reset:step;margin-top:.5rem">
                <?php foreach ($r['steps'] as $s): ?>
                  <li><?= icon('arrow', 'icon icon--sm') ?> <?= e($s) ?></li>
                <?php endforeach; ?>
              </ol>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <p class="placeholder-note" style="margin-top:2rem">
        Drive times are estimates and depend heavily on Kampala traffic.
        The map pin is approximate and is being confirmed.
      </p>
    </div>
  </section>

  <section class="cta">
    <div class="cta__media">
      <?= picture('photos/entrance', '', ['sizes' => '100vw']) ?>
    </div>
    <div class="wrap">
      <div class="cta__inner">
        <h2 class="cta__title">Tell us when you are coming</h2>
        <p class="cta__text">
          Message ahead and we will have a room ready and someone watching for you
          at the gate.
        </p>
        <div class="cta__actions">
          <a class="btn btn--gold btn--lg" href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener">
            <?= icon('whatsapp', 'icon icon--sm') ?> Book on WhatsApp
          </a>
        </div>
      </div>
    </div>
  </section>

</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

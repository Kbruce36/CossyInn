<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'titleFull'   => 'En-suite Rooms & Rates | The Cosy Inn Kiwenda, Wakiso',
    'description' => 'En-suite rooms at The Cosy Inn Kiwenda from $' . PRICE_FROM . ' per night. '
                   . 'King beds, hot water, free Wi-Fi and secure parking. Book in a '
                   . 'minute on WhatsApp.',
    'path'        => '/rooms',
    'image'       => image_url('photos/room-executive', 1200),
    'preload'     => 'photos/room-executive',
    'breadcrumbs' => ['Home' => '/', 'Rooms & Rates' => '/rooms'],
    'schema'      => schema_rooms(),
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <section class="phero">
    <div class="phero__media">
      <?= picture('photos/room-executive', '', ['sizes' => '100vw', 'loading' => 'eager']) ?>
    </div>
    <div class="wrap">
      <div class="phero__inner">
        <ol class="crumbs">
          <li><a href="/">Home</a></li>
          <li>Rooms &amp; Rates</li>
        </ol>
        <h1 class="phero__title">Rooms &amp; Rates</h1>
        <p class="phero__sub">
          Every room is en-suite, with a king bed, hot water and free Wi-Fi.
          Rates are per room, per night.
        </p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap">
      <div class="grid" style="gap:clamp(1.5rem,4vw,2.5rem)">
        <?php foreach ($ROOMS as $room): ?>
          <article class="room reveal" id="<?= e($room['slug']) ?>">
            <div class="room__media">
              <?= picture($room['image'], $room['alt'], ['sizes' => '(min-width:720px) 50vw, 100vw']) ?>
            </div>
            <div class="room__body">
              <div class="room__head">
                <div>
                  <h2 class="room__title"><?= e($room['name']) ?></h2>
                  <p class="room__tag"><?= e($room['tagline']) ?></p>
                </div>
                <p class="room__price">
                  <strong>$<?= (int) $room['price'] ?></strong>
                  <span>per night</span>
                </p>
              </div>

              <p><?= e($room['blurb']) ?></p>

              <div class="meta-row">
                <span class="chip"><?= e($room['bed']) ?></span>
                <span class="chip">Sleeps <?= (int) $room['sleeps'] ?></span>
                <span class="chip"><?= e($room['size']) ?></span>
              </div>

              <ul class="ticks">
                <?php foreach ($room['features'] as $f): ?>
                  <li><?= icon('check', 'icon icon--sm') ?> <?= e($f) ?></li>
                <?php endforeach; ?>
              </ul>

              <div style="margin-top:.5rem">
                <a class="btn btn--maroon"
                   href="<?= e(whatsapp_link('Hello Cosy Inn Kiwenda, I would like to book the ' . $room['name'] . '. Are these dates available?')) ?>"
                   target="_blank" rel="noopener">
                  <?= icon('whatsapp', 'icon icon--sm') ?> Book this room
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section section--cream">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">Good to know</span>
        <h2 class="shead__title">What is <em>included</em></h2>
      </div>
      <div class="grid grid--4">
        <?php
        $included = [
          ['clock', 'Check in / out', 'From ' . CHECK_IN . ', out by ' . CHECK_OUT . '.'],
          ['wifi',  'Free Wi-Fi',     'Throughout the property, no charge.'],
          ['car',   'Secure parking', 'Free, off-street, inside the gate.'],
          ['dish',  'Breakfast',      'Available daily from ' . ugx(10000) . '.'],
        ];
        foreach ($included as $i => $inc): ?>
          <div class="card reveal" data-reveal-delay="<?= $i * 80 ?>">
            <div class="card__body" style="align-items:flex-start">
              <span class="feature__icon"><?= icon($inc[0]) ?></span>
              <h3 class="card__title" style="font-size:1.1rem"><?= e($inc[1]) ?></h3>
              <p class="card__text"><?= e($inc[2]) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="cta">
    <div class="cta__media">
      <?= picture('photos/courtyard', '', ['sizes' => '100vw']) ?>
    </div>
    <div class="wrap">
      <div class="cta__inner">
        <h2 class="cta__title">Ready when you are</h2>
        <p class="cta__text">
          Tell us your dates on WhatsApp and we will confirm a room the same day.
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

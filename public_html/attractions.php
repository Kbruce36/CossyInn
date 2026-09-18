<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'titleFull'   => 'Things to Do Near Kiwenda & Gayaza | The Cosy Inn',
    'description' => 'Namugongo Shrine, Kampala, Ssezibwa Falls, Lake Victoria and Mabira '
                   . 'Forest are all an easy drive from The Cosy Inn Kiwenda in Wakiso '
                   . 'District.',
    'path'        => '/attractions',
    'image'       => image_url('stock/attraction-ssezibwa-falls', 1200),
    'preload'     => 'stock/attraction-namugongo',
    'breadcrumbs' => ['Home' => '/', 'Attractions' => '/attractions'],
    'schema'      => [[
        '@type'           => 'ItemList',
        'name'            => 'Attractions near The Cosy Inn Kiwenda',
        'itemListElement' => array_map(
            static function (array $a, int $i): array {
                return [
                    '@type'    => 'ListItem',
                    'position' => $i + 1,
                    'item'     => [
                        '@type'       => 'TouristAttraction',
                        'name'        => $a['name'],
                        'description' => $a['blurb'],
                        'image'       => image_url($a['img'], 1200),
                    ],
                ];
            },
            $ATTRACTIONS,
            array_keys($ATTRACTIONS)
        ),
    ]],
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <section class="phero">
    <div class="phero__media">
      <?= picture('stock/attraction-namugongo', '', ['sizes' => '100vw', 'loading' => 'eager']) ?>
    </div>
    <div class="wrap">
      <div class="phero__inner">
        <ol class="crumbs">
          <li><a href="/">Home</a></li>
          <li>Attractions</li>
        </ol>
        <h1 class="phero__title">Attractions Near Kiwenda</h1>
        <p class="phero__sub">
          Sleep somewhere quiet and still be within reach of the best of
          central Uganda. Here is what our guests go and see.
        </p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap">
      <div class="grid grid--3">
        <?php foreach ($ATTRACTIONS as $i => $a): ?>
          <article class="card reveal" data-reveal-delay="<?= ($i % 3) * 90 ?>">
            <div class="card__media">
              <?= picture($a['img'], $a['alt'],
                    ['sizes' => '(min-width:1000px) 380px, (min-width:720px) 50vw, 100vw']) ?>
              <span class="card__badge"><?= e($a['time']) ?></span>
            </div>
            <div class="card__body">
              <h2 class="card__title"><?= e($a['name']) ?></h2>
              <p class="card__text"><?= e($a['blurb']) ?></p>
              <div class="card__foot">
                <span class="chip"><?= icon('car', 'icon icon--sm') ?> <?= e($a['dist']) ?></span>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <p class="placeholder-note" style="margin-top:2rem">
        Distances and drive times are estimates from Kiwenda and will vary with
        traffic on the Kampala approach.
      </p>
    </div>
  </section>

  <section class="section section--cream">
    <div class="wrap">
      <div class="split reveal">
        <div class="split__media framed">
          <?= picture('photos/aerial-property',
                'Aerial view of The Cosy Inn Kiwenda showing the courtyard and surrounding greenery',
                ['sizes' => '(min-width:720px) 50vw, 100vw']) ?>
        </div>
        <div class="split__body">
          <span class="shead__eyebrow">Why stay here</span>
          <h2 class="shead__title">A quiet base, <em>well placed</em></h2>
          <p>
            Kiwenda sits north of Kampala on the Gayaza road, which means you
            avoid the noise and the nightly traffic of the city while staying
            close enough to reach it comfortably in a morning.
          </p>
          <p>
            It also puts you on the right side of town for Namugongo and the
            eastern route towards Jinja and Mabira, without crossing the centre.
          </p>
          <p style="margin-top:1.5rem">
            <a class="btn btn--maroon" href="/directions">How to find us</a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="cta">
    <div class="cta__media">
      <?= picture('stock/attraction-ssezibwa-falls', '', ['sizes' => '100vw']) ?>
    </div>
    <div class="wrap">
      <div class="cta__inner">
        <h2 class="cta__title">Make a weekend of it</h2>
        <p class="cta__text">
          Book a room, and we will happily point you towards the best route and
          the right time of day to go.
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

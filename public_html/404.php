<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

http_response_code(404);

$page = [
    'title'       => 'Page Not Found',
    'description' => 'That page does not exist. Find rooms, the menu and directions '
                   . 'for The Cosy Inn Kiwenda here.',
    'path'        => '/404',
    // Not indexable: a soft 404 sitting in the index is worse than no page.
    'robots'      => 'noindex, follow',
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <section class="section" style="text-align:center">
    <div class="wrap" style="max-width:44rem">
      <p class="shead__eyebrow" style="justify-content:center">Error 404</p>
      <h1 class="shead__title" style="font-size:clamp(2.2rem,1.5rem+3vw,3.4rem)">
        We cannot find that <em>page</em>
      </h1>
      <p class="shead__sub" style="margin-inline:auto">
        The link may be old, or the address mistyped. Everything on the site is
        one click away below.
      </p>

      <div class="cta__actions" style="margin-top:2.5rem">
        <a class="btn btn--maroon btn--lg" href="/">Back to the homepage</a>
        <a class="btn btn--ghost btn--lg" href="/rooms">See rooms &amp; rates</a>
      </div>

      <div class="grid grid--3" style="margin-top:3.5rem;text-align:left">
        <?php
        $suggest = [
          ['/rooms',      'Rooms &amp; Rates', 'En-suite rooms from $' . PRICE_FROM . ' a night.'],
          ['/dining',     'Restaurant &amp; Bar', 'The full menu, with real prices.'],
          ['/directions', 'Directions',        'How to reach Kiwenda from Kampala.'],
        ];
        foreach ($suggest as $s): ?>
          <a class="card" href="<?= e($s[0]) ?>">
            <div class="card__body">
              <h2 class="card__title" style="font-size:1.1rem"><?= $s[1] ?></h2>
              <p class="card__text"><?= e($s[2]) ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

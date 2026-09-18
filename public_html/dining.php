<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'titleFull'   => 'Restaurant & Bar Menu | The Cosy Inn Kiwenda, Wakiso',
    'description' => 'Local and continental food in Kiwenda: chips and chicken, katogo, '
                   . 'grilled fish and breakfast from ' . ugx(10000) . '. The Cosy Bar '
                   . 'serves drinks daily.',
    'path'        => '/dining',
    'image'       => image_url('photos/cosy-bar', 1200),
    'preload'     => 'photos/cosy-bar',
    'breadcrumbs' => ['Home' => '/', 'Dining' => '/dining'],
    'schema'      => [schema_restaurant(true)],
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <section class="phero">
    <div class="phero__media">
      <?= picture('photos/cosy-bar', '', ['sizes' => '100vw', 'loading' => 'eager']) ?>
    </div>
    <div class="wrap">
      <div class="phero__inner">
        <ol class="crumbs">
          <li><a href="/">Home</a></li>
          <li>Dining</li>
        </ol>
        <h1 class="phero__title">Restaurant &amp; Bar</h1>
        <p class="phero__sub">
          Fresh, delicious and always cosy. Our kitchen and bar are open to
          everyone, not only to guests staying overnight.
        </p>
      </div>
    </div>
  </section>

  <!-- ================================================= the kitchen ==== -->
  <section class="section">
    <div class="wrap">
      <div class="split split--wide reveal">
        <div class="split__media framed">
          <?= picture('stock/food-fish',
                'Whole fried fish served with fried plantain and fresh salad',
                ['sizes' => '(min-width:720px) 50vw, 100vw']) ?>
        </div>
        <div class="split__body">
          <span class="shead__eyebrow">Our kitchen</span>
          <h2 class="shead__title">Good food, <em>good mood</em></h2>
          <p>
            Everything is cooked to order. The menu runs from quick plates of
            chips and chicken through to katogo, posho with fried goat, whole
            deep fried fish and full roast chicken for a table to share.
          </p>
          <p>
            If you want something that is not on the list, ask. Our team takes
            special orders, and a message ahead of time means it is ready when
            you arrive.
          </p>
          <ul class="ticks">
            <li><?= icon('check', 'icon icon--sm') ?> Local and continental dishes</li>
            <li><?= icon('check', 'icon icon--sm') ?> Breakfast served every morning</li>
            <li><?= icon('check', 'icon icon--sm') ?> Special and large orders welcome</li>
            <li><?= icon('check', 'icon icon--sm') ?> Open to non-residents</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ======================================================= menu ===== -->
  <section class="section section--cream">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">Fresh, delicious &amp; always cosy</span>
        <h2 class="shead__title">The <em>Menu</em></h2>
        <p class="shead__sub">
          Prices in Uganda Shillings. Ask your server about the dish of the day.
        </p>
      </div>

      <div class="grid grid--2" style="align-items:start">
        <div class="reveal">
          <?php foreach (array_slice($MENU, 0, 2) as $section): ?>
            <div class="menu-section">
              <div class="menu-section__head">
                <h3 class="menu-section__title"><?= e($section['name']) ?></h3>
              </div>
              <?php if ($section['note']): ?>
                <p class="menu-section__note"><?= e($section['note']) ?></p>
              <?php endif; ?>
              <ul class="menu-list">
                <?php foreach ($section['items'] as $item): ?>
                  <li class="menu-item">
                    <span class="menu-item__name"><?= e($item['name']) ?></span>
                    <span class="menu-item__dots" aria-hidden="true"></span>
                    <?php if ($item['price'] !== null): ?>
                      <span class="menu-item__price"><?= e(ugx($item['price'])) ?></span>
                    <?php else: ?>
                      <span class="menu-item__price menu-item__price--ask">Ask at the bar</span>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="reveal" data-reveal-delay="100">
          <?php foreach (array_slice($MENU, 2) as $section): ?>
            <div class="menu-section">
              <div class="menu-section__head">
                <h3 class="menu-section__title"><?= e($section['name']) ?></h3>
              </div>
              <?php if ($section['note']): ?>
                <p class="menu-section__note"><?= e($section['note']) ?></p>
              <?php endif; ?>
              <ul class="menu-list">
                <?php foreach ($section['items'] as $item): ?>
                  <li class="menu-item">
                    <span class="menu-item__name"><?= e($item['name']) ?></span>
                    <span class="menu-item__dots" aria-hidden="true"></span>
                    <?php if ($item['price'] !== null): ?>
                      <span class="menu-item__price"><?= e(ugx($item['price'])) ?></span>
                    <?php else: ?>
                      <span class="menu-item__price menu-item__price--ask">Ask at the bar</span>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>

          <div class="card" style="margin-top:2rem">
            <div class="card__body">
              <h3 class="card__title" style="font-size:1.15rem">Special orders welcome</h3>
              <p class="card__text">
                Planning a birthday, a meeting lunch or a family gathering?
                Message us ahead and the kitchen will prepare for your group.
              </p>
              <a class="btn btn--maroon"
                 href="<?= e(whatsapp_link('Hello Cosy Inn Kiwenda, I would like to place a special food order.')) ?>"
                 target="_blank" rel="noopener">
                <?= icon('whatsapp', 'icon icon--sm') ?> Place an order
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======================================================== bar ===== -->
  <section class="section">
    <div class="wrap">
      <div class="split split--wide split--rev reveal">
        <div class="split__media framed">
          <?= picture('photos/cosy-bar',
                'Guests at the counter of The Cosy Bar with the bartender serving drinks',
                ['sizes' => '(min-width:720px) 50vw, 100vw']) ?>
        </div>
        <div class="split__body">
          <span class="shead__eyebrow">Relax, sip, socialise, repeat</span>
          <h2 class="shead__title">The <em>Cosy Bar</em></h2>
          <p>
            Good drinks, great company. A proper counter with cold beer, spirits,
            wine, soft drinks and cocktails mixed to order, plus fresh fruit juice
            in passion, mango, melon, pineapple and orange.
          </p>
          <p>
            It is the easiest place on the property to end a day, whether you are
            staying the night or just passing through Kiwenda.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ================================================== more food ===== -->
  <section class="section section--cream">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">From the kitchen</span>
        <h2 class="shead__title">A taste of <em>what to expect</em></h2>
      </div>
      <div class="gallery reveal">
        <?php
        $foodShots = [
          ['stock/food-chicken',      'Roast chicken served with greens and rice'],
          ['stock/food-fish-whole',   'Whole fried fish garnished with tomato, onion and lemon'],
          ['photos/dining-table',     'Round dining table laid for six in the restaurant'],
          ['stock/drink-coffee',      'A cup of strong African coffee'],
          ['stock/drink-juice',       'Freshly pressed fruit juices with pineapple and citrus'],
          ['photos/breakfast-service','Staff serving breakfast to guests in the dining room'],
          ['stock/food-chicken-greens','Grilled chicken with kale and rice'],
          ['photos/lounge',           'Lounge with leather sofas beside the restaurant'],
        ];
        foreach ($foodShots as $f): ?>
          <figure class="gitem">
            <?= picture($f[0], $f[1], ['sizes' => '(min-width:1000px) 25vw, 50vw']) ?>
          </figure>
        <?php endforeach; ?>
      </div>
      <p class="placeholder-note">
        Some dishes are shown with stock photography while we photograph our own plates.
      </p>
    </div>
  </section>

  <section class="cta">
    <div class="cta__media">
      <?= picture('photos/dining-table', '', ['sizes' => '100vw']) ?>
    </div>
    <div class="wrap">
      <div class="cta__inner">
        <h2 class="cta__title">Hungry? We are open</h2>
        <p class="cta__text">
          Reserve a table, order ahead, or just walk in. Message us and we will
          have it ready.
        </p>
        <div class="cta__actions">
          <a class="btn btn--gold btn--lg"
             href="<?= e(whatsapp_link('Hello Cosy Inn Kiwenda, I would like to reserve a table.')) ?>"
             target="_blank" rel="noopener">
            <?= icon('whatsapp', 'icon icon--sm') ?> Reserve a table
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

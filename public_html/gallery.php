<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'titleFull'   => 'Photo Gallery: Rooms & Grounds | The Cosy Inn Kiwenda',
    'description' => 'Photographs of The Cosy Inn Kiwenda: the entrance, garden courtyard, '
                   . 'en-suite rooms, the restaurant, The Cosy Bar and the team who run it.',
    'path'        => '/gallery',
    'image'       => image_url('photos/courtyard', 1200),
    'preload'     => 'photos/courtyard',
    'breadcrumbs' => ['Home' => '/', 'Gallery' => '/gallery'],
    'schema'      => [[
        '@type'           => 'ImageGallery',
        'name'            => 'The Cosy Inn Kiwenda photo gallery',
        'associatedMedia' => array_map(static fn(array $g): array => [
            '@type'       => 'ImageObject',
            'contentUrl'  => image_url($g['img'], 1200),
            'description' => $g['alt'],
        ], $GALLERY),
    ]],
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <section class="phero">
    <div class="phero__media">
      <?= picture('photos/courtyard', '', ['sizes' => '100vw', 'loading' => 'eager']) ?>
    </div>
    <div class="wrap">
      <div class="phero__inner">
        <ol class="crumbs">
          <li><a href="/">Home</a></li>
          <li>Gallery</li>
        </ol>
        <h1 class="phero__title">Gallery</h1>
        <p class="phero__sub">
          A look around the property, the rooms and the restaurant.
          Click any photo to see it full size.
        </p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap">

      <div class="gfilters reveal">
        <?php foreach ($GALLERY_CATS as $key => $label): ?>
          <button class="gfilter<?= $key === 'all' ? ' is-active' : '' ?>"
                  type="button" data-filter="<?= e($key) ?>"><?= e($label) ?></button>
        <?php endforeach; ?>
      </div>

      <div class="gallery reveal">
        <?php foreach ($GALLERY as $g): ?>
          <figure class="gitem" data-cat="<?= e($g['cat']) ?>"
                  data-full="<?= e('/assets/img/' . $g['img'] . '-1200.jpg') ?>">
            <?= picture($g['img'], $g['alt'], ['sizes' => '(min-width:1000px) 25vw, 50vw']) ?>
          </figure>
        <?php endforeach; ?>
      </div>

      <p class="placeholder-note" style="margin-top:2rem">
        All photographs on this page are of the property itself.
      </p>
    </div>
  </section>

  <section class="cta">
    <div class="cta__media">
      <?= picture('photos/entrance', '', ['sizes' => '100vw']) ?>
    </div>
    <div class="wrap">
      <div class="cta__inner">
        <h2 class="cta__title">See it for yourself</h2>
        <p class="cta__text">
          Photographs only go so far. Come and stay, and judge the place properly.
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

<!-- lightbox -->
<div class="lightbox" id="lightbox" hidden>
  <button class="lightbox__close" type="button" aria-label="Close">
    <?= icon('close', 'icon') ?>
  </button>
  <button class="lightbox__btn lightbox__btn--prev" type="button" aria-label="Previous photo">
    <?= icon('chevron-l', 'icon') ?>
  </button>
  <div>
    <img class="lightbox__img" src="" alt="">
    <p class="lightbox__cap"></p>
  </div>
  <button class="lightbox__btn lightbox__btn--next" type="button" aria-label="Next photo">
    <?= icon('chevron-r', 'icon') ?>
  </button>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>

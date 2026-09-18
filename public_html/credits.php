<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'titleFull'   => 'Photo Credits & Licences | The Cosy Inn Kiwenda',
    'description' => 'Attribution for the Creative Commons and stock photographs used to '
                   . 'illustrate attractions and menu dishes on The Cosy Inn Kiwenda '
                   . 'website.',
    'path'        => '/credits',
    'breadcrumbs' => ['Home' => '/', 'Photo credits' => '/credits'],
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <section class="section">
    <div class="wrap" style="max-width:56rem">
      <ol class="crumbs" style="justify-content:flex-start;color:var(--muted);margin-bottom:1.5rem">
        <li><a href="/">Home</a></li>
        <li>Photo credits</li>
      </ol>

      <h1 class="shead__title">Photo Credits</h1>
      <p class="shead__sub" style="margin-bottom:2.5rem">
        Photographs of the inn itself, its rooms, restaurant, bar, gardens and
        team are our own. The images below illustrate nearby attractions and
        some menu dishes, and are used under the licences listed.
      </p>

      <div class="card">
        <div class="card__body">
          <?php foreach ($PHOTO_CREDITS as $c): ?>
            <div style="padding:.9rem 0;border-bottom:1px solid var(--line)">
              <p style="font-weight:600;color:var(--ink)"><?= e($c['title']) ?></p>
              <p style="font-size:.88rem;color:var(--muted)">
                <?= e($c['author']) ?> &middot; <?= e($c['licence']) ?>
                &middot; <a href="<?= e($c['source']) ?>" target="_blank" rel="noopener nofollow"
                            style="color:var(--maroon);border-bottom:1px solid var(--line)">source</a>
              </p>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <p class="placeholder-note" style="text-align:left;margin-top:1.5rem">
        Creative Commons images require attribution, which is why this page
        exists. If you replace an attraction or food photo with your own,
        delete its row from <code>includes/content.php</code>.
      </p>
    </div>
  </section>

</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
/** Top utility bar, logo, primary navigation and the mobile drawer. */
declare(strict_types=1);
?>
<div class="topbar">
  <div class="wrap topbar__inner">
    <div class="topbar__contact">
      <a href="tel:<?= e(PHONE_PRIMARY) ?>" class="topbar__link">
        <?= icon('phone', 'icon icon--sm') ?><span><?= e(PHONE_PRIMARY_DISPLAY) ?></span>
      </a>
      <a href="<?= e(whatsapp_link()) ?>" class="topbar__link topbar__link--wa"
         target="_blank" rel="noopener">
        <?= icon('whatsapp', 'icon icon--sm') ?><span>Chat on WhatsApp</span>
      </a>
    </div>
    <div class="topbar__social">
      <span class="topbar__follow">Follow us</span>
      <?php foreach ($SOCIAL as $key => $s):
        $isPlaceholder = ($s['url'] === '#'); ?>
        <a href="<?= e($s['url']) ?>"
           class="social social--<?= e($key) ?><?= $isPlaceholder ? ' is-placeholder' : '' ?>"
           <?= $isPlaceholder
                ? 'aria-disabled="true" title="' . e($s['label']) . ' link coming soon"'
                : 'target="_blank" rel="noopener me"' ?>
           aria-label="<?= e($s['label']) ?>"><?= icon($key, 'icon icon--sm') ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<header class="header" id="header">
  <div class="wrap header__inner">
    <a class="brand" href="/" aria-label="<?= e(SITE_NAME) ?>, home">
      <img src="/assets/img/brand/logo.svg" alt="" width="72" height="58" class="brand__mark">
      <span class="brand__text">
        <span class="brand__the">The</span>
        <span class="brand__name">Cosy <em>Inn</em></span>
        <span class="brand__place">Kiwenda</span>
      </span>
    </a>

    <nav class="nav" aria-label="Primary">
      <ul class="nav__list">
        <?php foreach ($NAV as $path => $label): ?>
          <li>
            <a href="<?= e($path) ?>" class="nav__link<?= is_active($path) ? ' is-active' : '' ?>"
               <?= is_active($path) ? 'aria-current="page"' : '' ?>><?= e($label) ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <a class="btn btn--gold header__cta" href="<?= e(whatsapp_link()) ?>"
       target="_blank" rel="noopener">
      <?= icon('whatsapp', 'icon icon--sm') ?> Book Now
    </a>

    <button class="burger" type="button" aria-expanded="false" aria-controls="drawer"
            aria-label="Open menu">
      <?= icon('menu', 'icon') ?>
    </button>
  </div>
</header>

<div class="drawer" id="drawer" hidden>
  <div class="drawer__panel" role="dialog" aria-modal="true" aria-label="Menu">
    <button class="drawer__close" type="button" aria-label="Close menu">
      <?= icon('close', 'icon') ?>
    </button>
    <nav aria-label="Mobile">
      <ul class="drawer__list">
        <?php foreach ($NAV as $path => $label): ?>
          <li><a href="<?= e($path) ?>" class="drawer__link<?= is_active($path) ? ' is-active' : '' ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <a class="btn btn--gold btn--block" href="<?= e(whatsapp_link()) ?>"
       target="_blank" rel="noopener">
      <?= icon('whatsapp', 'icon icon--sm') ?> Book on WhatsApp
    </a>
    <div class="drawer__meta">
      <a href="tel:<?= e(PHONE_PRIMARY) ?>"><?= icon('phone', 'icon icon--sm') ?> <?= e(PHONE_PRIMARY_DISPLAY) ?></a>
      <p><?= icon('pin', 'icon icon--sm') ?> <?= e(ADDR_FULL) ?></p>
    </div>
  </div>
</div>

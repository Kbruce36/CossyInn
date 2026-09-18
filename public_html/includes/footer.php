<?php
/** Footer, floating WhatsApp button and the single site script. */
declare(strict_types=1);
?>
<footer class="footer">
  <div class="wrap footer__grid">

    <div class="footer__brand">
      <div class="footer__logo">
        <img src="/assets/img/brand/logo-light.svg" alt="" width="72" height="58" loading="lazy">
        <span class="brand__text brand__text--light">
          <span class="brand__the">The</span>
          <span class="brand__name">Cosy <em>Inn</em></span>
          <span class="brand__place">Kiwenda</span>
        </span>
      </div>
      <p class="footer__tagline script">&ldquo;<?= e(SITE_TAGLINE) ?>&rdquo;</p>
      <p class="footer__blurb">
        A quiet, family-run inn in Kiwenda, Wakiso District. Clean en-suite rooms,
        honest food and secure parking, an hour north of Kampala.
      </p>
    </div>

    <nav class="footer__col" aria-label="Footer">
      <h2 class="footer__head">Explore</h2>
      <ul class="footer__list">
        <?php foreach ($NAV as $path => $label): ?>
          <li><a href="<?= e($path) ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="footer__col">
      <h2 class="footer__head">Contact</h2>
      <ul class="footer__list footer__list--contact">
        <li><a href="tel:<?= e(PHONE_PRIMARY) ?>"><?= icon('phone', 'icon icon--sm') ?><?= e(PHONE_PRIMARY_DISPLAY) ?></a></li>
        <li><a href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener"><?= icon('whatsapp', 'icon icon--sm') ?>Chat on WhatsApp</a></li>
        <li><a href="mailto:<?= e(EMAIL_PRIMARY) ?>"><?= icon('mail', 'icon icon--sm') ?><?= e(EMAIL_PRIMARY) ?></a></li>
        <li><span><?= icon('pin', 'icon icon--sm') ?><?= e(ADDR_FULL) ?></span></li>
        <li><span><?= icon('clock', 'icon icon--sm') ?>Reception open daily</span></li>
      </ul>
    </div>

    <div class="footer__col">
      <h2 class="footer__head">Follow us</h2>
      <div class="footer__social">
        <?php foreach ($SOCIAL as $key => $s):
          $isPlaceholder = ($s['url'] === '#'); ?>
          <a href="<?= e($s['url']) ?>"
             class="social social--lg<?= $isPlaceholder ? ' is-placeholder' : '' ?>"
             <?= $isPlaceholder
                  ? 'aria-disabled="true" title="' . e($s['label']) . ' link coming soon"'
                  : 'target="_blank" rel="noopener me"' ?>
             aria-label="<?= e($s['label']) ?>"><?= icon($key) ?></a>
        <?php endforeach; ?>
      </div>
      <p class="footer__note">
        Ready when you are. Message us and we will confirm a room the same day.
      </p>
      <a class="btn btn--gold btn--block" href="<?= e(whatsapp_link()) ?>"
         target="_blank" rel="noopener">
        <?= icon('whatsapp', 'icon icon--sm') ?> Book Now
      </a>
    </div>

  </div>

  <div class="footer__bar">
    <div class="wrap footer__bar-inner">
      <p>&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</p>
      <p class="footer__credits">
        <a href="/credits">Photo credits</a>
      </p>
    </div>
  </div>
</footer>

<a class="wa-float" href="<?= e(whatsapp_link()) ?>" target="_blank" rel="noopener"
   aria-label="Chat with us on WhatsApp">
  <?= icon('whatsapp', 'icon') ?>
  <span class="wa-float__label">Book on WhatsApp</span>
</a>

<script src="/assets/js/site.js" defer></script>
</body>
</html>

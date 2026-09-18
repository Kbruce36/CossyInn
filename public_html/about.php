<?php
declare(strict_types=1);
require __DIR__ . '/includes/bootstrap.php';

$page = [
    'titleFull'   => 'About Us | The Cosy Inn Kiwenda, Wakiso District',
    'description' => 'The Cosy Inn Kiwenda is a small family-run inn in Wakiso District, '
                   . 'Uganda. Clean en-suite rooms, honest food and a team that knows you '
                   . 'by name.',
    'path'        => '/about',
    'image'       => image_url('photos/team', 1200),
    'preload'     => 'photos/aerial-property',
    'breadcrumbs' => ['Home' => '/', 'About' => '/about'],
    'schema'      => [schema_faq($FAQS)],
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>
<main id="main">

  <section class="phero">
    <div class="phero__media">
      <?= picture('photos/aerial-property', '', ['sizes' => '100vw', 'loading' => 'eager']) ?>
    </div>
    <div class="wrap">
      <div class="phero__inner">
        <ol class="crumbs">
          <li><a href="/">Home</a></li>
          <li>About</li>
        </ol>
        <h1 class="phero__title">About The Cosy Inn</h1>
        <p class="phero__sub">
          A small inn in Kiwenda, run by people who live here, for guests who
          would rather sleep somewhere quiet.
        </p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap">
      <div class="split split--wide reveal">
        <div class="split__media framed">
          <?= picture('photos/courtyard',
                'Planted garden courtyard with paved walkways between the guest rooms',
                ['sizes' => '(min-width:720px) 50vw, 100vw']) ?>
        </div>
        <div class="split__body">
          <span class="shead__eyebrow">Our story</span>
          <h2 class="shead__title">Built around a <em>garden</em></h2>
          <p>
            The Cosy Inn was built as a place to rest rather than a place to
            pass through. The rooms open onto a planted courtyard instead of a
            corridor, the walls are thick enough to keep the road out, and the
            whole compound sits behind a gate with its own parking.
          </p>
          <p>
            We are an hour north of Kampala on the Gayaza road. Close enough
            that guests drive in for a meeting or a function in town, far enough
            that they actually sleep when they get back.
          </p>
          <p class="script" style="font-size:1.6rem;color:var(--maroon);margin-top:1.5rem">
            &ldquo;<?= e(SITE_TAGLINE) ?>&rdquo;
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="section section--cream">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">What we care about</span>
        <h2 class="shead__title">How we <em>run the place</em></h2>
      </div>
      <div class="grid grid--3">
        <?php
        $values = [
          ['check', 'Clean, every time',
           'Rooms are turned over daily and checked before anyone is given a key. '
           . 'If something is not right, tell us and we will fix it while you wait.'],
          ['users', 'Known by name',
           'The same small team works here year round. By your second visit they '
           . 'will remember how you take your tea.'],
          ['tag',  'Honest pricing',
           'The rate you are quoted is the rate you pay. No service charge that '
           . 'appears at checkout, no surprises.'],
        ];
        foreach ($values as $i => $v): ?>
          <div class="card reveal" data-reveal-delay="<?= $i * 90 ?>">
            <div class="card__body" style="align-items:flex-start">
              <span class="feature__icon"><?= icon($v[0]) ?></span>
              <h3 class="card__title" style="font-size:1.15rem"><?= e($v[1]) ?></h3>
              <p class="card__text"><?= e($v[2]) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap">
      <div class="split split--wide split--rev reveal">
        <div class="split__media framed">
          <?= picture('photos/team',
                'The Cosy Inn Kiwenda team in branded uniforms at reception',
                ['sizes' => '(min-width:720px) 50vw, 100vw']) ?>
        </div>
        <div class="split__body">
          <span class="shead__eyebrow">Our team</span>
          <h2 class="shead__title">The people who <em>make it work</em></h2>
          <p>
            Reception, kitchen, bar and housekeeping. A handful of people who
            between them cover every shift, every day of the year.
          </p>
          <p>
            They are the reason guests come back, and the reason we are
            comfortable telling you to just turn up and ask for whatever you need.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ======================================================== faq ===== -->
  <section class="section section--cream">
    <div class="wrap">
      <div class="shead shead--center reveal">
        <span class="shead__eyebrow">Questions</span>
        <h2 class="shead__title">Frequently <em>asked</em></h2>
      </div>

      <div class="faq reveal">
        <?php foreach ($FAQS as $i => $f): ?>
          <div class="faq__item">
            <h3>
              <button class="faq__q" type="button" aria-expanded="false"
                      id="faq-q-<?= $i ?>" aria-controls="faq-a-<?= $i ?>">
                <span><?= e($f['q']) ?></span>
                <span class="faq__sign" aria-hidden="true"></span>
              </button>
            </h3>
            <div class="faq__a" id="faq-a-<?= $i ?>" role="region" aria-labelledby="faq-q-<?= $i ?>">
              <div><p><?= e($f['a']) ?></p></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="cta">
    <div class="cta__media">
      <?= picture('photos/entrance', '', ['sizes' => '100vw']) ?>
    </div>
    <div class="wrap">
      <div class="cta__inner">
        <h2 class="cta__title">Come and stay</h2>
        <p class="cta__text">
          We would rather show you than tell you. Message us for a room.
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

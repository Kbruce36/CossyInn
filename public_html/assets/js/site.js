/* The Cosy Inn Kiwenda
   One small script, loaded with defer. No framework, no dependencies.
   Everything here is progressive: the site works with JavaScript disabled,
   which also means search engine crawlers see the full content. */

(function () {
  'use strict';

  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------------------------------------------------- mobile drawer -- */
  var drawer = document.getElementById('drawer');
  var burger = document.querySelector('.burger');

  if (drawer && burger) {
    var closeBtn = drawer.querySelector('.drawer__close');
    var lastFocus = null;

    function openDrawer() {
      lastFocus = document.activeElement;
      drawer.hidden = false;
      requestAnimationFrame(function () { drawer.classList.add('is-open'); });
      burger.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
      if (closeBtn) closeBtn.focus();
    }

    function closeDrawer() {
      drawer.classList.remove('is-open');
      burger.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
      window.setTimeout(function () { drawer.hidden = true; }, 320);
      if (lastFocus) lastFocus.focus();
    }

    burger.addEventListener('click', openDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
    drawer.addEventListener('click', function (e) {
      if (e.target === drawer) closeDrawer();
    });
    drawer.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', closeDrawer);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && !drawer.hidden) closeDrawer();
    });
  }

  /* ------------------------------------------------- sticky header cue -- */
  var header = document.getElementById('header');
  if (header) {
    var onScroll = function () {
      header.classList.toggle('is-stuck', window.scrollY > 8);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  /* -------------------------------------------------------- reveal on -- */
  var revealables = document.querySelectorAll('.reveal');
  if (revealables.length) {
    if (reduced || !('IntersectionObserver' in window)) {
      revealables.forEach(function (el) { el.classList.add('is-in'); });
    } else {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          var el = entry.target;
          var delay = parseInt(el.dataset.revealDelay || '0', 10);
          window.setTimeout(function () { el.classList.add('is-in'); }, delay);
          io.unobserve(el);
        });
      }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
      revealables.forEach(function (el) { io.observe(el); });
    }
  }

  /* ----------------------------------------------------- gallery filter -- */
  var filters = document.querySelectorAll('.gfilter');
  var items = document.querySelectorAll('.gitem');

  if (filters.length && items.length) {
    filters.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var cat = btn.dataset.filter;
        filters.forEach(function (b) { b.classList.toggle('is-active', b === btn); });
        items.forEach(function (item) {
          item.hidden = !(cat === 'all' || item.dataset.cat === cat);
        });
      });
    });
  }

  /* ---------------------------------------------------------- lightbox -- */
  var lb = document.getElementById('lightbox');

  if (lb && items.length) {
    var lbImg   = lb.querySelector('.lightbox__img');
    var lbCap   = lb.querySelector('.lightbox__cap');
    var current = 0;

    function visibleItems() {
      return Array.prototype.filter.call(items, function (i) { return !i.hidden; });
    }

    function show(index) {
      var list = visibleItems();
      if (!list.length) return;
      current = (index + list.length) % list.length;
      var item = list[current];
      var img = item.querySelector('img');
      lbImg.src = item.dataset.full || img.currentSrc || img.src;
      lbImg.alt = img.alt;
      lbCap.textContent = img.alt;
    }

    function openLb(index) {
      show(index);
      lb.hidden = false;
      requestAnimationFrame(function () { lb.classList.add('is-open'); });
      document.body.style.overflow = 'hidden';
      lb.querySelector('.lightbox__close').focus();
    }

    function closeLb() {
      lb.classList.remove('is-open');
      document.body.style.overflow = '';
      window.setTimeout(function () { lb.hidden = true; lbImg.src = ''; }, 250);
    }

    items.forEach(function (item) {
      item.addEventListener('click', function () {
        openLb(visibleItems().indexOf(item));
      });
      item.setAttribute('tabindex', '0');
      item.setAttribute('role', 'button');
      item.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          openLb(visibleItems().indexOf(item));
        }
      });
    });

    lb.querySelector('.lightbox__close').addEventListener('click', closeLb);
    lb.querySelector('.lightbox__btn--prev').addEventListener('click', function () { show(current - 1); });
    lb.querySelector('.lightbox__btn--next').addEventListener('click', function () { show(current + 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) closeLb(); });

    document.addEventListener('keydown', function (e) {
      if (lb.hidden) return;
      if (e.key === 'Escape') closeLb();
      if (e.key === 'ArrowLeft') show(current - 1);
      if (e.key === 'ArrowRight') show(current + 1);
    });
  }

  /* ------------------------------------------------------ testimonials -- */
  var quotes = document.querySelectorAll('.quote');
  var dots   = document.querySelectorAll('.qdot');

  if (quotes.length > 1) {
    var qi = 0;
    var timer = null;

    function goTo(n) {
      qi = (n + quotes.length) % quotes.length;
      quotes.forEach(function (q, i) { q.classList.toggle('is-active', i === qi); });
      dots.forEach(function (d, i) { d.classList.toggle('is-active', i === qi); });
    }

    function restart() {
      if (reduced) return;
      window.clearInterval(timer);
      timer = window.setInterval(function () { goTo(qi + 1); }, 7000);
    }

    var prev = document.querySelector('.qarrow--prev');
    var next = document.querySelector('.qarrow--next');
    if (prev) prev.addEventListener('click', function () { goTo(qi - 1); restart(); });
    if (next) next.addEventListener('click', function () { goTo(qi + 1); restart(); });
    dots.forEach(function (d, i) {
      d.addEventListener('click', function () { goTo(i); restart(); });
    });

    goTo(0);
    restart();
  }

  /* --------------------------------------------------------------- faq -- */
  document.querySelectorAll('.faq__q').forEach(function (q) {
    q.addEventListener('click', function () {
      var item = q.closest('.faq__item');
      var open = item.classList.toggle('is-open');
      q.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  });

  /* -------------------------------------------------- deferred map load -- */
  /* The map iframe is only inserted once it scrolls into view. Google Maps
     embeds are heavy, and loading one on page load would wreck the mobile
     performance score for a thing most visitors never scroll to. */
  var mapHost = document.querySelector('[data-map-src]');
  if (mapHost) {
    var loadMap = function () {
      if (mapHost.dataset.loaded) return;
      mapHost.dataset.loaded = '1';
      var f = document.createElement('iframe');
      f.src = mapHost.dataset.mapSrc;
      f.loading = 'lazy';
      f.title = 'Map showing the location of The Cosy Inn Kiwenda';
      f.referrerPolicy = 'no-referrer-when-downgrade';
      f.allowFullscreen = true;
      mapHost.innerHTML = '';
      mapHost.appendChild(f);
    };

    if ('IntersectionObserver' in window) {
      var mio = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting) { loadMap(); mio.disconnect(); }
      }, { rootMargin: '300px' });
      mio.observe(mapHost);
    } else {
      loadMap();
    }
  }

}());

/* global document, window */
(() => {
  document.documentElement.classList.add('js');

  const qs = (sel, root = document) => root.querySelector(sel);
  const qsa = (sel, root = document) => Array.from(root.querySelectorAll(sel));

  // Desktop: mega/dropdown open/close (click + escape + outside click).
  const navItems = qsa('.apex-nav-item');
  const closeAllDesktop = () => {
    navItems.forEach((item) => {
      const trigger = qs('.apex-nav-trigger', item);
      const panel = qs('.apex-nav-panel', item);
      if (!trigger || !panel) return;
      trigger.setAttribute('aria-expanded', 'false');
      panel.classList.add('invisible', 'opacity-0', 'translate-y-1', 'pointer-events-none');
    });
  };

  const openDesktop = (item) => {
    closeAllDesktop();
    const trigger = qs('.apex-nav-trigger', item);
    const panel = qs('.apex-nav-panel', item);
    if (!trigger || !panel) return;
    trigger.setAttribute('aria-expanded', 'true');
    panel.classList.remove('invisible', 'opacity-0', 'translate-y-1', 'pointer-events-none');
  };

  navItems.forEach((item) => {
    const trigger = qs('.apex-nav-trigger', item);
    if (!trigger) return;

    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const expanded = trigger.getAttribute('aria-expanded') === 'true';
      if (expanded) closeAllDesktop();
      else openDesktop(item);
    });
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeAllDesktop();
  });

  document.addEventListener('click', (e) => {
    const target = e.target;
    if (!(target instanceof Element)) return;
    if (target.closest('.apex-nav-item')) return;
    closeAllDesktop();
  });

  // Mobile: menu toggle.
  const mobileToggle = qs('[data-mobile-menu-toggle]');
  const mobileMenu = qs('#apex-mobile-menu');
  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', () => {
      const isHidden = mobileMenu.classList.contains('hidden');
      mobileMenu.classList.toggle('hidden', !isHidden);
      mobileToggle.setAttribute('aria-expanded', String(isHidden));
    });
  }

  // Mobile: accordions.
  qsa('[data-mobile-accordion]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const parent = btn.parentElement;
      if (!parent) return;
      const panel = qs('[data-mobile-panel]', parent);
      if (!panel) return;

      const isOpen = !panel.classList.contains('hidden');
      panel.classList.toggle('hidden', isOpen);
      btn.setAttribute('aria-expanded', String(!isOpen));
    });
  });

  // Close mobile menu on resize to desktop.
  window.addEventListener('resize', () => {
    if (!mobileMenu || !mobileToggle) return;
    if (window.innerWidth >= 1024) {
      mobileMenu.classList.add('hidden');
      mobileToggle.setAttribute('aria-expanded', 'false');
    }
  });

  // ---------------------------------------------------------------------------
  // Home hero: simple rotating carousel (approx. every 15 seconds)
  // ---------------------------------------------------------------------------
  const heroCarousel = qs('[data-hero-carousel]');
  if (heroCarousel) {
    const heroSection = qs('[data-hero-bg]');
    const heroBackgrounds = [
      'https://www.rediansoftware.com/wp-content/uploads/2025/12/digital-core-banking-sacco-platform-dashboard-east-west-africa-2048x1152.jpg',
      'https://i0.wp.com/fintech.rediansoftware.com/wp-content/uploads/2023/06/standard-quality-control-concept-m.jpg',
      'https://i0.wp.com/fintech.rediansoftware.com/wp-content/uploads/2023/05/businessman-touch-cloud-computin-1.webp',
    ];

    const slides = qsa('[data-hero-slide]', heroCarousel);
    const dots = qsa('[data-hero-dot]', heroCarousel.parentElement?.parentElement || document);

    if (slides.length > 1) {
      let current = 0;
      let timerId;

      const setActive = (index) => {
        slides.forEach((slide, i) => {
          const isActive = i === index;
          slide.dataset.heroSlideActive = String(isActive);
          slide.classList.toggle('opacity-100', isActive);
          slide.classList.toggle('translate-y-0', isActive);
          slide.classList.toggle('opacity-0', !isActive);
          slide.classList.toggle('translate-y-4', !isActive);
          slide.style.zIndex = isActive ? '20' : '10';
        });

        dots.forEach((dot, i) => {
          const isActive = i === index;
          dot.classList.toggle('w-6', isActive);
          dot.classList.toggle('w-3', !isActive);
          dot.classList.toggle('bg-apex-orange', isActive);
          dot.classList.toggle('bg-apex-gray-200', !isActive);
        });

        if (heroSection && heroBackgrounds[index]) {
          heroSection.style.backgroundImage = `url('${heroBackgrounds[index]}')`;
        }

        current = index;
      };

      const next = () => {
        const nextIndex = (current + 1) % slides.length;
        setActive(nextIndex);
      };

      const start = () => {
        if (timerId) window.clearInterval(timerId);
        timerId = window.setInterval(next, 15000);
      };

      // Initialize
      setActive(0);
      start();

      // Allow manual navigation via dots
      dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
          setActive(index);
          start();
        });
      });
    }
  }
})();

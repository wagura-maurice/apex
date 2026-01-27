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
})();

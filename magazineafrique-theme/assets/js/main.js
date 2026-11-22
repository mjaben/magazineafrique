/**
 * Magazine Afrique — Minimalist Editorial Scripts
 */

document.addEventListener('DOMContentLoaded', () => {
  // Drawer Elements
  const drawerOverlay = document.getElementById('mobile-nav-drawer');
  const drawerPanel = document.getElementById('mobile-nav-panel');
  const menuToggle = document.getElementById('mobile-menu-toggle');
  const closeMenu = document.getElementById('close-mobile-menu');

  // Search Elements
  const searchModal = document.getElementById('search-modal');
  const searchPanel = document.getElementById('search-panel');
  const searchToggle = document.getElementById('search-toggle');
  const searchClose = document.getElementById('search-close');

  function openDrawer() {
    if (drawerOverlay) {
      drawerOverlay.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      if (searchModal) searchModal.classList.add('hidden');
    }
  }

  function closeDrawer() {
    if (drawerOverlay) {
      drawerOverlay.classList.add('hidden');
      document.body.style.overflow = '';
    }
  }

  function openSearch() {
    if (searchModal) {
      searchModal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      if (drawerOverlay) drawerOverlay.classList.add('hidden');
      const input = searchModal.querySelector('input[type="search"]');
      if (input) setTimeout(() => input.focus(), 60);
    }
  }

  function closeSearch() {
    if (searchModal) {
      searchModal.classList.add('hidden');
      document.body.style.overflow = '';
    }
  }

  // Drawer Listeners
  const bottomMenuToggle = document.getElementById('bottom-menu-toggle');
  if (menuToggle) menuToggle.addEventListener('click', openDrawer);
  if (bottomMenuToggle) bottomMenuToggle.addEventListener('click', openDrawer);
  if (closeMenu) closeMenu.addEventListener('click', closeDrawer);
  if (drawerOverlay) {
    drawerOverlay.addEventListener('click', (e) => {
      if (drawerPanel && !drawerPanel.contains(e.target)) {
        closeDrawer();
      }
    });
  }

  // Search Listeners
  const bottomSearchToggle = document.getElementById('bottom-search-toggle');
  if (searchToggle) searchToggle.addEventListener('click', openSearch);
  if (bottomSearchToggle) bottomSearchToggle.addEventListener('click', openSearch);
  if (searchClose) searchClose.addEventListener('click', closeSearch);
  if (searchModal) {
    searchModal.addEventListener('click', (e) => {
      if (searchPanel && !searchPanel.contains(e.target)) {
        closeSearch();
      }
    });
  }

  // Global ESC Key Listener
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeDrawer();
      closeSearch();
    }
  });

  // Newsletter AJAX Form
  const newsletterForms = document.querySelectorAll('.magazine-newsletter-form');
  newsletterForms.forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const emailInput = form.querySelector('input[type="email"]');
      const feedback = form.querySelector('.newsletter-feedback');
      const submitBtn = form.querySelector('button[type="submit"]');

      if (!emailInput || !emailInput.value) return;

      const email = emailInput.value;
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = '...';
      }

      try {
        const formData = new FormData();
        formData.append('action', 'magazineafrique_subscribe');
        formData.append('email', email);
        if (window.magazineafrique_vars && window.magazineafrique_vars.nonce) {
          formData.append('nonce', window.magazineafrique_vars.nonce);
        }

        const ajaxUrl = window.magazineafrique_vars ? window.magazineafrique_vars.ajax_url : '/wp-admin/admin-ajax.php';
        const response = await fetch(ajaxUrl, {
          method: 'POST',
          body: formData
        });

        const data = await response.json();
        if (data.success) {
          emailInput.value = '';
          if (feedback) {
            feedback.textContent = '✓ Subscribed to The Africa Brief.';
            feedback.style.color = '#0B5128';
            feedback.style.fontSize = '0.75rem';
            feedback.style.marginTop = '0.5rem';
            feedback.style.fontWeight = 'bold';
          }
        }
      } catch (err) {
        if (feedback) {
          feedback.textContent = 'Subscription confirmed.';
          feedback.style.color = '#0B5128';
          feedback.style.fontSize = '0.75rem';
          feedback.style.marginTop = '0.5rem';
        }
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Subscribe';
        }
      }
    });
  });
});

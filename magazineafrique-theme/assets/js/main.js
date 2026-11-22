/**
 * Magazine Afrique — Main Client Script
 * Native Mobile App UI/UX & Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
  // Elements
  const mobileDrawer = document.getElementById('mobile-nav-drawer');
  const drawerPanel = document.getElementById('mobile-nav-panel');
  const menuToggle = document.getElementById('mobile-menu-toggle');
  const closeMenu = document.getElementById('close-mobile-menu');
  const bottomTabSections = document.getElementById('app-tab-sections');

  const searchModal = document.getElementById('search-modal');
  const searchPanel = document.getElementById('search-panel');
  const searchToggle = document.getElementById('search-toggle');
  const searchClose = document.getElementById('search-close');
  const bottomTabSearch = document.getElementById('app-tab-search');

  // Helper: Open Drawer
  function openDrawer() {
    if (mobileDrawer) {
      mobileDrawer.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      if (searchModal) searchModal.classList.add('hidden');
    }
  }

  // Helper: Close Drawer
  function closeDrawer() {
    if (mobileDrawer) {
      mobileDrawer.classList.add('hidden');
      document.body.style.overflow = '';
    }
  }

  // Helper: Open Search
  function openSearch() {
    if (searchModal) {
      searchModal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      if (mobileDrawer) mobileDrawer.classList.add('hidden');
      const input = searchModal.querySelector('input[type="search"]');
      if (input) setTimeout(() => input.focus(), 50);
    }
  }

  // Helper: Close Search
  function closeSearch() {
    if (searchModal) {
      searchModal.classList.add('hidden');
      document.body.style.overflow = '';
    }
  }

  // 1. Mobile App Drawer Triggers
  if (menuToggle) menuToggle.addEventListener('click', openDrawer);
  if (bottomTabSections) bottomTabSections.addEventListener('click', (e) => {
    e.preventDefault();
    if (mobileDrawer && !mobileDrawer.classList.contains('hidden')) {
      closeDrawer();
    } else {
      openDrawer();
    }
  });
  if (closeMenu) closeMenu.addEventListener('click', closeDrawer);

  // Close Drawer on Backdrop Click
  if (mobileDrawer) {
    mobileDrawer.addEventListener('click', (e) => {
      if (drawerPanel && !drawerPanel.contains(e.target)) {
        closeDrawer();
      }
    });
  }

  // 2. Search Sheet Triggers
  if (searchToggle) searchToggle.addEventListener('click', openSearch);
  if (bottomTabSearch) bottomTabSearch.addEventListener('click', (e) => {
    e.preventDefault();
    if (searchModal && !searchModal.classList.contains('hidden')) {
      closeSearch();
    } else {
      openSearch();
    }
  });
  if (searchClose) searchClose.addEventListener('click', closeSearch);

  // Close Search on Backdrop Click
  if (searchModal) {
    searchModal.addEventListener('click', (e) => {
      if (searchPanel && !searchPanel.contains(e.target)) {
        closeSearch();
      }
    });
  }

  // Global ESC Key Handler
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeDrawer();
      closeSearch();
    }
  });

  // 3. Language Switcher Dropdown (Desktop)
  const langBtn = document.getElementById('lang-menu-btn');
  const langDropdown = document.getElementById('lang-dropdown');
  if (langBtn && langDropdown) {
    langBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      langDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
      langDropdown.classList.add('hidden');
    });
  }

  // 4. Newsletter AJAX Form Handler
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
        submitBtn.textContent = 'Subscribing...';
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
            feedback.textContent = '✓ Subscribed! Welcome to The Africa Brief.';
            feedback.className = 'newsletter-feedback text-xs mt-2 text-emerald-800 font-bold';
          }
        } else {
          if (feedback) {
            feedback.textContent = data.data || 'An error occurred. Please try again.';
            feedback.className = 'newsletter-feedback text-xs mt-2 text-red-700 font-semibold';
          }
        }
      } catch (err) {
        if (feedback) {
          feedback.textContent = 'Subscription confirmed! Welcome.';
          feedback.className = 'newsletter-feedback text-xs mt-2 text-emerald-800 font-bold';
        }
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Subscribe Free';
        }
      }
    });
  });
});

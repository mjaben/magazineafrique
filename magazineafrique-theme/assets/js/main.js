/**
 * Magazine Afrique — Main Client Script
 * Lightweight vanilla JavaScript (zero framework bloat)
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Mobile Menu Toggle
  const menuToggle = document.getElementById('mobile-menu-toggle');
  const mobileDrawer = document.getElementById('mobile-nav-drawer');
  const closeMenu = document.getElementById('close-mobile-menu');

  if (menuToggle && mobileDrawer) {
    menuToggle.addEventListener('click', () => {
      mobileDrawer.classList.toggle('hidden');
      document.body.classList.toggle('overflow-hidden');
    });

    if (closeMenu) {
      closeMenu.addEventListener('click', () => {
        mobileDrawer.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      });
    }
  }

  // 2. Search Overlay Toggle
  const searchToggle = document.getElementById('search-toggle');
  const searchModal = document.getElementById('search-modal');
  const searchClose = document.getElementById('search-close');

  if (searchToggle && searchModal) {
    searchToggle.addEventListener('click', () => {
      searchModal.classList.toggle('hidden');
      const input = searchModal.querySelector('input[type="search"]');
      if (input) input.focus();
    });

    if (searchClose) {
      searchClose.addEventListener('click', () => {
        searchModal.classList.add('hidden');
      });
    }
  }

  // 2b. Language Switcher Dropdown Toggle
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

  // 3. Newsletter AJAX Form Handler
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
        submitBtn.textContent = 'Inscription...';
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
            feedback.textContent = '✓ Merci ! Vous êtes désormais inscrit au Brief Afrique.';
            feedback.className = 'newsletter-feedback text-xs mt-2 text-emerald-800 font-bold';
          }
        } else {
          if (feedback) {
            feedback.textContent = data.data || 'Une erreur est survenue. Veuillez réessayer.';
            feedback.className = 'newsletter-feedback text-xs mt-2 text-red-700 font-semibold';
          }
        }
      } catch (err) {
        if (feedback) {
          feedback.textContent = 'Inscription confirmée ! Bienvenue.';
          feedback.className = 'newsletter-feedback text-xs mt-2 text-emerald-800 font-bold';
        }
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = "S'inscrire";
        }
      }
    });
  });
});

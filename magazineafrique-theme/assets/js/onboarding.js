/**
 * Magazine Afrique — Auto-Location & Reader Onboarding Client Engine
 */

document.addEventListener('DOMContentLoaded', () => {
  const locInput = document.getElementById('reader-location-input');
  const countryInput = document.getElementById('reader-country-input');
  const cityInput = document.getElementById('reader-city-input');
  const statusEl = document.getElementById('location-detect-status');
  const detectBtn = document.getElementById('btn-trigger-detect');
  const onboardingForm = document.getElementById('magazineafrique-onboarding-form');
  const profileForm = document.getElementById('magazineafrique-profile-form');

  // 1. Auto-Location Detector (GPS + Reverse Geocode + IP Fallback)
  async function detectReaderLocation(silent = false) {
    if (!locInput) return;

    if (!silent && statusEl) {
      statusEl.innerHTML = '<span style="color: #D97706;">● Querying browser satellite geolocation...</span>';
    }
    if (detectBtn) detectBtn.disabled = true;

    if ('geolocation' in navigator) {
      navigator.geolocation.getCurrentPosition(
        async (position) => {
          const lat = position.coords.latitude;
          const lng = position.coords.longitude;

          try {
            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
            const data = await res.json();
            const city = data.address.city || data.address.town || data.address.state || 'Capital Hub';
            const country = data.address.country || 'Africa';
            const formatted = `${city}, ${country}`;

            locInput.value = formatted;
            if (countryInput) countryInput.value = country;
            if (cityInput) cityInput.value = city;

            if (statusEl) {
              statusEl.innerHTML = `<span style="color: #0B5128;">✓ Location acquired via GPS: <strong>${formatted}</strong> (News localized)</span>`;
            }
            localStorage.setItem('magafrique_detected_location', formatted);
          } catch (e) {
            fallbackIpDetection(silent);
          } finally {
            if (detectBtn) detectBtn.disabled = false;
          }
        },
        (error) => {
          console.log('[Location] GPS denied or unavailable, trying IP detection:', error);
          fallbackIpDetection(silent);
        },
        { timeout: 8000 }
      );
    } else {
      fallbackIpDetection(silent);
    }
  }

  async function fallbackIpDetection(silent = false) {
    if (detectBtn) detectBtn.disabled = false;
    try {
      if (!silent && statusEl) {
        statusEl.innerHTML = '<span style="color: #0B5128;">● Detecting regional hub via network IP...</span>';
      }
      const res = await fetch('https://ipapi.co/json/');
      const data = await res.json();
      const city = data.city || 'Lagos';
      const country = data.country_name || 'Nigeria';
      const formatted = `${city}, ${country}`;

      if (locInput) locInput.value = formatted;
      if (countryInput) countryInput.value = country;
      if (cityInput) cityInput.value = city;

      if (statusEl) {
        statusEl.innerHTML = `<span style="color: #0B5128;">✓ Location detected: <strong>${formatted}</strong> (Regional feed active)</span>`;
      }
      localStorage.setItem('magafrique_detected_location', formatted);
    } catch (e) {
      if (locInput && !locInput.value) {
        locInput.value = 'Lagos, Nigeria';
        if (countryInput) countryInput.value = 'Nigeria';
        if (cityInput) cityInput.value = 'Lagos';
      }
      if (statusEl) {
        statusEl.innerHTML = '<span style="color: #6B6359;">● Default Pan-African hub set (Lagos, Nigeria). You can edit manually.</span>';
      }
    }
  }

  if (detectBtn) {
    detectBtn.addEventListener('click', (e) => {
      e.preventDefault();
      detectReaderLocation(false);
    });
  }

  // Auto-detect on page load if field is blank
  if (locInput && !locInput.value) {
    detectReaderLocation(true);
  }

  // 2. Onboarding Form Submission
  if (onboardingForm) {
    onboardingForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const feedback = onboardingForm.querySelector('.form-feedback');
      const submitBtn = onboardingForm.querySelector('button[type="submit"]');

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Enrolling...';
      }

      const formData = new FormData(onboardingForm);
      formData.append('action', 'magazineafrique_onboarding_submit');
      formData.append('nonce', window.magazineafrique_vars?.nonce || '');

      try {
        const response = await fetch(window.magazineafrique_vars.ajax_url, {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.success) {
          if (feedback) {
            feedback.innerHTML = `<div style="color: #0B5128; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          }
          setTimeout(() => {
            window.location.href = result.data.redirect_url || '/profile/';
          }, 800);
        } else {
          if (feedback) {
            feedback.innerHTML = `<div style="color: #8B2500; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          }
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Complete Enrollment →';
          }
        }
      } catch (err) {
        if (feedback) {
          feedback.innerHTML = '<div style="color: #8B2500;">Connection failed. Please retry.</div>';
        }
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Complete Enrollment →';
        }
      }
    });
  }

  // 3. Profile Form Submission
  if (profileForm) {
    profileForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const feedback = profileForm.querySelector('.form-feedback');
      const submitBtn = profileForm.querySelector('button[type="submit"]');

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Saving...';
      }

      const formData = new FormData(profileForm);
      formData.append('action', 'magazineafrique_update_profile');
      formData.append('nonce', window.magazineafrique_vars?.nonce || '');

      try {
        const response = await fetch(window.magazineafrique_vars.ajax_url, {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.success) {
          if (feedback) {
            feedback.innerHTML = `<div style="color: #0B5128; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          }
          setTimeout(() => {
            window.location.reload();
          }, 800);
        } else {
          if (feedback) {
            feedback.innerHTML = `<div style="color: #8B2500; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          }
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Save Profile Changes';
          }
        }
      } catch (err) {
        if (feedback) {
          feedback.innerHTML = '<div style="color: #8B2500;">Network error. Please try again.</div>';
        }
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Save Profile Changes';
        }
      }
    });
  }
});

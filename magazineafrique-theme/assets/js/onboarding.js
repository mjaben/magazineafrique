/**
 * Magazine Afrique — Auto-Location & Reader Onboarding Client Engine
 * Implements Vintage Retro Hard-Shadow UI, 4-Digit OTP Boxes & Password Reset
 */

document.addEventListener('DOMContentLoaded', () => {
  const locInput = document.getElementById('reader-location-input');
  const countryInput = document.getElementById('reader-country-input');
  const cityInput = document.getElementById('reader-city-input');
  const statusEl = document.getElementById('location-detect-status');
  const detectBtn = document.getElementById('btn-trigger-detect');

  // Screens
  const screenSignin = document.getElementById('screen-signin');
  const screenSignup = document.getElementById('screen-signup');
  const screenVerifyOtp = document.getElementById('screen-verify-otp');
  const screenForgot = document.getElementById('screen-forgot-password');
  const screenResetVerify = document.getElementById('screen-reset-password-verify');
  const authTabBar = document.getElementById('auth-mode-tab-bar');

  // Tab buttons
  const tabBtnSignin = document.getElementById('tab-btn-signin');
  const tabBtnSignup = document.getElementById('tab-btn-signup');
  const switchToSignup = document.getElementById('switch-to-signup-btn');
  const switchToSignin = document.getElementById('switch-to-signin-btn');
  const triggerForgot = document.getElementById('trigger-forgot-password-btn');
  const backToLogin = document.getElementById('back-to-login-btn');

  // Forms
  const loginForm = document.getElementById('magazineafrique-login-form');
  const onboardingForm = document.getElementById('magazineafrique-onboarding-form');
  const verifyOtpForm = document.getElementById('magazineafrique-verify-otp-form');
  const forgotForm = document.getElementById('magazineafrique-forgot-form');
  const resetVerifyForm = document.getElementById('magazineafrique-reset-verify-form');
  const profileForm = document.getElementById('magazineafrique-profile-form');

  // Resend Timer elements
  const resendCountdown = document.getElementById('resend-countdown');
  const resendLabel = document.getElementById('resend-label');
  const btnResendOtp = document.getElementById('btn-resend-otp');
  const otpTargetDisplay = document.getElementById('otp-target-display');

  let countdownInterval = null;

  // Screen Switchers
  function showScreen(screen) {
    [screenSignin, screenSignup, screenVerifyOtp, screenForgot, screenResetVerify].forEach(s => {
      if (s) s.style.display = 'none';
    });
    if (screen) {
      screen.style.display = 'block';
    }
  }

  function switchToSigninScreen() {
    showScreen(screenSignin);
    if (authTabBar) authTabBar.style.display = 'flex';
    if (tabBtnSignin) tabBtnSignin.classList.add('active');
    if (tabBtnSignup) tabBtnSignup.classList.remove('active');
    if (history.replaceState) history.replaceState(null, '', '?mode=login');
  }

  function switchToSignupScreen() {
    showScreen(screenSignup);
    if (authTabBar) authTabBar.style.display = 'flex';
    if (tabBtnSignup) tabBtnSignup.classList.add('active');
    if (tabBtnSignin) tabBtnSignin.classList.remove('active');
    if (history.replaceState) history.replaceState(null, '', '?mode=register');
  }

  if (tabBtnSignin) tabBtnSignin.addEventListener('click', switchToSigninScreen);
  if (tabBtnSignup) tabBtnSignup.addEventListener('click', switchToSignupScreen);
  if (switchToSignup) switchToSignup.addEventListener('click', switchToSignupScreen);
  if (switchToSignin) switchToSignin.addEventListener('click', switchToSigninScreen);

  if (triggerForgot) {
    triggerForgot.addEventListener('click', () => {
      showScreen(screenForgot);
      if (authTabBar) authTabBar.style.display = 'none';
    });
  }

  if (backToLogin) {
    backToLogin.addEventListener('click', () => {
      switchToSigninScreen();
    });
  }

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
              statusEl.innerHTML = `<span style="color: #0B5128;">✓ Location acquired via GPS: <strong>${formatted}</strong></span>`;
            }
          } catch (e) {
            fallbackIpDetection(silent);
          } finally {
            if (detectBtn) detectBtn.disabled = false;
          }
        },
        () => {
          fallbackIpDetection(silent);
        },
        { timeout: 7000 }
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
        statusEl.innerHTML = `<span style="color: #0B5128;">✓ Location detected: <strong>${formatted}</strong></span>`;
      }
    } catch (e) {
      if (locInput && !locInput.value) {
        locInput.value = 'Lagos, Nigeria';
      }
    }
  }

  if (detectBtn) {
    detectBtn.addEventListener('click', (e) => {
      e.preventDefault();
      detectReaderLocation(false);
    });
  }

  if (locInput && !locInput.value) {
    detectReaderLocation(true);
  }

  // 2. Setup OTP Digit Inputs Auto-Advance & Backspace
  function setupOtpDigitInputs(containerSelector) {
    const inputs = document.querySelectorAll(`${containerSelector} .vintage-otp-digit`);
    inputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
        const val = e.target.value.replace(/[^0-9]/g, '');
        e.target.value = val;
        if (val && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });

      input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && index > 0) {
          inputs[index - 1].focus();
        }
      });

      input.addEventListener('paste', (e) => {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
        if (pasted) {
          const chars = pasted.split('');
          inputs.forEach((inp, i) => {
            if (chars[i]) inp.value = chars[i];
          });
          const nextIndex = Math.min(chars.length, inputs.length - 1);
          inputs[nextIndex].focus();
        }
      });
    });
  }

  setupOtpDigitInputs('#screen-verify-otp');
  setupOtpDigitInputs('#screen-reset-password-verify');

  function startResendTimer() {
    let timeLeft = 60;
    if (resendCountdown) resendCountdown.textContent = timeLeft;
    if (resendLabel) resendLabel.style.display = 'inline';
    if (btnResendOtp) btnResendOtp.style.display = 'none';

    if (countdownInterval) clearInterval(countdownInterval);

    countdownInterval = setInterval(() => {
      timeLeft--;
      if (resendCountdown) resendCountdown.textContent = timeLeft;
      if (timeLeft <= 0) {
        clearInterval(countdownInterval);
        if (resendLabel) resendLabel.style.display = 'none';
        if (btnResendOtp) btnResendOtp.style.display = 'inline';
      }
    }, 1000);
  }

  if (btnResendOtp) {
    btnResendOtp.addEventListener('click', async () => {
      btnResendOtp.textContent = 'Dispatching...';
      const formData = new FormData();
      formData.append('action', 'magazineafrique_resend_otp');
      formData.append('nonce', window.magazineafrique_vars?.nonce || '');
      formData.append('otp_type', 'onboarding');

      try {
        const res = await fetch(window.magazineafrique_vars.ajax_url, {
          method: 'POST',
          body: formData
        });
        const data = await res.json();
        btnResendOtp.textContent = 'Resend Code Now';
        startResendTimer();
        alert(data.data?.message || 'Verification code resent!');
      } catch (err) {
        btnResendOtp.textContent = 'Resend Code Now';
      }
    });
  }

  // 3. Log In Form Submission (Username/Email & Password)
  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const feedback = loginForm.querySelector('.login-feedback');
      const submitBtn = loginForm.querySelector('button[type="submit"]');

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Verifying...</span>';
      }

      const formData = new FormData(loginForm);
      formData.append('action', 'magazineafrique_ajax_login');
      formData.append('nonce', window.magazineafrique_vars?.nonce || '');

      try {
        const res = await fetch(window.magazineafrique_vars.ajax_url, {
          method: 'POST',
          body: formData
        });
        const result = await res.json();

        if (result.success) {
          if (feedback) feedback.innerHTML = `<div style="color: #0B5128; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          setTimeout(() => {
            window.location.href = result.data.redirect_url || '/profile/';
          }, 600);
        } else {
          if (feedback) feedback.innerHTML = `<div style="color: #8B2500; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Continue</span> <span>»</span>';
          }
        }
      } catch (err) {
        if (feedback) feedback.innerHTML = '<div style="color: #8B2500;">Connection failed. Please retry.</div>';
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<span>Continue</span> <span>»</span>';
        }
      }
    });
  }

  // 4. Onboarding / Sign Up Form Submission -> Dispatches OTP & Transitions to Screen 3
  if (onboardingForm) {
    onboardingForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const feedback = onboardingForm.querySelector('.signup-feedback');
      const submitBtn = onboardingForm.querySelector('button[type="submit"]');

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Dispatching Code...</span>';
      }

      const formData = new FormData(onboardingForm);
      formData.append('action', 'magazineafrique_onboarding_submit');
      formData.append('nonce', window.magazineafrique_vars?.nonce || '');

      try {
        const res = await fetch(window.magazineafrique_vars.ajax_url, {
          method: 'POST',
          body: formData
        });
        const result = await res.json();

        if (result.success && result.data?.step === 'verify_otp') {
          // Transition to OTP verification screen
          showScreen(screenVerifyOtp);
          if (authTabBar) authTabBar.style.display = 'none';
          if (otpTargetDisplay) otpTargetDisplay.textContent = result.data.target;
          startResendTimer();
          const firstOtp = document.getElementById('otp-1');
          if (firstOtp) setTimeout(() => firstOtp.focus(), 80);
        } else if (result.success) {
          window.location.href = result.data.redirect_url || '/profile/';
        } else {
          if (feedback) feedback.innerHTML = `<div style="color: #8B2500; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Continue</span> <span>»</span>';
          }
        }
      } catch (err) {
        if (feedback) feedback.innerHTML = '<div style="color: #8B2500;">Network error. Please try again.</div>';
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<span>Continue</span> <span>»</span>';
        }
      }
    });
  }

  // 5. Verify OTP Form Submission (Onboarding)
  if (verifyOtpForm) {
    verifyOtpForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const feedback = verifyOtpForm.querySelector('.verify-feedback');
      const submitBtn = verifyOtpForm.querySelector('button[type="submit"]');

      const d1 = document.getElementById('otp-1')?.value || '';
      const d2 = document.getElementById('otp-2')?.value || '';
      const d3 = document.getElementById('otp-3')?.value || '';
      const d4 = document.getElementById('otp-4')?.value || '';
      const fullOtp = `${d1}${d2}${d3}${d4}`;

      if (fullOtp.length < 4) {
        if (feedback) feedback.innerHTML = '<div style="color: #8B2500; font-weight: bold;">Please enter the full 4-digit verification code.</div>';
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Verifying Code...</span>';
      }

      const formData = new FormData();
      formData.append('action', 'magazineafrique_verify_otp');
      formData.append('nonce', window.magazineafrique_vars?.nonce || '');
      formData.append('otp_code', fullOtp);

      try {
        const res = await fetch(window.magazineafrique_vars.ajax_url, {
          method: 'POST',
          body: formData
        });
        const result = await res.json();

        if (result.success) {
          if (feedback) feedback.innerHTML = `<div style="color: #0B5128; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          setTimeout(() => {
            window.location.href = result.data.redirect_url || '/profile/';
          }, 600);
        } else {
          if (feedback) feedback.innerHTML = `<div style="color: #8B2500; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Continue</span> <span>»</span>';
          }
        }
      } catch (err) {
        if (feedback) feedback.innerHTML = '<div style="color: #8B2500;">Verification request failed. Please retry.</div>';
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<span>Continue</span> <span>»</span>';
        }
      }
    });
  }

  // 6. Forgot Password Request Form Submission
  if (forgotForm) {
    forgotForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const feedback = forgotForm.querySelector('.forgot-feedback');
      const submitBtn = forgotForm.querySelector('button[type="submit"]');

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Dispatching Code...</span>';
      }

      const formData = new FormData(forgotForm);
      formData.append('action', 'magazineafrique_forgot_password');
      formData.append('nonce', window.magazineafrique_vars?.nonce || '');

      try {
        const res = await fetch(window.magazineafrique_vars.ajax_url, {
          method: 'POST',
          body: formData
        });
        const result = await res.json();

        if (result.success && result.data?.step === 'verify_reset_otp') {
          showScreen(screenResetVerify);
          const firstResetOtp = document.getElementById('reset-otp-1');
          if (firstResetOtp) setTimeout(() => firstResetOtp.focus(), 80);
        } else {
          if (feedback) feedback.innerHTML = `<div style="color: #8B2500; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Continue (Send Code)</span> <span>»</span>';
          }
        }
      } catch (err) {
        if (feedback) feedback.innerHTML = '<div style="color: #8B2500;">Connection failed.</div>';
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<span>Continue (Send Code)</span> <span>»</span>';
        }
      }
    });
  }

  // 7. Verify Reset Password OTP & Set New Password
  if (resetVerifyForm) {
    resetVerifyForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const feedback = resetVerifyForm.querySelector('.reset-feedback');
      const submitBtn = resetVerifyForm.querySelector('button[type="submit"]');

      const d1 = document.getElementById('reset-otp-1')?.value || '';
      const d2 = document.getElementById('reset-otp-2')?.value || '';
      const d3 = document.getElementById('reset-otp-3')?.value || '';
      const d4 = document.getElementById('reset-otp-4')?.value || '';
      const fullOtp = `${d1}${d2}${d3}${d4}`;

      if (fullOtp.length < 4) {
        if (feedback) feedback.innerHTML = '<div style="color: #8B2500; font-weight: bold;">Please enter the 4-digit reset code.</div>';
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Updating Password...</span>';
      }

      const formData = new FormData(resetVerifyForm);
      formData.append('action', 'magazineafrique_verify_reset_password');
      formData.append('nonce', window.magazineafrique_vars?.nonce || '');
      formData.append('otp_code', fullOtp);

      try {
        const res = await fetch(window.magazineafrique_vars.ajax_url, {
          method: 'POST',
          body: formData
        });
        const result = await res.json();

        if (result.success) {
          if (feedback) feedback.innerHTML = `<div style="color: #0B5128; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          setTimeout(() => {
            window.location.href = result.data.redirect_url || '/profile/';
          }, 600);
        } else {
          if (feedback) feedback.innerHTML = `<div style="color: #8B2500; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Continue (Update Password)</span> <span>»</span>';
          }
        }
      } catch (err) {
        if (feedback) feedback.innerHTML = '<div style="color: #8B2500;">Password update failed.</div>';
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<span>Continue (Update Password)</span> <span>»</span>';
        }
      }
    });
  }

  // 8. Profile Form Submission
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
          if (feedback) feedback.innerHTML = `<div style="color: #0B5128; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          setTimeout(() => {
            window.location.reload();
          }, 800);
        } else {
          if (feedback) feedback.innerHTML = `<div style="color: #8B2500; font-weight: bold; padding: 0.5rem 0;">${result.data.message}</div>`;
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Save Profile Changes';
          }
        }
      } catch (err) {
        if (feedback) feedback.innerHTML = '<div style="color: #8B2500;">Network error. Please try again.</div>';
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Save Profile Changes';
        }
      }
    });
  }
});

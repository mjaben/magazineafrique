<?php
/**
 * Magazine Afrique — Archival Broadsheet HTML Email Dispatch Engine
 * Designed for OTP Verifications, Password Resets & Welcome Dispatches
 *
 * @package MagazineAfrique
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Generate and dispatch a vintage broadsheet styled HTML email
 *
 * @param string $to_email Recipient email address
 * @param string $otp_code 4-digit or 6-digit OTP code
 * @param string $purpose  'onboarding' | 'reset_password' | 'login'
 * @param string $user_name Optional reader name
 * @return bool True if mail sent successfully
 */
if (!function_exists('magazineafrique_send_otp_email')) {
    function magazineafrique_send_otp_email($to_email, $otp_code, $purpose = 'onboarding', $user_name = '') {
        $site_name = get_bloginfo('name') ?: 'Magazine Afrique';
        $site_url  = home_url('/');
        $greeting_name = !empty($user_name) ? esc_html($user_name) : 'Correspondent';

        $is_reset = ($purpose === 'reset_password');
        $subject = $is_reset 
            ? "[$site_name] Password Reset Verification Code: $otp_code" 
            : "[$site_name] Reader Enrollment Verification Code: $otp_code";

        $headline = $is_reset 
            ? "Password Reset Request" 
            : "Pan-African Reader Verification";

        $description = $is_reset
            ? "We received an authorized request to reset the security credentials for your Magazine Afrique correspondent account. Enter the verification code below to establish your new password:"
            : "Welcome to the Pan-African Reader Circle. To authenticate your reading desk and begin receiving tailored dispatches, please enter this single-use verification code:";

        // Archival HTML Email Template (Inline CSS for universal Gmail / Apple Mail / Outlook compatibility)
        $message = '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>' . esc_html($subject) . '</title>
</head>
<body style="margin: 0; padding: 0; background-color: #F4EFE6; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">

<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F4EFE6; padding: 32px 16px;">
  <tr>
    <td align="center">
      
      <!-- Main Container Box (Vintage Hard Shadow Card) -->
      <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 580px; background-color: #FAF6EE; border: 2px solid #231F1D; border-radius: 4px; box-shadow: 5px 5px 0px #1C1917; overflow: hidden;">
        
        <!-- Retro Chevron Geometric Top Bar (Archival African Poster Accent) -->
        <tr>
          <td style="height: 12px; background: #8B2500; font-size: 0; line-height: 0;">
            <div style="height: 4px; background: #D97706;"></div>
            <div style="height: 4px; background: #F59E0B;"></div>
            <div style="height: 4px; background: #171513;"></div>
          </td>
        </tr>

        <!-- Masthead -->
        <tr>
          <td style="padding: 28px 32px 20px; border-bottom: 2px solid #231F1D; text-align: center; background-color: #FAF6EE;">
            <div style="font-family: \'Courier New\', Courier, monospace; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: #8B2500; margin-bottom: 6px;">
              [ OFFICIAL EDITORIAL DISPATCH · SECURITY DESK ]
            </div>
            <div style="font-family: Georgia, \'Times New Roman\', serif; font-size: 26px; font-weight: 900; letter-spacing: -0.5px; color: #171513; margin: 0 0 4px;">
              MAGAZINE AFRIQUE
            </div>
            <div style="font-size: 11px; font-style: italic; color: #736B5E; letter-spacing: 0.5px;">
              The Pan-African Gazette of Strategic Analysis &amp; Investigation
            </div>
          </td>
        </tr>

        <!-- Body Content -->
        <tr>
          <td style="padding: 32px 32px 28px; background-color: #FAF6EE;">
            
            <div style="font-size: 15px; font-weight: 700; color: #171513; margin-bottom: 12px;">
              Greetings, ' . $greeting_name . ' —
            </div>

            <p style="font-size: 14px; line-height: 1.6; color: #403A33; margin: 0 0 20px;">
              ' . $description . '
            </p>

            <!-- Vintage OTP Box -->
            <div style="margin: 28px 0; text-align: center;">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                <tr>
                  <td style="background-color: #FAF6EE; border: 2px solid #231F1D; border-radius: 4px; box-shadow: 4px 4px 0px #231F1D; padding: 18px 36px; text-align: center;">
                    <div style="font-family: \'Courier New\', Courier, monospace; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: #8B2500; margin-bottom: 6px;">
                      SINGLE-USE VERIFICATION CODE
                    </div>
                    <div style="font-family: \'Courier New\', Courier, monospace; font-size: 38px; font-weight: 900; letter-spacing: 14px; color: #171513; margin-left: 14px;">
                      ' . esc_html($otp_code) . '
                    </div>
                  </td>
                </tr>
              </table>
            </div>

            <!-- Notice / Expiration -->
            <div style="background-color: #EFE9DE; border-left: 3px solid #8B2500; padding: 12px 14px; margin-bottom: 24px;">
              <div style="font-size: 12px; font-weight: 700; color: #171513; margin-bottom: 2px;">
                ⏱ Code Expires in 15 Minutes
              </div>
              <div style="font-size: 12px; line-height: 1.5; color: #5C564E;">
                For security reasons, never forward this message. If you did not initiate this request, no action is required and you may safely disregard this dispatch.
              </div>
            </div>

            <div style="font-size: 13px; line-height: 1.5; color: #5C564E;">
              Need editorial assistance? Contact our bureau at <a href="mailto:contact@magazineafrique.org" style="color: #8B2500; font-weight: 700; text-decoration: underline;">contact@magazineafrique.org</a>.
            </div>

          </td>
        </tr>

        <!-- Broadsheet Footer -->
        <tr>
          <td style="padding: 24px 32px; background-color: #231F1D; color: #D8CEBE; text-align: center; border-top: 2px solid #1C1917;">
            <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #F59E0B; margin-bottom: 6px;">
              ★ THE INTELLECTUAL GAZETTE SYNDICATE
            </div>
            <div style="font-size: 11px; color: #A89F91; line-height: 1.5; margin-bottom: 12px;">
              Independent pan-African journalism covering governance, finance, mining, technology, and culture across all 54 nations.
            </div>
            <div style="font-size: 10px; color: #7A7266; font-family: \'Courier New\', Courier, monospace;">
              &copy; ' . date('Y') . ' Magazine Afrique · All Rights Reserved
            </div>
          </td>
        </tr>

      </table>

    </td>
  </tr>
</table>

</body>
</html>';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Magazine Afrique <noreply@magazineafrique.org>'
        );

        return wp_mail($to_email, $subject, $message, $headers);
    }
}

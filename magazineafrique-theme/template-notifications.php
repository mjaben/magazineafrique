<?php
/**
 * Template Name: Reader Notifications
 * Template Post Type: page
 *
 * @package MagazineAfrique
 */

get_header();

$user_id = get_current_user_id();
$notifications = function_exists('magazineafrique_get_user_notifications') ? magazineafrique_get_user_notifications($user_id) : array();
$unread_count = 0;
foreach ($notifications as $n) {
    if (empty($n['read'])) $unread_count++;
}
?>

<main id="primary" class="site-main container-editorial broadsheet-main" style="max-width: 680px; margin: 0 auto; padding-top: 2rem;">

    <div class="vintage-framed-box" style="background-color: #F6F1E8; border: 2px solid #231F1D; padding: 1.5rem; border-radius: 4px; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
        
        <!-- Header -->
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; border-bottom: 2px solid #231F1D; padding-bottom: 1rem; margin-bottom: 1.5rem;">
            <div>
                <div style="font-size: 0.6875rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: #8B2500; font-family: 'JetBrains Mono', monospace; margin-bottom: 0.25rem;">
                    Gazette Dispatch Wire
                </div>
                <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.75rem; font-weight: 900; color: #171513; margin: 0;">
                    Notifications &amp; Alerts
                </h1>
            </div>

            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <?php if ($unread_count > 0) : ?>
                    <span id="notif-badge-count" style="background-color: #8B2500; color: #FFFFFF; font-size: 0.6875rem; font-weight: 800; padding: 0.2rem 0.5rem; border-radius: 9999px; font-family: 'JetBrains Mono', monospace;">
                        <?php echo esc_html($unread_count); ?> UNREAD
                    </span>
                <?php endif; ?>
                <button type="button" id="btn-mark-all-read" class="circular-notice-btn" style="padding: 0.35rem 0.65rem; font-size: 0.6875rem;">
                    ✓ Mark All Read
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div id="notifications-list" style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 2rem;">
            <?php if (!empty($notifications)) : ?>
                <?php foreach ($notifications as $notif) : ?>
                    <div class="vintage-grid-card" style="background-color: <?php echo empty($notif['read']) ? '#EFE9DE' : '#FAF6F0'; ?>; border: 1px solid #DCD3C4; padding: 1rem; border-radius: 3px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                            <span style="font-size: 0.625rem; font-family: 'JetBrains Mono', monospace; font-weight: 800; text-transform: uppercase; color: <?php echo $notif['type'] === 'editorial' ? '#0B5128' : '#8B2500'; ?>;">
                                <?php echo esc_html(strtoupper($notif['type'])); ?> ALERT
                            </span>
                            <span style="font-size: 0.6875rem; color: #8C847A; font-family: 'JetBrains Mono', monospace;">
                                <?php echo esc_html($notif['time']); ?>
                            </span>
                        </div>

                        <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.05rem; font-weight: 700; color: #171513; margin: 0 0 0.35rem; line-height: 1.3;">
                            <?php if (!empty($notif['link'])) : ?>
                                <a href="<?php echo esc_url($notif['link']); ?>"><?php echo esc_html($notif['title']); ?></a>
                            <?php else : ?>
                                <?php echo esc_html($notif['title']); ?>
                            <?php endif; ?>
                        </h3>

                        <p style="font-size: 0.8125rem; color: #5C564E; margin: 0; line-height: 1.5; font-family: 'Plus Jakarta Sans', sans-serif;">
                            <?php echo esc_html($notif['message']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div style="text-align: center; padding: 2rem; color: #8C847A; font-size: 0.875rem;">
                    No new notifications. You are caught up with all continental dispatches.
                </div>
            <?php endif; ?>
        </div>

        <!-- Notification Preferences -->
        <div style="border-top: 2px solid #231F1D; padding-top: 1.25rem;">
            <h3 style="font-family: 'Playfair Display', Georgia, serif; font-size: 1.15rem; font-weight: 900; color: #171513; margin: 0 0 0.75rem;">
                Alert Preferences
            </h3>
            <div style="display: flex; flex-direction: column; gap: 0.75rem; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.8125rem;">
                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.5rem; background: #FFFFFF; border: 1px solid #DCD3C4; border-radius: 2px; cursor: pointer;">
                    <span>📲 Browser Push Alerts for Breaking Investigations</span>
                    <input type="checkbox" checked style="accent-color: #8B2500;" />
                </label>
                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.5rem; background: #FFFFFF; border: 1px solid #DCD3C4; border-radius: 2px; cursor: pointer;">
                    <span>📍 Localized Regional Alerts (Matching Your Auto-Location)</span>
                    <input type="checkbox" checked style="accent-color: #8B2500;" />
                </label>
                <label style="display: flex; align-items: center; justify-content: space-between; padding: 0.5rem; background: #FFFFFF; border: 1px solid #DCD3C4; border-radius: 2px; cursor: pointer;">
                    <span>✉ The Africa Brief Thursday Wire</span>
                    <input type="checkbox" checked style="accent-color: #8B2500;" />
                </label>
            </div>
        </div>

    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const markReadBtn = document.getElementById('btn-mark-all-read');
    if (markReadBtn) {
        markReadBtn.addEventListener('click', async () => {
            markReadBtn.disabled = true;
            markReadBtn.textContent = 'Updating...';

            const formData = new FormData();
            formData.append('action', 'magazineafrique_mark_notifications_read');
            formData.append('nonce', window.magazineafrique_vars?.nonce || '');

            try {
                const res = await fetch(window.magazineafrique_vars.ajax_url, {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                if (data.success) {
                    const badge = document.getElementById('notif-badge-count');
                    if (badge) badge.remove();
                    document.querySelectorAll('#notifications-list > div').forEach(card => {
                        card.style.backgroundColor = '#FAF6F0';
                    });
                    markReadBtn.textContent = '✓ All Read';
                }
            } catch (e) {
                markReadBtn.disabled = false;
                markReadBtn.textContent = 'Retry';
            }
        });
    }
});
</script>

<?php get_footer(); ?>

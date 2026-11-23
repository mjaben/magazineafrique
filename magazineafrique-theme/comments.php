<?php
/**
 * Magazine Afrique — Editorial Commentary Template
 * Archival Broadside Reader Dispatches & Discourse
 *
 * @package MagazineAfrique
 */

if (post_password_required()) {
    return;
}
?>

<section id="comments" class="comments-area-editorial">

    <div class="comments-header-row">
        <h3 class="comments-title">
            READER DISPATCHES &amp; COMMENTARY
            <?php if (get_comments_number() > 0) : ?>
                <span class="comments-count-badge"><?php echo get_comments_number(); ?></span>
            <?php endif; ?>
        </h3>
        <span class="comments-edition-tag">COMMUNITY INTELLIGENCE · VERIFIED</span>
    </div>

    <?php if (have_comments()) : ?>
        <ol class="editorial-comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 44,
            ));
            ?>
        </ol>

        <?php the_comments_navigation(); ?>
    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments-note">Dispatch wire is closed for this report.</p>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    $fields = array(
        'author' => '<div class="comment-field-group"><label for="author" class="editorial-comment-label">NAME *</label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" class="editorial-comment-input"' . $aria_req . ' placeholder="Your full name" required /></div>',
        'email'  => '<div class="comment-field-group"><label for="email" class="editorial-comment-label">WORK EMAIL *</label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" class="editorial-comment-input"' . $aria_req . ' placeholder="Your work or personal email" required /></div>',
    );

    $comments_args = array(
        'fields'               => $fields,
        'title_reply'          => 'LEAVE A COMMENTARY',
        'title_reply_to'       => 'REPLY TO %s',
        'cancel_reply_link'    => 'Cancel Reply',
        'label_submit'         => 'Post Commentary →',
        'class_submit'         => 'editorial-comment-submit',
        'comment_notes_before' => '<p class="comment-notes-info">Contribute strategic analysis and discourse to the Gazette record. Required fields are marked *</p>',
        'comment_notes_after'  => '',
        'comment_field'        => '<div class="comment-field-group comment-field-textarea"><label for="comment" class="editorial-comment-label">YOUR DISPATCH *</label><textarea id="comment" name="comment" cols="45" rows="4" class="editorial-comment-textarea" aria-required="true" placeholder="Share your perspective, context, or critical analysis..." required></textarea></div>',
    );

    comment_form($comments_args);
    ?>

</section>

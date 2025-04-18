<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>

<?php if ($rsvps): ?>
    <div class="rsvp-comments-list">
        <?php foreach ($rsvps as $rsvp): ?>
            <div class="rsvp-comments-list-item">
                <div class="rsvp-comments-list-item-title item-title">
                    <?php echo esc_html($rsvp->name); ?> (<?php echo esc_html($rsvp->attendance); ?>)
                </div>
                <div class="rsvp-comments-list-item-message item-message">
                    <?php echo esc_html($rsvp->message); ?>
                </div>
                <div class="rsvp-comments-list-item-date item-date">
                    <?php echo date('F j, Y, g:i a', strtotime($rsvp->submitted_at)); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($total_pages > 1): ?>
        <div class="rsvp-pagination pagination-style">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="#" data-page="<?php echo $i; ?>" class="rsvp-page-link pagination-link"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p class="no-rsvp-message">No RSVPs yet. Be the first to RSVP!</p>
<?php endif; ?>
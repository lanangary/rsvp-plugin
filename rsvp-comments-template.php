<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>

<?php if ($rsvps): ?>
    <div class="rsvp-comments-list">
        <?php foreach ($rsvps as $rsvp): ?>
            <div class="rsvp-comments-list-item">
                <div class="rsvp-comments-list-item-title">
                    <?php echo esc_html($rsvp->name); ?> - (<?php echo esc_html($rsvp->attendance); ?>)
                </div>
                <div class="rsvp-comments-list-item-message">
                    <?php echo esc_html($rsvp->message); ?>
                </div>
                <div class="rsvp-comments-list-item-date">
                    <?php echo date('F j, Y, g:i a', strtotime($rsvp->submitted_at)); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($total_pages > 1): ?>
        <div class="rsvp-pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="#" data-page="<?php echo $i; ?>" class="rsvp-page-link"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p>No RSVPs yet. Be the first to RSVP!</p>
<?php endif; ?>
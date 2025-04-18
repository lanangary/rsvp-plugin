<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly ?>

<?php if ($rsvps): ?>
    <div class="rsvp-comments-list">
        <?php foreach ($rsvps as $rsvp):
                // var_dump($settings['icon_type']); // Debugging line to check the $rsvp object
            ?>
        
            <div class="rsvp-comments-list-item">
                <div class="rsvp-comments-list-item-section">
                <?php if ($settings['enable_icon'] == 'yes'): ?>
                    <div class="rsvp-comments-list-item-icon">
                        <?php if ($settings['icon_type'] == 'icon' && !empty($settings['icon']['value'])): ?>
                            <i class="<?php echo esc_attr($settings['icon']['value']); ?>"></i>
                        <?php elseif ($settings['icon_type'] == 'image'): ?>
                            <img src="<?php echo esc_url($settings['icon']['value']); ?>" alt="Comment Icon">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                </div>
                <div class="rsvp-comments-list-item-section">
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
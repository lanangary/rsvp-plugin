<?php
/*
Plugin Name: Wedding RSVP and Wishes
Description: A simple plugin for wedding guests to RSVP and leave messages.
Version: 1.0
Author: Your Name
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the Elementor widget file when Elementor is loaded
function register_rsvp_widget()
{
    if (did_action('elementor/loaded')) {
        require_once(__DIR__ . '/rsvp-elementor-widget.php');
        require_once(__DIR__ . '/rsvp-counts-elementor-widget.php');
        require_once(__DIR__ . '/rsvp-comments-elementor-widget.php');
    }
}
add_action('elementor/widgets/widgets_registered', 'register_rsvp_widget');

// Register the custom database table for RSVPs
function create_rsvp_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'wedding_rsvp';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        page_id bigint(20) NOT NULL,
        name tinytext NOT NULL,
        attendance tinytext NOT NULL,
        message text NOT NULL,
        submitted_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('wedding_rsvp_db_version', '1.0');
}
register_activation_hook(__FILE__, 'create_rsvp_table');



// Shortcode to display the RSVP form and comments
function display_rsvp_form($atts)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'wedding_rsvp';
    $page_id = get_the_ID();

    // Get RSVP counts
    $count_hadir = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE attendance = 'Hadir' AND page_id = %d",
        $page_id
    ));
    $count_tidak_hadir = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE attendance = 'Tidak Hadir' AND page_id = %d",
        $page_id
    ));
    $count_masih_ragu = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE attendance = 'Masih Ragu' AND page_id = %d",
        $page_id
    ));
    $total_comments = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE page_id = %d",
        $page_id
    ));

    ob_start();
?>
    <div class="module-rsvp">
        <div class="rsvp-wrap">
            <div class="rsvp-header"></div>

      
            <div class="rsvp-form">
                <form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
                    <input type="hidden" name="rsvp_form_submitted" value="1">
                    <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">

                    <input type="text" id="name" name="name" placeholder="Nama" required>

                    <select id="attendance" name="attendance" required>
                        <option value="">Konfirmasi Kehadiran</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Tidak Hadir">Tidak Hadir</option>
                        <option value="Masih Ragu">Ragu</option>
                    </select>

                    <textarea id="message" name="message" placeholder="Ucapan"></textarea>

                    <input class="rsvp-submit" type="submit" name="submit_rsvp" value="Submit">
                </form>
            </div>
        </div>
    </div>

<?php
  
    return ob_get_clean();
}
add_shortcode('rsvp_form', 'display_rsvp_form');






// Handle form submissions
function handle_rsvp_form()
{
    if (isset($_POST['rsvp_form_submitted'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'wedding_rsvp';

        $name = sanitize_text_field($_POST['name']);
        $attendance = sanitize_text_field($_POST['attendance']);
        $message = sanitize_textarea_field($_POST['message']);
        $page_id = intval($_POST['page_id']);

        $inserted = $wpdb->insert(
            $table_name,
            array(
                'page_id' => $page_id,
                'name' => $name,
                'attendance' => $attendance,
                'message' => $message,
                'submitted_at' => current_time('mysql')
            )
        );

        // Debugging: Log errors
        if ($inserted === false) {
            error_log('Failed to insert RSVP data: ' . $wpdb->last_error);
            echo '<p>There was an error submitting your RSVP. Please try again. Check the error log for details.</p>';
        } else {
            echo '<script type="text/javascript">window.location.href="' . esc_url($_SERVER['REQUEST_URI']) . '";</script>';
            exit;
        }
    }
}
add_action('init', 'handle_rsvp_form');


function load_rsvp_comments_ajax()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'wedding_rsvp';

    $page_id = intval($_POST['post_id']);
    $page = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1;
    $limit = 6;
    $offset = ($page - 1) * $limit;

    $rsvps = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name WHERE page_id = %d ORDER BY submitted_at DESC LIMIT %d OFFSET %d",
        $page_id,
        $limit,
        $offset
    ));

    $total_comments = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE page_id = %d",
        $page_id
    ));

    $total_pages = ceil($total_comments / $limit);

    // Include the template file
    include __DIR__ . '/rsvp-comments-template.php';

    wp_die();
}

add_action('wp_ajax_load_rsvp_comments', 'load_rsvp_comments_ajax');
add_action('wp_ajax_nopriv_load_rsvp_comments', 'load_rsvp_comments_ajax');


?>
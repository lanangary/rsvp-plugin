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

// Enqueue plugin styles
function rsvp_plugin_enqueue_styles() {
    wp_enqueue_style(
        'rsvp-plugin-styles', // Handle for the stylesheet
        plugin_dir_url(__FILE__) . 'assets/css/style.css', // Path to the CSS file
        [], // Dependencies (if any)
        '1.0', // Version number
        'all' // Media type
    );
}
add_action('wp_enqueue_scripts', 'rsvp_plugin_enqueue_styles');

// Shortcode to display the RSVP form and comments
function display_rsvp_form($atts)
{
    global $wpdb;
    $page_id = get_the_ID();

    // Extract the success message from the shortcode attributes
    $atts = shortcode_atts(
        [
            'success_message' => 'Thank you for your RSVP!',
        ],
        $atts
    );

    $success_message = $atts['success_message'];

    ob_start();
?>
    <div class="module-rsvp">
        <div class="rsvp-wrap">
            <div class="rsvp-header"></div>

            <div class="rsvp-form">
                <form id="rsvp-form" method="post">
                    <input type="hidden" name="action" value="submit_rsvp_form">
                    <input type="hidden" name="page_id" value="<?php echo $page_id; ?>">

                    <input type="text" id="name" name="name" placeholder="Nama" required>

                    <select id="attendance" name="attendance" required>
                        <option value="">Konfirmasi Kehadiran</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Tidak Hadir">Tidak Hadir</option>
                        <option value="Masih Ragu">Ragu</option>
                    </select>

                    <textarea id="message" name="message" placeholder="Ucapan"></textarea>

                    <input class="rsvp-submit" type="submit" value="Submit">
                </form>
                <div id="rsvp-success-message" style="display: none;"><?php echo esc_html($success_message); ?></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#rsvp-form').on('submit', function (e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: "POST",
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('#rsvp-form').hide();
                            $('#rsvp-success-message').html(response.data).show();
                        } else {
                            alert('Error: ' + response.data);
                        }
                    },
                    error: function () {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('rsvp_form', 'display_rsvp_form');

// Handle form submissions
function submit_rsvp_form_ajax()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'wedding_rsvp';

    $name = sanitize_text_field($_POST['name']);
    $attendance = sanitize_text_field($_POST['attendance']);
    $message = sanitize_textarea_field($_POST['message']);
    $page_id = intval($_POST['page_id']);

    if (empty($name) || empty($attendance)) {
        wp_send_json_error('Name and attendance are required.');
    }

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

    if ($inserted === false) {
        wp_send_json_error('Failed to submit RSVP. Please try again.');
    } else {
        // Dynamically fetch the success message from the widget settings
        $widget_id = $_POST['widget_id'] ?? null; // Pass the widget ID from the form
        $success_message = 'Thank you!'; // Default message

        if ($widget_id) {
            $elementor_data = get_post_meta($page_id, '_elementor_data', true);
            if ($elementor_data) {
                $elementor_data = json_decode($elementor_data, true);
                foreach ($elementor_data as $widget) {
                    if ($widget['id'] === $widget_id && isset($widget['settings']['rsvp_success_message'])) {
                        $success_message = $widget['settings']['rsvp_success_message'];
                        break;
                    }
                }
            }
        }

        wp_send_json_success($success_message);
    }
}

add_action('wp_ajax_submit_rsvp_form', 'submit_rsvp_form_ajax');
add_action('wp_ajax_nopriv_submit_rsvp_form', 'submit_rsvp_form_ajax');

function load_rsvp_comments_ajax()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'wedding_rsvp';

    $page_id = intval($_POST['post_id']);
    $icon_value = isset($_POST['icon_value']) ? sanitize_text_field($_POST['icon_value']) : 'fas fa-star'; // Default icon value
    $the_type = isset($_POST['icon_type']) ? sanitize_text_field($_POST['icon_type']) : 'icon'; // Default icon type
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
    
    // Get widget settings
    $settings = isset($_POST['settings']) ? json_decode(stripslashes($_POST['settings']), true) : [];
   
    $settings['enable_icon'] = isset($settings['enable_icon']) ? $settings['enable_icon'] : 'yes';
    $settings['icon_type'] = $the_type; 
    $settings['icon'] = isset($settings['icon']) ? $settings['icon'] : ['value' => $icon_value]; // Default icon
    // var_dump($the_type); // Debugging line to check the $settings array
    // Include the template file and pass the settings
    include __DIR__ . '/template/rsvp-comments-template.php';

    wp_die();
}

add_action('wp_ajax_load_rsvp_comments', 'load_rsvp_comments_ajax');
add_action('wp_ajax_nopriv_load_rsvp_comments', 'load_rsvp_comments_ajax');

?>
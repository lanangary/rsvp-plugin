<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Elementor_RSVP_Counts_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'rsvp_counts_widget';
    }

    public function get_title()
    {
        return __('RSVP Counts', 'wedding-rsvp-wishes');
    }

    public function get_icon()
    {
        return 'eicon-counter';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function _register_controls()
    {
        // Visibility Section
        $this->start_controls_section(
            'section_visibility',
            [
                'label' => __('Visibility', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_total',
            [
                'label' => __('Show Total Ucapan Count', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'wedding-rsvp-wishes'),
                'label_off' => __('Hide', 'wedding-rsvp-wishes'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_hadir',
            [
                'label' => __('Show Hadir Count', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'wedding-rsvp-wishes'),
                'label_off' => __('Hide', 'wedding-rsvp-wishes'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_tidak_hadir',
            [
                'label' => __('Show Tidak Hadir Count', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'wedding-rsvp-wishes'),
                'label_off' => __('Hide', 'wedding-rsvp-wishes'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_ragu',
            [
                'label' => __('Show Ragu Count', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'wedding-rsvp-wishes'),
                'label_off' => __('Hide', 'wedding-rsvp-wishes'),
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .rsvp-count',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rsvp-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_alignment',
            [
                'label' => __('Alignment', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'wedding-rsvp-wishes'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'wedding-rsvp-wishes'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'wedding-rsvp-wishes'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rsvp-count' => 'text-align: {{VALUE}};',
                ],
                'default' => 'center',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        global $wpdb;
        $settings = $this->get_settings_for_display();

        $table_name = $wpdb->prefix . 'wedding_rsvp';
        $page_id = get_the_ID();

        // Fetch counts
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

        // Render only the numbers
        echo '<div class="rsvp-counts-widget">';
        if ($settings['show_total'] === 'yes') {
            echo '<div class="rsvp-count">' . esc_html($total_comments) . '</div>';
        }
        if ($settings['show_hadir'] === 'yes') {
            echo '<div class="rsvp-count">' . esc_html($count_hadir) . '</div>';
        }
        if ($settings['show_tidak_hadir'] === 'yes') {
            echo '<div class="rsvp-count">' . esc_html($count_tidak_hadir) . '</div>';
        }
        if ($settings['show_ragu'] === 'yes') {
            echo '<div class="rsvp-count">' . esc_html($count_masih_ragu) . '</div>';
        }
        echo '</div>';
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_RSVP_Counts_Widget());
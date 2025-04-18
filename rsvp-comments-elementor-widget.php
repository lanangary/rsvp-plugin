<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Elementor_RSVP_Comments_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'rsvp_comments_widget';
    }

    public function get_title()
    {
        return __('RSVP Comments', 'wedding-rsvp-wishes');
    }

    public function get_icon()
    {
        return 'eicon-comments';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function _register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'comments_title',
            [
                'label' => __('Comments Title', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('RSVP Comments', 'wedding-rsvp-wishes'),
            ]
        );

        $this->end_controls_section();

        // Icon Settings Section
        $this->start_controls_section(
            'section_icon_settings',
            [
                'label' => __('Icon Settings', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'enable_icon',
            [
                'label' => __('Enable Icon', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'wedding-rsvp-wishes'),
                'label_off' => __('No', 'wedding-rsvp-wishes'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'icon_type',
            [
                'label' => __('Icon Type', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => __('Font Icon', 'wedding-rsvp-wishes'),
                    'image' => __('Image', 'wedding-rsvp-wishes'),
                ],
                'condition' => [
                    'enable_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Icon', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
                'condition' => [
                    'enable_icon' => 'yes',
                    'icon_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'icon_image',
            [
                'label' => __('Icon Image', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'enable_icon' => 'yes',
                    'icon_type' => 'image',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section for Item Title
        $this->start_controls_section(
            'section_style_item_title',
            [
                'label' => __('Item Title', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .item-title',
            ]
        );

        $this->add_control(
            'item_title_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .item-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_title_margin',
            [
                'label' => __('Margin', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section for Item Message
        $this->start_controls_section(
            'section_style_item_message',
            [
                'label' => __('Item Message', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_message_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .item-message',
            ]
        );

        $this->add_control(
            'item_message_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .item-message' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_message_margin',
            [
                'label' => __('Margin', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .item-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section for Item Date
        $this->start_controls_section(
            'section_style_item_date',
            [
                'label' => __('Item Date', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_date_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .item-date',
            ]
        );

        $this->add_control(
            'item_date_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .item-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_date_margin',
            [
                'label' => __('Margin', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .item-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section for Pagination
        $this->start_controls_section(
            'section_style_pagination',
            [
                'label' => __('Pagination', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'pagination_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .pagination-style',
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pagination-style' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_margin',
            [
                'label' => __('Margin', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pagination-style' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $icon_value = $settings['icon'] != NULL ? $settings['icon']['value'] : $settings['icon_image']['url'];
        // var_dump($settings['icon_type']); // Debugging line to check the $settings object
        // var_dump($icon_value); // Debugging line to check the $settings object
        // Render the comments section
        echo '<div class="rsvp-comments-widget">';
        echo '<div id="rsvp-comments">';
        echo '<p>Loading comments...</p>';
        echo '</div>';
        echo '<script type="text/javascript">
            jQuery(document).ready(function($) {
                function loadRSVPComments(page) {
                    $.ajax({
                        url: "' . admin_url('admin-ajax.php') . '",
                        type: "POST",
                        data: {
                            action: "load_rsvp_comments",
                            page: page,
                            post_id: ' . get_the_ID() . ',
                            icon_value: "' . esc_js($icon_value) . '",
                            icon_type: "' . esc_js($settings['icon_type']) . '",
                           
                        },
                        success: function(response) {
                            $("#rsvp-comments").html(response);
                        }
                    });
                }

                // Load first page
                loadRSVPComments(1);

                // Handle pagination click
                $(document).on("click", ".rsvp-pagination a", function(e) {
                    e.preventDefault();
                    var page = $(this).data("page");
                    loadRSVPComments(page);
                });
            });
        </script>';
        echo '</div>';
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_RSVP_Comments_Widget());
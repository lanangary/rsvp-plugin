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
                'name' => 'comments_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} #rsvp-comments',
            ]
        );

        $this->add_control(
            'comments_text_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #rsvp-comments' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'comments_alignment',
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
                    '{{WRAPPER}} #rsvp-comments' => 'text-align: {{VALUE}};',
                ],
                'default' => 'left',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
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
                            post_id: ' . get_the_ID() . '
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
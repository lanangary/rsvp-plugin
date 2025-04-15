<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Elementor_RSVP_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'rsvp_widget';
    }

    public function get_title()
    {
        return __('RSVP Form', 'wedding-rsvp-wishes');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
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
            'rsvp_comments_title',
            [
                'label' => __('RSVP Comments Title', 'wedding-rsvp-wishes'),
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
                'name' => 'form_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .rsvp-form',
            ]
        );

        $this->add_control(
            'form_text_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_alignment',
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
                    '{{WRAPPER}} .rsvp-form' => 'text-align: {{VALUE}};',
                ],
                'default' => 'left',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $rsvp_comments_title = !empty($settings['rsvp_comments_title']) ? $settings['rsvp_comments_title'] : 'RSVP Comments';

        // Render the RSVP form without the counter
        echo '<div class="rsvp-form">';
        echo '<h2>' . esc_html($rsvp_comments_title) . '</h2>';
        echo do_shortcode('[rsvp_form]');
        echo '</div>';
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_RSVP_Widget());
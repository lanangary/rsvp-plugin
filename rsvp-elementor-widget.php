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
                'label' => __('RSVP Form Title', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('RSVP Form', 'wedding-rsvp-wishes'),
            ]
        );

        $this->add_control(
            'rsvp_success_message',
            [
                'label' => __('Success Message', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Thank you for your RSVP!', 'wedding-rsvp-wishes'),
            ]
        );

        $this->end_controls_section();

        // Style Section for Form
        $this->start_controls_section(
            'section_style_form',
            [
                'label' => __('Form Style', 'wedding-rsvp-wishes'),
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

        // Style Section for Form Fields
        $this->start_controls_section(
            'section_style_form_fields',
            [
                'label' => __('Form Fields', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'form_fields_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .rsvp-form input, {{WRAPPER}} .rsvp-form select, {{WRAPPER}} .rsvp-form textarea',
            ]
        );

        $this->add_control(
            'form_fields_text_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form input, {{WRAPPER}} .rsvp-form select, {{WRAPPER}} .rsvp-form textarea' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'form_fields_background_color',
            [
                'label' => __('Background Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form input, {{WRAPPER}} .rsvp-form select, {{WRAPPER}} .rsvp-form textarea' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_fields_padding',
            [
                'label' => __('Padding', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form input, {{WRAPPER}} .rsvp-form select, {{WRAPPER}} .rsvp-form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_fields_margin',
            [
                'label' => __('Margin', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form input, {{WRAPPER}} .rsvp-form select, {{WRAPPER}} .rsvp-form textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'form_fields_border',
                'label' => __('Border', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .rsvp-form input, {{WRAPPER}} .rsvp-form select, {{WRAPPER}} .rsvp-form textarea',
            ]
        );

        $this->add_responsive_control(
            'form_fields_border_radius',
            [
                'label' => __('Border Radius', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form input, {{WRAPPER}} .rsvp-form select, {{WRAPPER}} .rsvp-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section for Success Message
        $this->start_controls_section(
            'section_style_success_message',
            [
                'label' => __('Success Message Style', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'success_message_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} #rsvp-success-message',
            ]
        );

        $this->add_control(
            'success_message_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} #rsvp-success-message' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'success_message_margin',
            [
                'label' => __('Margin', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} #rsvp-success-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'success_message_alignment',
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
                    '{{WRAPPER}} #rsvp-success-message' => 'text-align: {{VALUE}};',
                ],
                'default' => 'center',
            ]
        );

        $this->end_controls_section();

        // Style Section for Submit Button
        $this->start_controls_section(
            'section_style_submit_button',
            [
                'label' => __('Submit Button', 'wedding-rsvp-wishes'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submit_button_typography',
                'label' => __('Typography', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .rsvp-form .rsvp-submit',
            ]
        );

        $this->add_control(
            'submit_button_text_color',
            [
                'label' => __('Text Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form .rsvp-submit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submit_button_background_color',
            [
                'label' => __('Background Color', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form .rsvp-submit' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'submit_button_padding',
            [
                'label' => __('Padding', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form .rsvp-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'submit_button_margin',
            [
                'label' => __('Margin', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form .rsvp-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'submit_button_border',
                'label' => __('Border', 'wedding-rsvp-wishes'),
                'selector' => '{{WRAPPER}} .rsvp-form .rsvp-submit',
            ]
        );

        $this->add_responsive_control(
            'submit_button_border_radius',
            [
                'label' => __('Border Radius', 'wedding-rsvp-wishes'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .rsvp-form .rsvp-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $success_message = !empty($settings['rsvp_success_message']) ? $settings['rsvp_success_message'] : 'Thank you!';

        // Render the RSVP form with the success message passed as a shortcode attribute
        echo '<div class="rsvp-form">';
        echo do_shortcode('[rsvp_form success_message="' . esc_attr($success_message) . '"]');
        echo '</div>';
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_RSVP_Widget());
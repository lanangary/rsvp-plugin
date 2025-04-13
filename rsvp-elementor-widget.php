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
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Title', 'wedding-rsvp-wishes'),
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
    }



    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $rsvp_comments_title = !empty($settings['rsvp_comments_title']) ? $settings['rsvp_comments_title'] : 'RSVP Comments';

        echo do_shortcode('[rsvp_form rsvp_title="' . esc_attr($rsvp_comments_title) . '"]');
    }
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_RSVP_Widget());

<?php

class Elementor_FIFU_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'fifu-elementor';
    }

    public function get_title() {
        return __('Featured Image from URL', 'elementor-fifu-extension');
    }

    public function get_icon() {
        return 'eicon-featured-image';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
                'content_section_image',
                [
                    'label' => __('External image', 'elementor-fifu-extension'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'fifu_input_url',
                [
                    'label' => __('Image URL', 'elementor-fifu-extension'),
                    'show_label' => true,
                    'label_block' => true,
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'input_type' => 'url',
                    'placeholder' => __('https://site.com/image.jpg', 'elementor-fifu-extension'),
                ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
                'content_section2',
                [
                    'label' => __('FAQ', 'elementor-fifu-extension'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
        );
        $this->add_control(
                'faq2',
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('<b><i>How to use the first image as featured image?</i></b><br>1) access Featured Image from URL settings;<br>2) enable Content URL >  use the 1st image as featured image.<br>', 'plugin-name'),
                ]
        );
        $this->add_control(
                'faq3',
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => __('<b><i>I created a grid of images. How to have all with the same height?</i></b><br>1) access Featured Image from URL settings;<br>2) enable Featured image > Same Height;<br>3) add the selector "div.elementor-row".', 'plugin-name'),
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $image_url = $settings['fifu_input_url'];
        if ($image_url) {
            $image_url = fifu_convert($image_url);
            echo '<div style="width:100%;text-align:center;"><img class="oembed-elementor-widget fifu-elementor-image" src="' . $image_url . '"/></div>';
        }
    }

}


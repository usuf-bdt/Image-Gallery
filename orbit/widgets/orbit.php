<?php

namespace PrimeSliderPro\Modules\Orbit\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) {
    exit;
}

class Orbit extends Widget_Base
{

    public function get_name()
    {
        return 'prime-slider-orbit';
    }

    public function get_title()
    {
        return BDTPS . esc_html__('Orbit', 'bdthemes-prime-slider');
    }

    public function get_icon()
    {
        return 'bdt-widget-icon ps-wi-orbit';
    }

    public function get_categories()
    {
        return ['prime-slider-pro'];
    }

    public function get_keywords()
    {
        return ['prime slider', 'slider', 'orbit', 'prime'];
    }

    public function get_style_depends()
    {
        return ['prime-slider-font', 'ps-orbit'];
    }

    public function get_script_depends()
    {
        return ['gsap', 'ps-orbit'];
    }

    public function get_custom_help_url() {
		return 'https://primeslider.pro/';
	}

    protected function register_controls()
    {
        $this->start_controls_section(
            'orbit_layout_settings',
            [
                'label' => esc_html__('Layout', 'bdthemes-prime-slider'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'orbit_items',
            [
                'label' => esc_html__('Set Items', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'orbit_image',
                        'label' => esc_html__('Image', 'bdthemes-prime-slider'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'dynamic' => ['active' => true],
                    ],
                    [
                        'name' => 'orbit_title',
                        'label' => esc_html__('Title', 'bdthemes-prime-slider'),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__('Title', 'bdthemes-prime-slider'),
                        'label_block' => true,
                        'dynamic' => ['active' => true],
                    ],
                    [
                        'name' => 'orbit_description',
                        'label' => esc_html__('Description', 'bdthemes-prime-slider'),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => esc_html__('Item description. Click here to change this description.', 'bdthemes-prime-slider'),
                        'dynamic' => ['active' => true],
                    ],
                    [
                        'name' => 'orbit_url',
                        'label' => esc_html__('Button Link', 'bdthemes-prime-slider'),
                        'type' => Controls_Manager::URL,
                        'dynamic' => ['active' => true],
                        'show_external' => true,
                        'default' => [
                            'url' => 'https://example.com',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ]
                ],
                'default' => [
                    [
                        'orbit_title' => esc_html__('Title #1', 'bdthemes-prime-slider'),
                        'orbit_description' => esc_html__('Item description. Click here to change this description.', 'bdthemes-prime-slider'),
                        'orbit_image' => [
                            'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg'
                        ],
                        'orbit_url' => [
                            'url' => 'https://example.com',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'orbit_title' => esc_html__('Title #2', 'bdthemes-prime-slider'),
                        'orbit_description' => esc_html__('Item description. Click here to change this description.', 'bdthemes-prime-slider'),
                        'orbit_image' => [
                            'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-2.svg'
                        ],
                        'orbit_url' => [
                            'url' => 'https://example.com',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'orbit_title' => esc_html__('Title #3', 'bdthemes-prime-slider'),
                        'orbit_description' => esc_html__('Item description. Click here to change this description.', 'bdthemes-prime-slider'),
                        'orbit_image' => [
                            'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-3.svg'
                        ],
                        'orbit_url' => [
                            'url' => 'https://example.com',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'orbit_title' => esc_html__('Title #4', 'bdthemes-prime-slider'),
                        'orbit_description' => esc_html__('Item description. Click here to change this description.', 'bdthemes-prime-slider'),
                        'orbit_image' => [
                            'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg'
                        ],
                        'orbit_url' => [
                            'url' => 'https://example.com',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'orbit_title' => esc_html__('Title #5', 'bdthemes-prime-slider'),
                        'orbit_description' => esc_html__('Item description. Click here to change this description.', 'bdthemes-prime-slider'),
                        'orbit_image' => [
                            'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg'
                        ],
                        'orbit_url' => [
                            'url' => 'https://example.com',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'orbit_title' => esc_html__('Title #6', 'bdthemes-prime-slider'),
                        'orbit_description' => esc_html__('Item content. Click the edit button to change this description.', 'bdthemes-prime-slider'),
                        'orbit_image' => [
                            'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-6.svg'
                        ],
                        'orbit_url' => [
                            'url' => 'https://example.com',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'orbit_title' => esc_html__('Title #7', 'bdthemes-prime-slider'),
                        'orbit_description' => esc_html__('Item description. Click here to change this description.', 'bdthemes-prime-slider'),
                        'orbit_image' => [
                            'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-7.svg'
                        ],
                        'orbit_url' => [
                            'url' => 'https://example.com',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                    [
                        'orbit_title' => esc_html__('Title #8', 'bdthemes-prime-slider'),
                        'orbit_description' => esc_html__('Item description. Click here to change this description.', 'bdthemes-prime-slider'),
                        'orbit_image' => [
                            'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-8.svg'
                        ],
                        'orbit_url' => [
                            'url' => 'https://example.com',
                            'is_external' => false,
                            'nofollow' => false,
                        ],
                    ],
                ],
                'title_field' => '{{{ orbit_title }}}',
            ]
        );

        $this->add_control(
            'orbit_center_image',
            [
                'label' => esc_html__('Center Image', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-2.svg'
                ],
                'dynamic' => ['active' => true],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'modal_button_section',
            [
                'label' => esc_html__('Button', 'bdthemes-prime-slider'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'orbit_button_text',
            [
                'label'       => esc_html__('Button Text', 'bdthemes-prime-slider'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter button text', 'bdthemes-prime-slider'),
                'dynamic'     => ['active' => true],
                'default'     => esc_html__('Read more', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_selected_icon',
            [
                'label' => esc_html__('Icon', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'label_block' => false,
            ]
        );

        $this->add_control(
            'orbit_icon_position',
            [
                'label' => esc_html__('Icon Position', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::CHOOSE,
                'options'   => [
                    'before'  => [
                        'title' => esc_html__('Left', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'after' => [
                        'title' => esc_html__('Right', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'before',
                'condition'  => [
                    'orbit_selected_icon[value]!' => '',
                ]
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'orbit_rotation_controls',
            [
                'label' => esc_html__('Rotation Controls', 'bdthemes-prime-slider'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'orbit_rotation_speed',
            [
                'label' => esc_html__('Speed (s)', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 5,
                        'max' => 60,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 30,
                ],
                'description' => esc_html__('Set how many seconds for a full rotation.', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_rotation_direction',
            [
                'label' => esc_html__('Direction', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'clockwise' => esc_html__('Clockwise', 'bdthemes-prime-slider'),
                    'counterclockwise' => esc_html__('Anti-Clockwise', 'bdthemes-prime-slider'),
                ],
                'default' => 'clockwise',
            ]
        );

        $this->add_control(
            'orbit_rotation_control',
            [
                'label' => esc_html__('Enable Rotation', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'loop' => esc_html__('Yes', 'bdthemes-prime-slider'),
                    'no-loop' => esc_html__('No', 'bdthemes-prime-slider'),
                ],
                'default' => 'loop',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'orbit_style_settings',
            [
                'label' => esc_html__('Center Image', 'bdthemes-prime-slider'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'orbit_center_image_width',
            [
                'label' => esc_html__('Width', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-center-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_center_image_height',
            [
                'label' => esc_html__('Height', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-center-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_center_image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'orbit_center_image_height[size]!' => '',
                ],
                'options' => [
                    '' => esc_html__('Default', 'bdthemes-prime-slider'),
                    'fill' => esc_html__('Fill', 'bdthemes-prime-slider'),
                    'cover' => esc_html__('Cover', 'bdthemes-prime-slider'),
                    'contain' => esc_html__('Contain', 'bdthemes-prime-slider'),
                    'scale-down' => esc_html__('Scale Down', 'bdthemes-prime-slider'),
                ],
                'default' => '',
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-center-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_center_image_object_position',
            [
                'label' => esc_html__('Object Position', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__('Center Center', 'bdthemes-prime-slider'),
                    'center left' => esc_html__('Center Left', 'bdthemes-prime-slider'),
                    'center right' => esc_html__('Center Right', 'bdthemes-prime-slider'),
                    'top center' => esc_html__('Top Center', 'bdthemes-prime-slider'),
                    'top left' => esc_html__('Top Left', 'bdthemes-prime-slider'),
                    'top right' => esc_html__('Top Right', 'bdthemes-prime-slider'),
                    'bottom center' => esc_html__('Bottom Center', 'bdthemes-prime-slider'),
                    'bottom left' => esc_html__('Bottom Left', 'bdthemes-prime-slider'),
                    'bottom right' => esc_html__('Bottom Right', 'bdthemes-prime-slider'),
                ],
                'default' => 'center center',
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-center-image img' => 'object-position: {{VALUE}};',
                ],
                'condition' => [
                    'orbit_center_image_height[size]!' => '',
                    'orbit_center_image_object_fit' => ['cover', 'contain', 'scale-down'],
                ],
            ]
        );

        $this->start_controls_tabs('orbit_center_image_effects');
        $this->start_controls_tab(
            'orbit_center_image_normal',
            [
                'label' => esc_html__('Normal', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_center_image_opacity',
            [
                'label' => esc_html__('Opacity', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-center-image' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .ps-orbit-center-image',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'orbit_center_image_border',
                'selector' => '{{WRAPPER}} .ps-orbit-center-image',
            ]
        );

        $this->add_responsive_control(
            'orbit_center_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-center-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_center_image_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .ps-orbit-center-image',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'orbit_center_image_hover',
            [
                'label' => esc_html__('Hover', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_center_image_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-center-image:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .ps-orbit-center-image:hover',
            ]
        );

        $this->add_control(
            'orbit_center_image_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-center-image:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'orbit_center_image_border_border!' => ['none', ''],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_center_image_box_shadow_hover',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .ps-orbit-center-image:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'orbit_style_items',
            [
                'label' => esc_html__('Items', 'bdthemes-prime-slider'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'orbit_item_width',
            [
                'label' => esc_html__('Width', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-slider .ps-orbit-item' => 'width: {{SIZE}}{{UNIT}}; left: 50%; margin-left: calc(-{{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_item_height',
            [
                'label' => esc_html__('Height', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-slider .ps-orbit-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'orbit_item_border',
                'selector' => '{{WRAPPER}} .ps-orbit-slider .ps-orbit-item'
            ]
        );

        $this->add_responsive_control(
            'orbit_item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-slider .ps-orbit-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('orbit_item_style_tabs');
        $this->start_controls_tab(
            'orbit_item_style_normal',
            [
                'label' => esc_html__('Normal', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_responsive_control(
            'orbit_item_normal_scale',
            [
                'label' => esc_html__('Scale', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0.5,
                'max' => 2,
                'step' => 0.01,
                'default' => 1,
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_item_normal_box_shadow',
                'label' => esc_html__('Box Shadow', 'bdthemes-prime-slider'),
                'selector' => '{{WRAPPER}} .ps-orbit-slider .ps-orbit-item',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'orbit_item_style_hover',
            [
                'label' => esc_html__('Hover', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_responsive_control(
            'orbit_item_hover_scale',
            [
                'label' => esc_html__('Scale', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0.5,
                'max' => 2,
                'step' => 0.01,
                'default' => 1.1,
            ]
        );

        $this->add_control(
            'orbit_item_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-slider .ps-orbit-item:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'orbit_item_border_border!' => ['none', ''],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_item_hover_box_shadow',
                'label' => esc_html__('Box Shadow', 'bdthemes-prime-slider'),
                'selector' => '{{WRAPPER}} .ps-orbit-slider .ps-orbit-item:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'orbit_style_modal',
            [
                'label' => esc_html__('Modal', 'bdthemes-prime-slider'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'orbit_modal_bg',
                'label' => esc_html__('Background', 'bdthemes-prime-slider'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ps-orbit-modal-content',
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_content_direction',
            [
                'label'   => esc_html__('Swap Direction', 'bdthemes-prime-slider'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => esc_html__('Row', 'bdthemes-prime-slider'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                    'row-reverse' => [
                        'title' => esc_html__('Row Reverse', 'bdthemes-prime-slider'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'bdthemes-prime-slider'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                    'column-reverse' => [
                        'title' => esc_html__('Column Reverse', 'bdthemes-prime-slider'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-content-wrapper' => 'flex-direction: {{VALUE}};',
                ],
                'toggle'  => true,
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_content_space_between',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Space Between', 'bdthemes-prime-slider'),
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-content-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('orbit_modal_content_style_tabs');
        $this->start_controls_tab(
            'orbit_modal_content_normal_tab',
            [
                'label' => esc_html__('Image', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_content_image_size',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Size', 'bdthemes-prime-slider'),
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-content .ps-orbit-modal-image' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_image_position',
            [
                'label'        => esc_html__('Image Position', 'bdthemes-element-pack'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'flex-start'  => [
                        'title' => esc_html__('Top', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center'   => [
                        'title' => esc_html__('Center', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'default'      => '',
                'selectors'    => [
                    '{{WRAPPER}} .ps-orbit-modal-content-wrapper .ps-orbit-modal-left' => 'align-self: {{VALUE}};',
                ],
                'toggle'       => false,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'orbit_modal_content_border',
                'selector' => '{{WRAPPER}} .ps-orbit-modal-content .ps-orbit-modal-image',
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-content .ps-orbit-modal-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_modal_content_box_shadow',
                'selector' => '{{WRAPPER}} ps-orbit-modal-content .ps-orbit-modal-image',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'orbit_modal_content_hover_tab',
            [
                'label' => esc_html__('Content', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_content_title_align',
            [
                'label' => esc_html__('Alignment', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'start' => [
                        'title' => esc_html__('Left', 'bdthemes-prime-slider'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'bdthemes-prime-slider'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__('Right', 'bdthemes-prime-slider'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-content-wrapper .ps-orbit-modal-right' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .ps-orbit-modal-content-wrapper .ps-orbit-modal-right p' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_content_position',
            [
                'label'        => esc_html__('Content Position', 'bdthemes-element-pack'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'flex-start'  => [
                        'title' => esc_html__('Top', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center'   => [
                        'title' => esc_html__('Center', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'bdthemes-element-pack'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'default'      => '',
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-content-wrapper .ps-orbit-modal-right' => 'align-self: {{VALUE}};',
                ],
                'toggle'       => false,
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_content_max_width',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__('Max Width', 'bdthemes-prime-slider'),
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-content-wrapper .ps-orbit-modal-right' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'orbit_modal_content_title',
            [
                'label' => esc_html__('TITLE', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'orbit_modal_content_title_color',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-right .ps-orbit-modal-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_content_title_margin',
            [
                'label' => esc_html__('Margin', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-right .ps-orbit-modal-title' => 'margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'orbit_modal_content_title_typography',
                'selector' => '{{WRAPPER}} .ps-orbit-modal-right .ps-orbit-modal-title',
            ]
        );

        $this->add_control(
            'orbit_modal_content_description',
            [
                'label' => esc_html__('DESCRIPTION', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'orbit_modal_content_description_color',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-right .ps-orbit-modal-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_content_description_margin',
            [
                'label' => esc_html__('Margin', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-right .ps-orbit-modal-description' => 'margin-bottom: {{BOTTOM}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'orbit_modal_content_description_typography',
                'selector' => '{{WRAPPER}} .ps-orbit-modal-right .ps-orbit-modal-description',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'orbit_modal_button',
            [
                'label' => esc_html__('Modal Button', 'bdthemes-prime-slider'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('orbit_modal_button_tabs');
        $this->start_controls_tab(
            'orbit_modal_button_normal_tab',
            [
                'label' => esc_html__('Normal', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_modal_button_text_color',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ps-orbit-modal-btn svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'orbit_modal_button_bg',
                'label' => esc_html__('Background', 'bdthemes-prime-slider'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ps-orbit-modal-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'orbit_modal_button_border',
                'label' => esc_html__('Border', 'bdthemes-prime-slider'),
                'selector' => '{{WRAPPER}} .ps-orbit-modal-btn',
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_button_padding',
            [
                'label' => esc_html__('Padding', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_modal_button_box_shadow',
                'label' => esc_html__('Box Shadow', 'bdthemes-prime-slider'),
                'selector' => '{{WRAPPER}} .ps-orbit-modal-btn',
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label' => esc_html__('Space Between', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-btn .ps-orbit-modal-btn-info' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'orbit_selected_icon[value]!' => '',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'orbit_modal_button_typography',
                'label' => esc_html__('Typography', 'bdthemes-prime-slider'),
                'selector' => '{{WRAPPER}} .ps-orbit-modal-btn span, {{WRAPPER}} .ps-orbit-modal-btn svg',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'orbit_modal_button_hover_tab',
            [
                'label' => esc_html__('Hover', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_modal_button_text_color_hover',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-btn:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ps-orbit-modal-btn:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'orbit_modal_button_bg_hover',
                'label' => esc_html__('Background', 'bdthemes-prime-slider'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .ps-orbit-modal-btn:hover',
            ]
        );

        $this->add_control(
            'orbit_modal_button_bg_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-modal-btn:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'orbit_modal_button_border_border!' => ['none', ''],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_modal_button_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'bdthemes-prime-slider'),
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .ps-orbit-modal-btn:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'orbit_modal_cls_button',
            [
                'label' => esc_html__('Close Icon', 'bdthemes-prime-slider'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('orbit_modal_close_button_tabs');
        $this->start_controls_tab(
            'orbit_modal_close_button_normal',
            [
                'label' => esc_html__('Normal', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_modal_close_button_color',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-close-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'orbit_modal_close_button_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ps-orbit-close-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'orbit_modal_close_button_border',
                'label' => esc_html__('Border', 'bdthemes-prime-slider'),
                'selector' => '{{WRAPPER}} .ps-orbit-close-btn',
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_close_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-close-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_close_button_padding',
            [
                'label' => esc_html__('Padding', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-close-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_close_button_margin',
            [
                'label' => esc_html__('Margin', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-close-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_modal_close_button_size',
            [
                'label' => esc_html__('Size', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-close-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_modal_close_button_box_shadow',
                'selector' => '{{WRAPPER}} .ps-orbit-close-btn',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'orbit_modal_close_button_hover',
            [
                'label' => esc_html__('Hover', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_modal_close_button_color_hover',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-close-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'orbit_modal_close_button_bg_hover',
                'label' => esc_html__('Background', 'bdthemes-prime-slider'),
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .ps-orbit-close-btn:hover',
            ]
        );

        $this->add_control(
            'orbit_modal_close_button_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-close-btn:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'orbit_modal_close_button_border_border!' => ['none', ''],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_modal_close_button_box_shadow_hover',
                'selector' => '{{WRAPPER}} .ps-orbit-close-btn:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'orbit_style_navigation',
            [
                'label' => esc_html__('Navigation', 'bdthemes-prime-slider'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'orbit_arrows_heading',
            [
                'label'     => __('ARROWS', 'bdthemes-prime-slider'),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orbit_arrows_icon',
            [
                'label'     => esc_html__('Arrows Icon', 'bdthemes-prime-slider'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '0',
                'options'   => [
                    '0'        => esc_html__('Default', 'bdthemes-prime-slider'),
                    '1'        => esc_html__('Style 1', 'bdthemes-prime-slider'),
                    '2'        => esc_html__('Style 2', 'bdthemes-prime-slider'),
                    '3'        => esc_html__('Style 3', 'bdthemes-prime-slider'),
                    '4'        => esc_html__('Style 4', 'bdthemes-prime-slider'),
                    '5'        => esc_html__('Style 5', 'bdthemes-prime-slider'),
                    '6'        => esc_html__('Style 6', 'bdthemes-prime-slider'),
                    '7'        => esc_html__('Style 7', 'bdthemes-prime-slider'),
                    '8'        => esc_html__('Style 8', 'bdthemes-prime-slider'),
                    '9'        => esc_html__('Style 9', 'bdthemes-prime-slider'),
                    '10'       => esc_html__('Style 10', 'bdthemes-prime-slider'),
                    '11'       => esc_html__('Style 11', 'bdthemes-prime-slider'),
                    '12'       => esc_html__('Style 12', 'bdthemes-prime-slider'),
                    '13'       => esc_html__('Style 13', 'bdthemes-prime-slider'),
                    '14'       => esc_html__('Style 14', 'bdthemes-prime-slider'),
                    '15'       => esc_html__('Style 15', 'bdthemes-prime-slider'),
                    '16'       => esc_html__('Style 16', 'bdthemes-prime-slider'),
                    '17'       => esc_html__('Style 17', 'bdthemes-prime-slider'),
                    '18'       => esc_html__('Style 18', 'bdthemes-prime-slider'),
                    'circle-1' => esc_html__('Style 19', 'bdthemes-prime-slider'),
                    'circle-2' => esc_html__('Style 20', 'bdthemes-prime-slider'),
                    'circle-3' => esc_html__('Style 21', 'bdthemes-prime-slider'),
                    'circle-4' => esc_html__('Style 22', 'bdthemes-prime-slider'),
                    'square-1' => esc_html__('Style 23', 'bdthemes-prime-slider'),
                ],
            ]
        );

        $this->start_controls_tabs('orbit_nav_btn_style_tabs');
        $this->start_controls_tab(
            'orbit_nav_btn_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_nav_btn_color',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'orbit_nav_btn_bg_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'orbit_nav_btn_border',
                'selector' => '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn',
            ]
        );

        $this->add_responsive_control(
            'orbit_nav_btn_border_radius_adv',
            [
                'label'      => esc_html__('Border Radius', 'bdthemes-prime-slider'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_nav_btn_padding',
            [
                'label'      => esc_html__('Padding', 'bdthemes-prime-slider'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'orbit_arrows_size',
            [
                'label' => esc_html__('Size', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_nav_btn_box_shadow',
                'selector' => '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'orbit_nav_btn_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'bdthemes-prime-slider'),
            ]
        );

        $this->add_control(
            'orbit_nav_btn_color_hover',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'orbit_nav_btn_bg_color_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn:hover',
            ]
        );

        $this->add_control(
            'orbit_nav_btn_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'orbit_nav_btn_border_border!' => ['none', ''],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_nav_btn_box_shadow_hover',
                'selector' => '{{WRAPPER}} .ps-orbit-navigation-buttons .ps-orbit-nav-btn:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'orbit_dots_heading',
            [
                'label' => esc_html__('DOTS', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs(
            'orbit_dots_style_tabs',
            [
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->start_controls_tab(
            'orbit_dots_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'bdthemes-prime-slider'),
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_control(
            'orbit_pagination_dot_color',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_pagination_dot_width',
            [
                'label' => esc_html__('Width', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_pagination_dot_height',
            [
                'label' => esc_html__('Height', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_dots_space',
            [
                'label' => esc_html__('Space Between', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_pagination_dot_border_radius',
            [
                'label' => esc_html__('Border Radius', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_pagination_dot_box_shadow',
                'selector' => '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot',
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_pagination_dot_translate_x',
            [
                'label' => esc_html__('Horizontal Offset', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot' => '--ps-orbit-dot-translate-x: {{SIZE}}{{UNIT}}; transform: translate(var(--ps-orbit-dot-translate-x, 0), var(--ps-orbit-dot-translate-y, 0));',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'orbit_pagination_dot_translate_y',
            [
                'label' => esc_html__('Vertical Offset', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot' => '--ps-orbit-dot-translate-y: {{SIZE}}{{UNIT}}; transform: translate(var(--ps-orbit-dot-translate-x, 0), var(--ps-orbit-dot-translate-y, 0));',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'orbit_dots_style_hover_tab',
            [
                'label' => esc_html__('Active', 'bdthemes-prime-slider'),
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_control(
            'orbit_pagination_dot_active_color',
            [
                'label' => esc_html__('Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot.active' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_pagination_dot_active_width',
            [
                'label' => esc_html__('Width', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot.active' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_responsive_control(
            'orbit_pagination_dot_active_height',
            [
                'label' => esc_html__('Height', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot.active' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_control(
            'orbit_pagination_dot_active_border_color',
            [
                'label' => esc_html__('Border Color', 'bdthemes-prime-slider'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot.active' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'orbit_pagination_dot_border_border!' => ['none', ''],
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'orbit_pagination_dot_box_shadow_hover',
                'selector' => '{{WRAPPER}} .ps-orbit-pagination-dots .ps-orbit-pagination-dot.active',
                'condition' => [
                    'orbit_rotation_control' => 'no-loop',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $button_text = !empty($settings['orbit_button_text']) ? sanitize_text_field($settings['orbit_button_text']) : 'Learn More';

        if (! empty($settings['icon']) && empty($settings['orbit_selected_icon']['value'])) {
            $settings['orbit_selected_icon']['value'] = $settings['icon'];
            $settings['orbit_selected_icon']['library'] = 'fa-solid';
        }

        $rotation_speed = isset($settings['orbit_rotation_speed']['size']) ? $settings['orbit_rotation_speed']['size'] : 30;
        $rotation_direction = isset($settings['orbit_rotation_direction']) ? $settings['orbit_rotation_direction'] : 'clockwise';
        $rotation_control = isset($settings['orbit_rotation_control']) ? $settings['orbit_rotation_control'] : 'loop';
        $normal_scale = isset($settings['orbit_item_normal_scale']) ? $settings['orbit_item_normal_scale'] : 1;
        $hover_scale = isset($settings['orbit_item_hover_scale']) ? $settings['orbit_item_hover_scale'] : 1;

        $widget_id = 'orbit-' . $this->get_id();
        ?>
            <div 
                class="ps-orbit-container" 
                id="<?php echo esc_attr($widget_id); ?>" 
                data-rotation-speed="<?php echo esc_attr($rotation_speed); ?>" 
                data-rotation-direction="<?php echo esc_attr($rotation_direction); ?>" 
                data-rotation-control="<?php echo esc_attr($rotation_control); ?>" 
                data-normal-scale="<?php echo esc_attr($normal_scale); ?>" 
                data-hover-scale="<?php echo esc_attr($hover_scale); ?>"
            >
                <div class="ps-orbit-banner">
                    <?php
                    $image_id = $settings['orbit_center_image']['id'];
                    $image_title = get_the_title($image_id);
                    ?>
                    <div class="ps-orbit-center-image">
                        <img src="<?php echo esc_url($settings['orbit_center_image']['url']); ?>" alt="<?php echo esc_attr($image_title); ?>">
                    </div>

                    <div class="ps-orbit-slider">
                        <?php foreach ($settings['orbit_items'] as $item) : ?>
                            <div class="ps-orbit-item" data-title="<?php echo esc_attr($item['orbit_title']); ?>"
                                data-description="<?php echo esc_attr($item['orbit_description']); ?>"
                                data-url="<?php echo esc_attr($item['orbit_url']['url']); ?>">
                                <img src="<?php echo esc_url($item['orbit_image']['url']); ?>" alt="<?php echo esc_attr($item['orbit_title']); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="ps-orbit-navigation-buttons" id="navigationButtons-<?php echo esc_attr($widget_id); ?>" style="display: none;">
                    <button class="ps-orbit-nav-btn ps-orbit-prev-btn" id="prevBtn-<?php echo esc_attr($widget_id); ?>">
                        <i class="ep-icon-arrow-left-<?php echo esc_attr($settings['orbit_arrows_icon']); ?>" aria-hidden="true"></i>
                    </button>
                    <button class="ps-orbit-nav-btn ps-orbit-next-btn" id="nextBtn-<?php echo esc_attr($widget_id); ?>">
                        <i class="ep-icon-arrow-right-<?php echo esc_attr($settings['orbit_arrows_icon']); ?>" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="ps-orbit-pagination-container" id="paginationContainer-<?php echo esc_attr($widget_id); ?>" style="display: none;">
                    <div class="ps-orbit-pagination-dots" id="paginationDots-<?php echo esc_attr($widget_id); ?>"></div>
                </div>

                <div class="ps-orbit-modal" id="modal-<?php echo esc_attr($widget_id); ?>">
                    <div class="ps-orbit-modal-content">
                        <span class="ps-orbit-close-btn" id="closeBtn-<?php echo esc_attr($widget_id); ?>">
                            <i class="ep-icon-close" aria-hidden="true"></i>
                        </span>
                        <div class="ps-orbit-modal-content-wrapper">
                            <div class="ps-orbit-modal-left">
                                <div class="ps-orbit-modal-image">
                                    <img id="modalImg-<?php echo esc_attr($widget_id); ?>" src="" alt="">
                                </div>
                            </div>
                            <div class="ps-orbit-modal-right">
                                <h2 class="ps-orbit-modal-title" id="modalTitle-<?php echo esc_attr($widget_id); ?>"></h2>
                                <p class="ps-orbit-modal-description" id="modalDescription-<?php echo esc_attr($widget_id); ?>"></p>
                                <button class="ps-orbit-modal-btn" id="modalBtn-<?php echo esc_attr($widget_id); ?>">
                                    <span class="ps-orbit-modal-btn-info">
                                        <?php if ('before' === $settings['orbit_icon_position'] && ! empty($settings['orbit_selected_icon']['value'])) : ?>
                                            <span class="ps-orbit-svg-icon">
                                                <?php Icons_Manager::render_icon(
                                                    $settings['orbit_selected_icon'],
                                                    ['aria-hidden' => 'true', 'class' => 'orbit-icon orbit-icon-before']
                                                ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php echo esc_html($button_text); ?>
                                        <?php if ('after' === $settings['orbit_icon_position'] && ! empty($settings['orbit_selected_icon']['value'])) : ?>
                                            <span class="ps-orbit-svg-icon">
                                                <?php Icons_Manager::render_icon(
                                                    $settings['orbit_selected_icon'],
                                                    ['aria-hidden' => 'true', 'class' => 'orbit-icon orbit-icon-after']
                                                ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}

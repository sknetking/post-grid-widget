<?php
class Elementor_Recent_Post_Grid extends \Elementor\Widget_Base {
    

    public function get_name():string {
        return 'recent_post_grid';
    }

    public function get_title(): string {
        return esc_html__('Post Grid', 'elementor-addon');
    }

    public function get_icon(): string {
        return 'eicon-posts-grid';
    }

    public function get_categories(): array {
        return ['basic'];
    }

    public function get_keywords(): array {
        return ['post', 'grid', 'recent', 'blog'];
    }
    
    protected function register_controls(): void {
        // Content Tab
  

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content Settings', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
            $this->add_responsive_control(
                'columns',
                [
                    'label' => esc_html__('Columns', 'elementor-addon'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '3',
                   'tablet_default' => 2,
                    'mobile_default' => 1,
                    'options' => [
                        '1' => esc_html__('1 Column', 'elementor-addon'),
                        '2' => esc_html__('2 Columns', 'elementor-addon'),
                        '3' => esc_html__('3 Columns', 'elementor-addon'),
                        '4' => esc_html__('4 Columns', 'elementor-addon'),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .post-grid-container' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                    ],
                ]
            );
            $this->add_control(
                'card_style',
                [
                    'label' => esc_html__('Grid Style', 'elementor-addon'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        '' => esc_html__('Default Style', 'elementor-addon'),
                        'modern-card' => esc_html__('Modern Style', 'elementor-addon'),
                        'minimalist-card' => esc_html__('Basic Style', 'elementor-addon'),
                        'dark-card' => esc_html__('Dark Style', 'elementor-addon'),
                        'list-view' => esc_html__('List Style', 'elementor-addon'),
                       
                    ],
                ]
            );

        $this->add_control(
            'show_filter',
            [
                'label' => esc_html__('Show Filter', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-addon'),
                'label_off' => esc_html__('Hide', 'elementor-addon'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
         $this->add_control(
            'select_taxonomy',
            [
                'label' => __('Taxonomy for Filter', 'text-domain'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'category',
                'options' => $this->get_taxonomies(),
                'description' => __('Select which taxonomy to use for the filter buttons', 'text-domain'),
                'condition' => [
                    'show_filter' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'show_image',
            [
                'label' => esc_html__('Show Featured Image', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-addon'),
                'label_off' => esc_html__('Hide', 'elementor-addon'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_category',
            [
                'label' => esc_html__('Show Category', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-addon'),
                'label_off' => esc_html__('Hide', 'elementor-addon'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => esc_html__('Show Author', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-addon'),
                'label_off' => esc_html__('Hide', 'elementor-addon'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => esc_html__('Show Date', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-addon'),
                'label_off' => esc_html__('Hide', 'elementor-addon'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => esc_html__('Show Excerpt', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-addon'),
                'label_off' => esc_html__('Hide', 'elementor-addon'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => esc_html__('Excerpt Length (words)', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 20,
                'min' => 5,
                'max' => 100,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label' => esc_html__('Show Read More', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-addon'),
                'label_off' => esc_html__('Hide', 'elementor-addon'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Read More Text', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'elementor-addon'),
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
   
        // Query Filters Section
        $this->start_controls_section(
			'section_query_builder',
			[
				'label' => esc_html__( 'Query Builder', 'elementor-addon' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
         
        function sk_wpq_get_post_type_options() {
            $post_types = get_post_types([
                'public' => true,
                // You can add more args here to filter post types
            ], 'objects');

            $options = [];

            foreach ($post_types as $post_type) {
                // Skip some post types if needed
                if (in_array($post_type->name, ['attachment', 'elementor_library'])) {
                    continue;
                }
                
                $options[$post_type->name] = $post_type->label;
            }

            return $options;
        }

        $this->add_control(
            'selected_post_type',
            [
                'label' => esc_html__('Select Post Type', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' =>sk_wpq_get_post_type_options(),
                'default' => 'post',
                'label_block' => true,
                'description' => esc_html__('Choose which post type to display', 'elementor-addon'),
            ]
        );

         $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Number of Posts', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
                'min' =>1,
                'max' =>30,
            ]
        );
        // Order by control
        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => __('Date', 'elementor-addon'),
                    'title' => __('Title', 'elementor-addon'),
                    'menu_order' => __('Menu Order', 'elementor-addon'),
                    'rand' => __('Random', 'elementor-addon'),
                    'comment_count' => __('Comment Count', 'elementor-addon'),
                    'modified' => __('Modified', 'elementor-addon'),
                    'meta_value' => __('Custom Field', 'elementor-addon'),
                ],
            ]
        );

        // Order direction
        $this->add_control(
            'order',
            [
                'label' => __('Order', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC' => __('ASC', 'elementor-addon'),
                    'DESC' => __('DESC', 'elementor-addon'),
                ],
            ]
        );

        // Meta key (if orderby is meta_value)
        $this->add_control(
            'meta_key',
            [
                'label' => __('Meta Key', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition' => [
                    'orderby' => 'meta_value',
                ],
            ]
        );

        // Post IDs filter
        $this->add_control(
            'post__in',
            [
                'label' => __('Include Only', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated list of post IDs', 'elementor-addon'),
            ]
        );

        // Exclude posts
        $this->add_control(
            'post__not_in',
            [
                'label' => __('Exclude', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated list of post IDs to exclude', 'elementor-addon'),
            ]
        );

        // Author filter
        $this->add_control(
            'author__in',
            [
                'label' => __('Authors', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated author IDs', 'elementor-addon'),
            ]
        );

        // Category filter
        $this->add_control(
            'category__in',
            [
                'label' => __('Categories', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated category IDs', 'elementor-addon'),
            ]
        );

        // Tag filter
        $this->add_control(
            'tag__in',
            [
                'label' => __('Tags', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated tag IDs', 'elementor-addon'),
            ]
        );

        // Date query
        $this->add_control(
            'date_query',
            [
                'label' => __('Date', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => __('All', 'elementor-addon'),
                    'today' => __('Today', 'elementor-addon'),
                    'yesterday' => __('Yesterday', 'elementor-addon'),
                    'this_week' => __('This Week', 'elementor-addon'),
                    'last_week' => __('Last Week', 'elementor-addon'),
                    'this_month' => __('This Month', 'elementor-addon'),
                    'last_month' => __('Last Month', 'elementor-addon'),
                    'this_year' => __('This Year', 'elementor-addon'),
                    'last_year' => __('Last Year', 'elementor-addon'),
                ],
            ]
        );

        $this->end_controls_section();
    
        
        // Style Tab
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Grid Style', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'column_gap',
            [
                'label' => esc_html__('Column Gap', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 15,
				],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		
		  $this->add_control(
            'card_title_color',
            [
                'label' => esc_html__('Card Hover Title Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-card:hover .post-grid-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
		
        $this->add_responsive_control(
            'row_gap',
            [
                'label' => esc_html__('Row Gap', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
					'unit' => 'px',
					'size' => 15,
				],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
          

        //load more star from here 
        $this->start_controls_section(
            'load_more_section',
            [
                'label' => esc_html__('Load More Button', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_load_more',
            [
                'label' => esc_html__('Show Load More', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-addon'),
                'label_off' => esc_html__('Hide', 'elementor-addon'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'load_more_text',
            [
                'label' => esc_html__('Button Text', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Load More', 'elementor-addon'),
                'condition' => [
                    'show_load_more' => 'yes',
                ],
            ]
        );

        // $this->add_control(
        //     'posts_per_load',
        //     [
        //         'label' => esc_html__('Posts Per Load', 'elementor-addon'),
        //         'type' => \Elementor\Controls_Manager::NUMBER,
        //         'default' => 3,
        //         'min' => 1,
        //         'max' => 12,
        //         'condition' => [
        //             'show_load_more' => 'yes',
        //         ],
        //     ]
        // );

        $this->end_controls_section();


        // Card Style
        $this->start_controls_section(
            'card_style_tab',
            [
                'label' => esc_html__('Card Style', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .post-grid-card',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'selector' => '{{WRAPPER}} .post-grid-card',
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__('Padding', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content padding', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();

            // ====================
            // IMAGE STYLE ENHANCEMENT
         // ====================
        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Image Style', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        // Normal/Hover Tabs
        $this->start_controls_tabs('image_style_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'image_style_normal',
            [
                'label' => __('Normal', 'elementor-addon'),
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label' => esc_html__('Opacity', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .post-grid-image img',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'image_style_hover',
            [
                'label' => __('Hover', 'elementor-addon'),
            ]
        );

        $this->add_control(
            'image_hover_opacity',
            [
                'label' => esc_html__('Opacity', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-card:hover .post-grid-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'image_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'elementor-addon'),
                    'grow' => esc_html__('Zoom In', 'elementor-addon'),
                    'shrink' => esc_html__('Zoom Out', 'elementor-addon'),
                ],
                'default' => '',
                'prefix_class' => 'elementor-animation-',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_hover_border',
                'selector' => '{{WRAPPER}} .post-grid-card:hover .post-grid-image img',
            ]
        );

        $this->add_control(
            'image_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-image img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Image height
        $this->add_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Border radius
        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Spacing
        $this->add_control(
            'image_spacing',
            [
                'label' => esc_html__('Spacing', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        // category style tab start 
            /* ====================CATEGORY STYLE ENHANCEMENT====================*/
        $this->start_controls_section(
            'category_style',
            [
                'label' => esc_html__('Category Style', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Normal/Hover Tabs
        $this->start_controls_tabs('category_style_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'category_style_normal',
            [
                'label' => __('Normal', 'elementor-addon'),
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__('Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-category a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-category a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'category_border',
                'selector' => '{{WRAPPER}} .post-grid-category a',
            ]
        );

        $this->add_control(
            'category_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'category_box_shadow',
                'selector' => '{{WRAPPER}} .post-grid-category a',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'category_style_hover',
            [
                'label' => __('Hover', 'elementor-addon'),
            ]
        );

        $this->add_control(
            'category_hover_color',
            [
                'label' => esc_html__('Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-category a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-category a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'category_hover_border',
                'selector' => '{{WRAPPER}} .post-grid-category a:hover',
            ]
        );

        $this->add_control(
            'category_hover_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-category a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'category_hover_box_shadow',
                'selector' => '{{WRAPPER}} .post-grid-category a:hover',
            ]
        );

        $this->add_control(
            'category_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-category a' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Padding
        $this->add_control(
            'category_padding',
            [
                'label' => esc_html__('Padding', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Spacing
        $this->add_control(
            'category_spacing',
            [
                'label' => esc_html__('Margin', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .post-grid-category a',
            ]
        );

        $this->end_controls_section();


        // Title Style
        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title Style', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => esc_html__('Hover Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .post-grid-title',
            ]
        );

        $this->add_control(
            'title_spacing',
            [
                'label' => esc_html__('Spacing', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Meta Style
        $this->start_controls_section(
            'meta_style',
            [
                'label' => esc_html__('Meta Style', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-meta' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .post-grid-meta a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'meta_hover_color',
            [
                'label' => esc_html__('Hover Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-meta a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .post-grid-meta',
            ]
        );

        $this->add_control(
            'meta_spacing',
            [
                'label' => esc_html__('Spacing', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Excerpt Style
        $this->start_controls_section(
            'excerpt_style',
            [
                'label' => esc_html__('Excerpt Style', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => esc_html__('Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .post-grid-excerpt',
            ]
        );

        $this->add_control(
            'excerpt_spacing',
            [
                'label' => esc_html__('Spacing', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Read More Style
       
            $this->start_controls_section(
            'read_more_style',
            [
                'label' => esc_html__('Read More Style', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        // Normal/Hover Tabs
        $this->start_controls_tabs('read_more_style_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'read_more_style_normal',
            [
                'label' => __('Normal', 'elementor-addon'),
            ]
        );

        $this->add_control(
            'read_more_text_color',
            [
                'label' => esc_html__('Text Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-read-more a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-read-more a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'read_more_border',
                'selector' => '{{WRAPPER}} .post-grid-read-more a',
            ]
        );

        $this->add_control(
            'read_more_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-read-more a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'read_more_box_shadow',
                'selector' => '{{WRAPPER}} .post-grid-read-more a',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'read_more_style_hover',
            [
                'label' => __('Hover', 'elementor-addon'),
            ]
        );

        $this->add_control(
            'read_more_hover_color',
            [
                'label' => esc_html__('Text Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-read-more a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_hover_bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-read-more a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'read_more_hover_border',
                'selector' => '{{WRAPPER}} .post-grid-read-more a:hover',
            ]
        );

        $this->add_control(
            'read_more_hover_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-read-more a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'read_more_hover_box_shadow',
                'selector' => '{{WRAPPER}} .post-grid-read-more a:hover',
            ]
        );

        $this->add_control(
            'read_more_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-read-more a' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Padding
        $this->add_control(
            'read_more_padding',
            [
                'label' => esc_html__('Padding', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-read-more a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin
        $this->add_control(
            'read_more_margin',
            [
                'label' => esc_html__('Margin', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_typography',
                'selector' => '{{WRAPPER}} .post-grid-read-more a',
            ]
        );

        $this->end_controls_section();

// load_more_style new section started from here 
        $this->start_controls_section(
            'load_more_style',
            [
                'label' => esc_html__('Load More Button', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_load_more' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'load_more_typography',
                'selector' => '{{WRAPPER}} .post-grid-load-more',
            ]
        );

        $this->add_control(
            'load_more_color',
            [
                'label' => esc_html__('Text Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-load-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_hover_color',
            [
                'label' => esc_html__('Text Hover Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-load-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg_color',
            [
                'label' => esc_html__('Background Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-load-more' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg_hover_color',
            [
                'label' => esc_html__('Background Hover Color', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-grid-load-more:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'load_more_border',
                'selector' => '{{WRAPPER}} .post-grid-load-more',
            ]
        );

        $this->add_control(
            'load_more_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_padding',
            [
                'label' => esc_html__('Padding', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_margin',
            [
                'label' => esc_html__('Margin', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-grid-load-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_align',
            [
                'label' => esc_html__('Alignment', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'elementor-addon'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-addon'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'elementor-addon'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .post-grid-load-more-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        
    }
    

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();
         
$args = [
    'post_type'      => $settings['selected_post_type'],
    'posts_per_page' => $settings['posts_per_page'],
    'orderby'        => $settings['orderby'],
    'order'          => $settings['order'],
];

// If orderby is meta_value, include meta_key
if ( 'meta_value' === $settings['orderby'] && ! empty( $settings['meta_key'] ) ) {
    $args['meta_key'] = $settings['meta_key'];
}

// Include posts
if ( ! empty( $settings['post__in'] ) ) {
    $args['post__in'] = array_map( 'intval', explode( ',', $settings['post__in'] ) );
}

// Exclude posts
if ( ! empty( $settings['post__not_in'] ) ) {
    $args['post__not_in'] = array_map( 'intval', explode( ',', $settings['post__not_in'] ) );
}

// Author filter
if ( ! empty( $settings['author__in'] ) ) {
    $args['author__in'] = array_map( 'intval', explode( ',', $settings['author__in'] ) );
}

// Category filter
if ( ! empty( $settings['category__in'] ) ) {
    $args['category__in'] = array_map( 'intval', explode( ',', $settings['category__in'] ) );
}

// Tag filter
if ( ! empty( $settings['tag__in'] ) ) {
    $args['tag__in'] = array_map( 'intval', explode( ',', $settings['tag__in'] ) );
}

// Date query handling
$date_query = [];
switch ( $settings['date_query'] ) {
    case 'today':
        $date_query[] = [
            'after' => 'today',
        ];
        break;
    case 'yesterday':
        $date_query[] = [
            'after'     => 'yesterday',
            'before'    => 'today',
            'inclusive' => true,
        ];
        break;
    case 'this_week':
        $date_query[] = [
            'after' => 'monday this week',
        ];
        break;
    case 'last_week':
        $date_query[] = [
            'after'     => 'monday last week',
            'before'    => 'sunday last week',
            'inclusive' => true,
        ];
        break;
    case 'this_month':
        $date_query[] = [
            'year'  => date('Y'),
            'month' => date('n'),
        ];
        break;
    case 'last_month':
        $date_query[] = [
            'year'  => date('Y', strtotime('-1 month')),
            'month' => date('n', strtotime('-1 month')),
        ];
        break;
    case 'this_year':
        $date_query[] = [
            'year' => date('Y'),
        ];
        break;
    case 'last_year':
        $date_query[] = [
            'year' => date('Y') - 1,
        ];
        break;
}

if ( ! empty( $date_query ) ) {
    $args['date_query'] = $date_query;
}

// ✅ Final WP_Query
$query = new \WP_Query( $args );
         // Filter out empty values (including empty arrays, empty strings, null, false)
        $filtered_settings = array_filter($settings, function($value) {
            // Customize this condition based on what you consider "empty"
            return !empty($value) || $value === 0 || $value === '0';
        });
         
         $terms = get_terms([
            'taxonomy' => $settings['select_taxonomy'],
            'hide_empty' => true,
        ]);

        // Encode to JSON
        $page_content = json_encode($filtered_settings);

        if ($query->have_posts()) :
            ?>
            <div class="post-grid-widget">
                <?php if($settings['select_taxonomy']): ?>
                <div class="post-filters">
                    <button class="filter-button active" data-filter=""> <?php echo __('All', 'text-domain'); ?></button>
                    <?php foreach ($terms as $term) : ?>
                    <button class="filter-button" data-filter="<?php echo esc_attr($term->term_id); ?>">
                        <?php echo esc_html($term->name); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?> 
                
                <div class="post-grid-container <?= $settings['card_style']; ?>" style="display: grid;">
                    <?php while ($query->have_posts()) : $query->the_post();
                      
                      include plugin_dir_path(__FILE__) . '/templates/post-grid-item.php';
                    
                    endwhile; ?>
                </div>
                <?php if ('yes' === $settings['show_load_more'] && $query->max_num_pages > 1) : ?>
                    <div class="post-grid-load-more-container">
                        <button class="post-grid-load-more" 
                                data-page="2" 
                                data-max-pages="<?php echo esc_attr($query->max_num_pages); ?>"
                                data-widget-id="<?php echo esc_attr($widget_id); ?>"
                                data-page_content="<?php echo esc_attr($page_content); ?>">
                               
                            <?php echo esc_html($settings['load_more_text']); ?>
                        </button>
                    </div>
                <?php endif; ?>
                               
                </div>
            <?php
            
            wp_reset_postdata();
        else :
            echo '<p>' . esc_html__('No posts found', 'elementor-addon') . '</p>';
        endif;
    }

    protected function get_taxonomies() {
            $taxonomies = get_taxonomies([
                'public' => true,
            ], 'objects');
            
            $options = [];
            
            foreach ($taxonomies as $taxonomy) {
                $options[$taxonomy->name] = $taxonomy->label;
            }
            
            return $options;
        }
       
}

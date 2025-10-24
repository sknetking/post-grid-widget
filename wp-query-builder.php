<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Custom_WP_Query_Builder {

    /**
     * Register query controls
     * 
     * @param \Elementor\Widget_Base $widget
     */


    public static function register_controls($widget) {
         
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
        
        // Query Filters Section
        $widget->start_controls_section(
            'section_query',
            ['label' => __('Query', 'elementor-addon')]
        );
          
         
        $widget->add_control(
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

         $widget->add_control(
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
        $widget->add_control(
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
        $widget->add_control(
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
        $widget->add_control(
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
        $widget->add_control(
            'post__in',
            [
                'label' => __('Include Only', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated list of post IDs', 'elementor-addon'),
            ]
        );

        // Exclude posts
        $widget->add_control(
            'post__not_in',
            [
                'label' => __('Exclude', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated list of post IDs to exclude', 'elementor-addon'),
            ]
        );

        // Author filter
        $widget->add_control(
            'author__in',
            [
                'label' => __('Authors', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated author IDs', 'elementor-addon'),
            ]
        );

        // Category filter
        $widget->add_control(
            'category__in',
            [
                'label' => __('Categories', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated category IDs', 'elementor-addon'),
            ]
        );

        // Tag filter
        $widget->add_control(
            'tag__in',
            [
                'label' => __('Tags', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'description' => __('Comma-separated tag IDs', 'elementor-addon'),
            ]
        );

        // Date query
        $widget->add_control(
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

        $widget->end_controls_section();
    }

    /**
     * Build WP_Query args from settings
     * 
     * @param array $settings
     * @param string $post_type Default post type
     * @return array
     */
    public static function build_query_args($settings, $post_type = 'post') {
         $post_type = $settings['selected_post_type'];
        $args = [
            'post_type' => $post_type,
            'posts_per_page' => $settings['posts_per_page'] ?? 6,
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
        ];
        
        // Add order/orderby
        if (!empty($settings['orderby'])) {
            $args['orderby'] = $settings['orderby'];
            $args['order'] = $settings['order'];
            
            if ($settings['orderby'] === 'meta_value' && !empty($settings['meta_key'])) {
                $args['meta_key'] = $settings['meta_key'];
            }
        }

        // Post IDs filter
        if (!empty($settings['post__in'])) {
            $args['post__in'] = array_map('intval', explode(',', $settings['post__in']));
        }

        // Exclude posts
        if (!empty($settings['post__not_in'])) {
            $args['post__not_in'] = array_map('intval', explode(',', $settings['post__not_in']));
        }

        // Author filter
        if (!empty($settings['author__in'])) {
            $args['author__in'] = array_map('intval', explode(',', $settings['author__in']));
        }

        // Category filter
        if (!empty($settings['category__in'])) {
            $args['category__in'] = array_map('intval', explode(',', $settings['category__in']));
        }

        // Tag filter
        if (!empty($settings['tag__in'])) {
            $args['tag__in'] = array_map('intval', explode(',', $settings['tag__in']));
        }

        // Date query
        if (!empty($settings['date_query'])) {
            $date = false;
            
            switch ($settings['date_query']) {
                case 'today':
                    $date = date('Y-m-d');
                    break;
                case 'yesterday':
                    $date = date('Y-m-d', strtotime('-1 day'));
                    break;
                case 'this_week':
                    $date = date('Y-m-d', strtotime('this week'));
                    break;
                case 'last_week':
                    $date = date('Y-m-d', strtotime('last week'));
                    break;
                case 'this_month':
                    $date = date('Y-m-d', strtotime('first day of this month'));
                    break;
                case 'last_month':
                    $date = date('Y-m-d', strtotime('first day of last month'));
                    break;
                case 'this_year':
                    $date = date('Y-m-d', strtotime('first day of January this year'));
                    break;
                case 'last_year':
                    $date = date('Y-m-d', strtotime('first day of January last year'));
                    break;
            }
            
            if ($date) {
                $args['date_query'] = [
                    [
                        'after' => $date,
                        'inclusive' => true,
                    ]
                ];
            }
        }

        return $args;
    }
}
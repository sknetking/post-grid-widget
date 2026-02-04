<?php
/**
 * Plugin Name:      SK Elementor Addon
 * Description:      SK Elementor Addon provide many premium widget free like post grid and related post. 
 * Version:           1.0.0
 * Author:            Shyam Sahani
 * Author URI:        https://developers.elementor.com/
 * Text Domain:       elementor-addon
 *
 * Requires Plugins:  elementor
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


function register_hello_world_widget( $widgets_manager ) {

	require_once( __DIR__ .'/post-grid.php' );
	
	$widgets_manager->register( new \Elementor_Recent_Post_Grid() );
}
add_action( 'elementor/widgets/register', 'register_hello_world_widget' );


function my_plugin_assets() {
    wp_enqueue_style(
        'my-plugin-style',
        plugins_url('post-grid.css', __FILE__)
    );
    
    wp_enqueue_script(
        'my-plugin-script',
        plugins_url('post-grid.js', __FILE__),
        array('jquery'),
        '1.0.0',
        true
    );
     wp_localize_script('my-plugin-script', 'postGridWidget', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_plugin_nonce')
        ));

}
add_action('wp_enqueue_scripts', 'my_plugin_assets');


add_action('wp_ajax_load_more_posts', 'handle_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'handle_load_more_posts');

function handle_load_more_posts() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    //$posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 6;
    $settings = $_POST["page_content"];

    // Optional: Use widget ID if you need widget-specific settings
    $widget_id = sanitize_text_field($_POST['widget_id']);
    $args = [
        'post_type' => $settings['selected_post_type'],
        'post_status' => 'publish',
        'posts_per_page' =>$settings['posts_per_page'] ?? 6,
        'paged' => $page,
        'ignore_sticky_posts' => true,
    ];
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
        if (!empty($_POST['filter_category']) && !empty($settings['select_taxonomy'])) {
            $tax_terms = array_map('intval', explode(',', $_POST['filter_category']));
            $taxonomy = sanitize_text_field($settings['select_taxonomy']);

            $args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $tax_terms,
                    'operator' => 'IN',
                )
            );
        }

        
        if (!empty($settings['category__in'])) {

             $args['category__in'] = array_map('intval', explode(',', $settings['category__in']));
        }

        // Tag filter
        if (!empty($settings['tag__in'])) {
            $args['tag__in'] = array_map('intval', explode(',', $settings['tag__in']));
        }
    

  
     $query = new WP_Query($args);

     ob_start();
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();     
        include plugin_dir_path(__FILE__) . '/templates/post-grid-item.php';
    endwhile;
    wp_reset_postdata();
endif;
$html = ob_get_clean();


    wp_send_json_success([
        'max_pages'=>$query->max_num_pages,
        'html' => $html,
        'load_more_text' => esc_html__('Load More', 'elementor-addon')
    ]);
}

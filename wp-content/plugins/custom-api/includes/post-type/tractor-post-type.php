<?php

function create_tractor_post_type()
{
    register_post_type('tractor', array(
        'menu_icon'   => 'dashicons-car',
        'public'      => true,
        'has_archive' => true, 
        'labels'      => array(
            'name'                  => __('Tractors', 'custom-api'),
            'singular_name'         => __('Tractor', 'custom-api'),
            'menu_name'             => __('Tractors', 'custom-api'),
            'add_new'               => __('New Tractor', 'custom-api'),
            'add_new_item'          => __('New Tractor', 'custom-api'),
            'edit_item'             => __('Edit Tractor', 'custom-api'),
            'new_item'              => __('New Tractor', 'custom-api'),
            'all_items'             => __('All Tractors', 'custom-api'),
            'view_item'             => __('View Tractor', 'custom-api'),
            'search_items'          => __('Search Tractor', 'custom-api'),
            'not_found'             => __('No tractors found!', 'custom-api'),
            'not_found_in_trash'    => __('No tractors found in trash!', 'custom-api'),
        ),
        'supports'    => array( 'title', 'editor', 'thumbnail', 'excerpt' )
    ));
}

add_action('init', 'create_tractor_post_type');

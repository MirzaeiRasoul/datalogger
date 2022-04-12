<?php

function create_tractor_post_type()
{
    register_post_type('tractor', array(
        'menu_icon'   => 'dashicons-car',
        'public'      => true,
        'has_archive' => true,
        'labels'      => array(
            'name'               => __('Tractors', 'datalogger-api'),
            'singular_name'      => __('Tractor', 'datalogger-api'),
            'menu_name'          => __('Tractors', 'datalogger-api'),
            'add_new'            => __('New Tractor', 'datalogger-api'),
            'add_new_item'       => __('New Tractor', 'datalogger-api'),
            'edit_item'          => __('Edit Tractor', 'datalogger-api'),
            'new_item'           => __('New Tractor', 'datalogger-api'),
            'all_items'          => __('All Tractors', 'datalogger-api'),
            'view_item'          => __('View Tractor', 'datalogger-api'),
            'search_items'       => __('Search Tractor', 'datalogger-api'),
            'not_found'          => __('No tractors found!', 'datalogger-api'),
            'not_found_in_trash' => __('No tractors found in trash!', 'datalogger-api'),
        ),
        'supports'    => array('title', 'editor', 'thumbnail', 'excerpt')
    ));
}

add_action('init', 'create_tractor_post_type');

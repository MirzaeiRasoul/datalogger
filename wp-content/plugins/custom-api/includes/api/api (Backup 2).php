<?php

$namespace = 'v1';
add_action('rest_api_init', 'register_routes');

function register_routes()
{
    global $namespace;
    // Register API for get all tractors
    register_rest_route($namespace, 'tractors', ['methods' => 'GET', 'callback' => 'get_all_tractors']);

    // Register API for create a new tractor
    register_rest_route($namespace, 'tractors', ['methods' => 'POST', 'callback' => 'create_new_tractor']);

    // Register API for get a tractor
    register_rest_route($namespace, 'tractors/(?P<id>\d+)', ['methods' => 'GET', 'callback' => 'get_single_tractror_by_id']);

    // Register API for update a tractor
    register_rest_route($namespace, 'tractors/(?P<id>\d+)', ['methods' => 'PUT', 'callback' => 'update_single_tractror_by_id']);

    // Register API for delete a tractor
    register_rest_route($namespace, 'tractors/(?P<id>\d+)', ['methods' => 'DELETE', 'callback' => 'delete_single_tractror_by_id']);


    // Register API for select all sensors of a tractor
    register_rest_route($namespace, 'tractors/(?P<id>\d+)/sensors', ['methods' => 'GET', 'callback' => 'get_all_sensors_from_single_tractor_by_id']);

    // Register API for create a new sensor of a tractor
    register_rest_route($namespace, 'tractors/(?P<id>\d+)/sensors', ['methods' => 'POST', 'callback' => 'create_new_sensor_for_single_tractor_by_id']);
}

function get_all_tractors()
{
    global $wpdb; // Global wordpress database class
    // $table_name = $wpdb->prefix . 'tractor_sensors'; // wp-tractors
    $table_name = $wpdb->prefix . 'posts'; // wp_posts
    $sql = "
        SELECT * FROM $table_name
        WHERE post_type = 'tractor'
        ORDER BY post_date DESC
    ";
    $tractors = $wpdb->get_results($sql);

    foreach ($tractors as $tractor) {
        $data[] = array(
            'id' => $tractor->ID,
            'title' => $tractor->post_title,
            'content' => $tractor->post_content,
            'permalink' => get_the_permalink($tractor->ID),
            'sensors' => array(
                'sensor_1' => get_post_meta($tractor->ID, 'sensor_1', true),
                'sensor_2' => get_post_meta($tractor->ID, 'sensor_2', true),
            )
        );
    }

    $response = array();
    $response['status'] = 'OK';
    $response['message'] = 'You have a request for server';
    $response['data'] = $data;
    return $response;
}

// function create_new_tractor($request)
// {
//     global $wpdb; // Global wordpress database class
//     $table_name = $wpdb->prefix . 'posts'; // wp_posts
// }

function get_single_tractror_by_id($request)
{
    global $wpdb; // Global wordpress database class
    $table_name = $wpdb->prefix . 'posts'; // wp_posts
    $tractor_id = $request['id'];
    $sql = "
        SELECT * FROM $table_name
        WHERE ID = $tractor_id
    ";
    $tractor = $wpdb->get_results($sql);

    $data['id'] = $tractor[0]->ID;
    $data['title'] = $tractor[0]->post_title;
    $data['content'] = $tractor[0]->post_content;
    $data['excerpt'] = $tractor[0]->post_excerpt;

    $response = array();
    $response['status'] = 'OK';
    $response['message'] = 'You have a request for server';
    $response['data'] = $data;
    return $response;
}

function get_all_sensors_from_single_tractor_by_id($request)
{
    global $wpdb; // Global wordpress database class
    $table_name = $wpdb->prefix . 'postmeta'; // wp_postmeta
    $tractor_id = $request['id'];
    $sql = "
        SELECT * FROM $table_name
        WHERE post_id = $tractor_id
    ";
    $sensors = $wpdb->get_results($sql);

    foreach ($sensors as $sensor) {
        $data[] = array(
            'id' => $sensor->meta_id,
            'key' => $sensor->meta_key,
            'value' => $sensor->meta_value
        );
    }

    $response = array();
    $response['status'] = 'OK';
    $response['message'] = 'You have a request for server';
    $response['data'] = $data;
    return $response;
}

function create_new_sensor_for_single_tractor_by_id($request)
{
    global $wpdb; // Global wordpress database class
    $table_name = $wpdb->prefix . 'postmeta'; // wp_postmeta
    $tractor_id = $request['id'];

    $wpdb->insert($table_name, array(
        'post_id'    => $tractor_id,
        'meta_key'   => 'Test Insert Func',
        'meta_value' => 'Test Shod.'
    ));

    $response = array();
    $response['status'] = 'OK';
    $response['message'] = 'You have a request for server';
    $response['sensor_id'] = $wpdb->insert_id;
    return $response;
}

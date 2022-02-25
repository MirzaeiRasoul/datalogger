<?php

$namespace = 'v1';
add_action('rest_api_init', 'register_routes');

function register_routes()
{
    global $namespace;
    register_rest_route(
        $namespace,
        'tractors',
        [
            'methods' => 'GET', 'callback' => 'get_all_tractors',
        ]
    );

    register_rest_route(
        $namespace,
        'tractors/(?P<id>\d+)',
        [
            'methods' => 'GET', 'callback' => 'get_single_tractror_by_id'
        ]
    );

    register_rest_route(
        $namespace,
        'tractors/(?P<slug>\S+)',
        [
            'methods' => 'GET', 'callback' => 'get_single_tractror_by_slug'
        ]
    );

    // register_rest_route($namespace, 'login', ['methods' => 'POST', 'callback' => 'login_callback']);
}

function get_all_tractors()
{
    $args = array(
        'post_type' => 'tractor',
        'post_status' => 'publish',
        'nopaging' => true
    );

    $query = new WP_Query($args);
    $tractor_posts = $query->get_posts();

    $data = array();
    foreach ($tractor_posts as $tractor) {
        // setup_postdata($tractor);

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

    // wp_send_json($response); // getting data in json format.
}

function get_single_tractror_by_id($request)
{
    $args = array(
        'post_type' => 'tractor',
        'p' => $request['id'],
    );

    $post = get_posts($args);

    $data['id'] = $post[0]->ID;
    $data['title'] = $post[0]->post_title;
    $data['content'] = $post[0]->post_content;
    $data['excerpt'] = $post[0]->post_excerpt;

    return $data;
}

function get_single_tractror_by_slug($request)
{
    $args = array(
        'post_type' => 'tractor',
        'name' => $request['slug'],
    );

    $post = get_posts($args);

    $data['id'] = $post[0]->ID;
    $data['title'] = $post[0]->post_title;
    $data['content'] = $post[0]->post_content;
    $data['slug'] = $post[0]->post_name;

    return $data;
}

function login_callback($request)
{
    $data = array();
    $params = $request->get_params();
    $name = $params['name'];

    if (isset($name)) {
        $data['status'] = 'OK';
        $data['user'] = [
            'name' => $name,
        ];
        $data['message'] = 'You have a request for server';
    } else {
        $data['status'] = 'Failed';
        $data['message'] = 'Parameters Missing';
    }

    return $data;
}

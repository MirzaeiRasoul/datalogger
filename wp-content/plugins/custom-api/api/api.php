<?php

add_action('rest_api_init', 'register_routes');
$namespace = 'v1';

function register_routes()
{
    global $namespace;
    register_rest_route(
        $namespace, // Namespace
        'test', // Endpoint
        [
            'methods' => 'GET',
            'callback' => 'test_callback',
        ]
    );
    register_rest_route($namespace, 'login', ['methods' => 'POST', 'callback' => 'login_callback']);
}

function test_callback()
{
    $data = array();
    $data['status'] = 'OK';
    $data['message'] = 'You have a request for server';
    return $data;

    // return CUSTOM_API_BASE;
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

<?php

$version = 'v1';
add_action('rest_api_init', 'register_routes');

function register_routes()
{
    global $version;
    // Register Users API(s)
    register_rest_route($version, 'users', ['methods' => 'GET', 'callback' => 'read_users']);
    register_rest_route($version, 'users', ['methods' => 'POST', 'callback' => 'create_user']);
    register_rest_route($version, 'users/(?P<id>\d+)', ['methods' => 'GET', 'callback' => 'get_user_by_id']);
    register_rest_route($version, 'users/(?P<id>\d+)', ['methods' => 'PUT', 'callback' => 'update_user_by_id']);
    register_rest_route($version, 'users/(?P<id>\d+)', ['methods' => 'DELETE', 'callback' => 'delete_user_by_id']);
}

/* GET: Callback for get all users
****************************************************************************************************/
function read_users(WP_REST_Request $request)
{
    // Your Codes
    if ("Exist an error in the client's $request") {
        $status_code = 400; // or 401 or 403 or 404
        $response = array(
            'status'  => $status_code,
            'message' => '...',
            'error'   => array(
                'description'  => '...'
            )
        );
    } else {
        if ("Server action has error") {
            $status_code = 500;
            $response = array(
                'status'  => $status_code,
                'message' => '...',
                'error'   => array(
                    'description'  => '...'
                )
            );
        } else {
            $status_code = 200;
            $response = array(
                'status'  => $status_code,
                'message' => '...',
                'data'    => array()
            );
        }
    }
    
    return new WP_REST_Response($response, $status_code);
}

/* POST: Callback for create a user
****************************************************************************************************/
function create_user(WP_REST_Request $request)
{
    // Your Codes
    if ("Exist an error in the client's $request") {
        $status_code = 400; // or 401 or 403 or 404
        $response = array(
            'status'  => $status_code,
            'message' => '...',
            'error'   => array(
                'description'  => '...'
            )
        );
    } else {
        if ("Server action has error") {
            $status_code = 500;
            $response = array(
                'status'  => $status_code,
                'message' => '...',
                'error'   => array(
                    'description'  => '...'
                )
            );
        } else if ("Cannot find a page or resource - Query returns null") {
            $status_code = 404;
            $response = array(
                'status'  => $status_code,
                'message' => '...',
                'error'   => array(
                    'description'  => '...'
                )
            );
        } else {
            $status_code = 201;
            $response = array(
                'status'  => $status_code,
                'message' => '...',
                'data'    => array()
            );
        }
    }
    
    return new WP_REST_Response($response, $status_code);
}
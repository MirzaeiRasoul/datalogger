<?php

$namespace = 'v1';
add_action('rest_api_init', 'register_routes');

function register_routes()
{
    global $namespace;

    // Register Tractor API(s)
    register_rest_route($namespace, 'tractors', ['methods' => 'GET', 'callback' => 'get_all_tractors']);
    register_rest_route($namespace, 'tractors/(?P<id>\d+)', ['methods' => 'GET', 'callback' => 'get_tractor_by_post_id']);

    // Register Sensor API(s)
    register_rest_route($namespace, 'tractors/(?P<id>\d+)/sensors', ['methods' => 'GET', 'callback' => 'get_tractor_all_sensors_by_post_id']);
    register_rest_route($namespace, 'tractors/(?P<id>\d+)/sensors', ['methods' => 'PUT', 'callback' => 'update_tractor_sensor_by_sensor_name']);
}

/* GET: Callback for get all tractors
****************************************************************************************************/
function get_all_tractors()
{
    global $wpdb; // Global wordpress database class
    $table_name = $wpdb->prefix . 'posts'; // wp_posts
    $query = "
        SELECT * FROM $table_name
        WHERE post_type = 'tractor'
        ORDER BY post_date DESC
    ";
    $tractors = $wpdb->get_results($query);

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

    $response = array(
        'success' => true,
        'message' => '...',
        'data' => $data
    );
    return $response;
}

/* GET: Callback for get a single tractor
****************************************************************************************************/
function get_tractor_by_post_id($request)
{
    global $wpdb;
    $request->get_param('id');
    $table_name = $wpdb->prefix . 'posts'; // wp_posts
    $tractor_id = $request->get_param('id');;
    $query = "
        SELECT * FROM $table_name
        WHERE ID = $tractor_id
    ";
    $tractor = $wpdb->get_results($query);

    $data = array(
        'id' => $tractor[0]->ID,
        'title' => $tractor[0]->post_title,
        'content' => $tractor[0]->post_content,
        'excerpt' => $tractor[0]->post_excerpt,
    );

    $response = array(
        'success' => true,
        'message' => '...',
        'data' => $data
    );
    return $response;
}

/* GET: Callback for get all sensors of a tractor
****************************************************************************************************/
function get_tractor_all_sensors_by_post_id($request)
{
    global $wpdb;
    $request->get_param('id');
    $table_name = $wpdb->prefix . 'sensors'; // wp_sensors
    $post_id = $request->get_param('id');;
    $query = "
        SELECT * FROM $table_name
        WHERE post_id = $post_id
    ";
    $sensors = $wpdb->get_results($query);

    foreach ($sensors as $sensor) {
        $data[] = array(
            'id' => $sensor->sensor_id,
            'name' => $sensor->sensor_name,
            'persianName' => $sensor->sensor_persian_name,
            'value' => $sensor->sensor_value,
            'date' => $sensor->sensor_date,
            'modified' => $sensor->sensor_modified
        );
    }

    $response = array(
        'success' => true,
        'message' => '...',
        'data' => $data
    );
    return $response;
}

/* PUT: Callback for update a single sensor of a single tractor by sensor_name
****************************************************************************************************/
function update_tractor_sensor_by_sensor_name($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'sensors'; // wp_sensors
    $post_id = $request->get_param('id');
    $sensor_name = $request->get_param('sensor_name');
    $sensor_value = $request->get_param('sensor_value');
    $now = current_time('mysql');

    $response = array();
    if (isset($post_id, $sensor_name, $sensor_value)) {
        $query_result = $wpdb->update(
            $table_name,
            array('sensor_value' => $sensor_value, 'sensor_modified' => $now), // Values
            array('post_id' => $post_id, 'sensor_name' => $sensor_name) // Where
        );

        if ($query_result) {
            $response = array(
                'success' => true,
                'message' => 'Record updated successfully.',
                'data' => array(
                    'numberOfUpdatedRecords' => $query_result
                )
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Update record is failed.',
                'error' => array(
                    'code' => 'record_not_exists',
                    'detail' => $query_result ? $wpdb->last_error : 'Record does not exist with id: ' . $post_id,
                    'solution' => ''
                )
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Required parameter(s) missing.',
            'error' => array(
                'code' => 'missing_param',
                'detail' => 'This request need parameters: sensor_name and sensor_value',
                'solution' => ''
            )
        );
    }
    return $response;
}

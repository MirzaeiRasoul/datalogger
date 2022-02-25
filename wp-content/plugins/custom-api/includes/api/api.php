<?php

$namespace = 'v1';
add_action('rest_api_init', 'register_routes');

function register_routes()
{
    global $namespace;

    // Register Tractor API(s)
    register_rest_route($namespace, 'tractors', ['methods' => 'GET', 'callback' => 'get_all_tractors']);
    register_rest_route($namespace, 'tractors/(?P<id>\d+)', ['methods' => 'GET', 'callback' => 'get_tractor_by_post_id']);

    // Register Custom Meta API(s)
    register_rest_route($namespace, 'tractors/(?P<id>\d+)/meta', ['methods' => 'GET', 'callback' => 'get_tractor_custommeta_by_post_id']);
    register_rest_route($namespace, 'tractors/(?P<id>\d+)/meta', ['methods' => 'PUT', 'callback' => 'update_tractor_custommeta_by_post_id']);
}

/* GET: Callback for get all tractors
****************************************************************************************************/
function get_all_tractors()
{
    global $wpdb; // Global wordpress database class
    $table_name = $wpdb->prefix . 'posts'; // wp_posts

    $query = "SELECT * FROM $table_name WHERE post_type = 'tractor' ORDER BY post_date DESC";
    $tractors = $wpdb->get_results($query);

    foreach ($tractors as $tractor) {
        $tractor_meta = $wpdb->get_results("SELECT * FROM wp_custommeta WHERE post_id = " . $tractor->ID);

        $meta_data = array(
            'post_city'                 => $tractor_meta->post_city,
            'post_location'             => $tractor_meta->post_location,
            'sensor_water_temperature'  => $tractor_meta->sensor_water_temperature,
            'sensor_differential_lock'  => $tractor_meta->sensor_differential_lock,
            'sensor_oil_pressure'       => $tractor_meta->sensor_oil_pressure,
            'sensor_battery_charge'     => $tractor_meta->sensor_battery_charge,
            'sensor_air'                => $tractor_meta->sensor_air,
            'sensor_reserved'           => $tractor_meta->sensor_reserved,
        );

        $data[] = array(
            'id'          => $tractor->ID,
            'title'       => $tractor->post_title,
            'content'     => $tractor->post_content,
            'permalink'   => get_the_permalink($tractor->ID),
            'meta'        => $meta_data
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
    $table_name = $wpdb->prefix . 'posts'; // wp_posts
    $post_id = $request->get_param('id');

    $query = "SELECT * FROM $table_name WHERE ID = $post_id";
    $tractor = $wpdb->get_results($query);
    $tractor_meta = $wpdb->get_results("SELECT * FROM wp_custommeta WHERE post_id = " . $tractor->ID);

    $meta_data = array(
        'post_city'                 => $tractor_meta->post_city,
        'post_location'             => $tractor_meta->post_location,
        'sensor_water_temperature'  => $tractor_meta->sensor_water_temperature,
        'sensor_differential_lock'  => $tractor_meta->sensor_differential_lock,
        'sensor_oil_pressure'       => $tractor_meta->sensor_oil_pressure,
        'sensor_battery_charge'     => $tractor_meta->sensor_battery_charge,
        'sensor_air'                => $tractor_meta->sensor_air,
        'sensor_reserved'           => $tractor_meta->sensor_reserved,
    );

    $data = array(
        'id'        => $tractor[0]->ID,
        'title'     => $tractor[0]->post_title,
        'content'   => $tractor[0]->post_content,
        'excerpt'   => $tractor[0]->post_excerpt,
        'meta'      => $meta_data
    );

    $response = array(
        'success' => true,
        'message' => '...',
        'data' => $data
    );

    return $response;
}

/* GET: Callback for get custom meta of a single tractor
****************************************************************************************************/
function get_tractor_custommeta_by_post_id($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'custommeta'; // wp_custommeta

    $post_id = $request->get_param('id');

    $query = "SELECT * FROM $table_name WHERE post_id = $post_id";
    $tractor_meta = $wpdb->get_results($query);

    $data = array(
        'post_city'                 => $tractor_meta->post_city,
        'post_location'             => $tractor_meta->post_location,
        'sensor_water_temperature'  => $tractor_meta->sensor_water_temperature,
        'sensor_differential_lock'  => $tractor_meta->sensor_differential_lock,
        'sensor_oil_pressure'       => $tractor_meta->sensor_oil_pressure,
        'sensor_battery_charge'     => $tractor_meta->sensor_battery_charge,
        'sensor_air'                => $tractor_meta->sensor_air,
        'sensor_reserved'           => $tractor_meta->sensor_reserved,
        'meta_date'                 => $tractor_meta->meta_date,
        'meta_modified'             => $tractor_meta->meta_modified,

    );

    $response = array(
        'success' => true,
        'message' => '...',
        'data' => $data
    );

    return $response;
}

/* PUT: Callback for update custom meta of a single tractor
****************************************************************************************************/
function update_tractor_custommeta_by_post_id($request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'custommeta'; // wp_custommeta

    $post_id = $request->get_param('id');
    $post_city = $request->get_param('post_city');
    $post_location = $request->get_param('post_location');
    // $sensor_water_temperature = $request->get_param('sensor_water_temperature');
    // $sensor_differential_lock = $request->get_param('sensor_differential_lock');
    // $sensor_oil_pressure = $request->get_param('sensor_oil_pressure');
    // $sensor_battery_charge = $request->get_param('sensor_battery_charge');
    // $sensor_air = $request->get_param('sensor_air');
    // $sensor_reserved = $request->get_param('sensor_reserved');
    $now = current_time('mysql');

    // $response = array();
    if (isset($post_id, $post_city, $post_location)) {
        $query_result = $wpdb->update(
            $table_name,
            array('post_city' => $post_city, 'post_location' => $post_location, 'post_modified' => $now), // Values
            array('post_id' => $post_id) // Where
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

<?php

$version = 'v1';
add_action('rest_api_init', 'register_routes');

function register_routes()
{
    global $version;

    // Register Tractor API(s)
    register_rest_route($version, 'tractors', ['methods' => 'GET', 'callback' => 'read_tractors']);
    register_rest_route($version, 'tractors/(?P<id>\d+)', ['methods' => 'GET', 'callback' => 'read_tractor_by_id']);

    // Register Custom Meta Data API(s)
    register_rest_route($version, 'tractors/(?P<id>\d+)/metadata', ['methods' => 'GET', 'callback' => 'read_metadata_by_id']);
    register_rest_route($version, 'tractors/(?P<id>\d+)/metadata', ['methods' => 'PUT', 'callback' => 'update_metadata_by_id']);
}

/* GET: Callback for get all tractors
****************************************************************************************************/
function read_tractors()
{
    global $wpdb; // Global wordpress database class
    global $version;

    $table_name = $wpdb->prefix . 'posts'; // wp_posts
    $query = "SELECT * FROM $table_name WHERE post_type = 'tractor' ORDER BY post_date DESC";
    $tractors = $wpdb->get_results($query);

    if ($wpdb->num_rows) {
        foreach ($tractors as $tractor) {
            $data[] = array(
                'id'        => $tractor->ID,
                'title'     => $tractor->post_title,
                'content'   => $tractor->post_content,
                'permalink' => get_the_permalink($tractor->ID),
                'metadata'  => site_url() . "/" . rest_get_url_prefix() . "/$version/tractors/$tractor->ID/metadata/"
            );
        }
        $status_code = 200;
        $response = array(
            'status' => $status_code,
            'data'   => $data
        );
    } else {
        $status_code = 404;
        $response = array(
            'status' => $status_code,
            'error'  => array(
                'message' => __('Tractors not Found!.', 'datalogger-api'),
                'detail'  => $wpdb->last_error
            )
        );
    }

    return new WP_REST_Response($response, $status_code);
}

/* GET: Callback for get a tractor
****************************************************************************************************/
function read_tractor_by_id(WP_REST_Request $request)
{
    global $wpdb;
    global $version;
    $post_id = $request->get_param('id');

    $table_name = $wpdb->prefix . 'posts'; // wp_posts
    $query = "SELECT * FROM $table_name WHERE ID = $post_id";
    $tractor = $wpdb->get_results($query);

    if ($wpdb->num_rows) {
        $data = array(
            'id'       => $post_id,
            'title'    => $tractor[0]->post_title,
            'content'  => $tractor[0]->post_content,
            'excerpt'  => $tractor[0]->post_excerpt,
            'metadata' => site_url() . "/" . rest_get_url_prefix() . "/$version/tractors/$post_id/metadata/"
        );
        $status_code = 200;
        $response = array(
            'status' => $status_code,
            'data'   => $data
        );
    } else {
        $status_code = 404;
        $response = array(
            'status' => $status_code,
            'error'  => array(
                'message' => __('Tractor not Found!.', 'datalogger-api'),
                'detail'  => $wpdb->last_error
            )
        );
    }

    return new WP_REST_Response($response, $status_code);
}

/* GET: Callback for get custom metadata of a tractor
****************************************************************************************************/
function read_metadata_by_id(WP_REST_Request $request)
{
    global $wpdb;
    $post_id = $request->get_param('id');

    $table_name = $wpdb->prefix . 'custom_meta'; // wp_custom_meta
    $query = "SELECT * FROM $table_name WHERE post_id = $post_id";
    $tractor_meta = $wpdb->get_results($query);

    if ($wpdb->num_rows) {
        $post_coordinates = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $tractor_meta[0]->post_geo_location);
        $data = array(
            'post_id'                  => $post_id,
            'post_city'                => $tractor_meta[0]->post_city,
            'post_geo_location'        => $post_coordinates['lat'] . ', ' . $post_coordinates['lon'],
            'sensor_water_temperature' => $tractor_meta[0]->sensor_water_temperature,
            'sensor_differential_lock' => $tractor_meta[0]->sensor_differential_lock,
            'sensor_oil_pressure'      => $tractor_meta[0]->sensor_oil_pressure,
            'sensor_battery_charge'    => $tractor_meta[0]->sensor_battery_charge,
            'sensor_air'               => $tractor_meta[0]->sensor_air,
            'sensor_reserved'          => $tractor_meta[0]->sensor_reserved,
            'meta_date'                => $tractor_meta[0]->meta_date,
            'meta_modified'            => $tractor_meta[0]->meta_modified,
            'meta_active'              => $tractor_meta[0]->meta_active
        );
        $status_code = 200;
        $response = array(
            'status' => $status_code,
            'data'   => $data
        );
    } else {
        $status_code = 404;
        $response = array(
            'status' => $status_code,
            'error'  => array(
                'message' => __('Metadata not Found!.', 'datalogger-api'),
                'detail'  => $wpdb->last_error
            )
        );
    }

    return new WP_REST_Response($response, $status_code);
}

/* PUT: Callback for update custom metadata of a tractor
****************************************************************************************************/
function update_metadata_by_id(WP_REST_Request $request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_meta'; // wp_custom_meta

    $post_id = $request->get_param('id');
    $post_city = $request->get_param('post_city');
    $post_geo_lat = $request->get_param('post_geo_lat');
    $post_geo_long = $request->get_param('post_geo_long');
    $sensor_water_temperature = $request->get_param('sensor_water_temperature');
    $sensor_oil_pressure = $request->get_param('sensor_oil_pressure');
    $sensor_differential_lock = $request->get_param('sensor_differential_lock');
    $sensor_battery_charge = $request->get_param('sensor_battery_charge');
    $sensor_air = $request->get_param('sensor_air');
    $meta_active = $request->get_param('meta_active');

    if (isset($post_city) || isset($post_geo_lat, $post_geo_long) || isset($sensor_water_temperature) || isset($sensor_oil_pressure) || isset($sensor_differential_lock) || isset($sensor_battery_charge) || isset($sensor_air) || isset($meta_active)) {
        $now = current_time('mysql');
        $query = "UPDATE $table_name SET meta_modified = '$now'";

        // Optional params
        isset($post_city) ? $query .= ", post_city = '$post_city'" : "";
        isset($post_geo_lat, $post_geo_long) ? $query .= ", post_geo_location = POINT($post_geo_lat,$post_geo_long)" : "";
        isset($sensor_water_temperature) ? $query .= ", sensor_water_temperature = '$sensor_water_temperature'" : "";
        isset($sensor_oil_pressure) ? $query .= ", sensor_oil_pressure = '$sensor_oil_pressure'" : "";
        isset($sensor_differential_lock) ? $query .= ", sensor_differential_lock = '$sensor_differential_lock'" : "";
        isset($sensor_battery_charge) ? $query .= ", sensor_battery_charge = '$sensor_battery_charge'" : "";
        isset($sensor_air) ? $query .= ", sensor_air = '$sensor_air'" : "";
        isset($meta_active) ? $query .= ", meta_active = '$meta_active'" : "";

        $query .= " WHERE post_id = $post_id";
        $query_result = $wpdb->query($query);

        if ($query_result) {
            $status_code = 200;
            $response = array(
                'status' => $status_code,
                'data'   => array(
                    'numberOfUpdatedRecords' => $query_result
                )
            );
        } else {
            $status_code = 404;
            $response = array(
                'status' => $status_code,
                'error'  => array(
                    'message' => 'Update record is failed.',
                    'detail'  => $query_result ? $wpdb->last_error : 'Record does not exist with id: ' . $post_id,
                )
            );
        }
    } else {
        $status_code = 400;
        $response = array(
            'status' => $status_code,
            'error'  => array(
                'message' => 'Required parameter(s) missing.',
                'detail'  => 'This request need parameters. Please enter at least one of the parameters.',
            )
        );
    }

    return new WP_REST_Response($response, $status_code);
}

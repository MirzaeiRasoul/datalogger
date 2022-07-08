<?php

$version = 'v1';
add_action('rest_api_init', 'register_routes');

function register_routes()
{
    global $version;
    // Register Tractor API(s)
    register_rest_route($version, 'tractors', ['methods' => 'GET', 'callback' => 'read_tractors']);
    register_rest_route($version, 'tractors/(?P<id>\d+)', ['methods' => 'GET', 'callback' => 'read_tractor_by_id']);

    // Register Custom Meta Data API(s) for Module
    register_rest_route($version, 'tractors/(?P<id>\d+)/metadata', ['methods' => 'GET', 'callback' => 'read_metadata_by_id']);
    register_rest_route($version, 'tractors/(?P<id>\d+)/metadata', ['methods' => 'POST', 'callback' => 'update_metadata_by_id']);
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
    $tractor_id = $request->get_param('id');

    $table_name = $wpdb->prefix . 'posts'; // wp_posts
    $query = "SELECT * FROM $table_name WHERE ID = $tractor_id";
    $tractors = $wpdb->get_results($query);

    if ($wpdb->num_rows) {
        $tractor = $tractors[0];
        $data = array(
            'id'       => $tractor_id,
            'title'    => $tractor->post_title,
            'content'  => $tractor->post_content,
            'excerpt'  => $tractor->post_excerpt,
            'metadata' => site_url() . "/" . rest_get_url_prefix() . "/$version/tractors/$tractor_id/metadata/"
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
    $tractor_id = $request->get_param('id');

    $table_name = $wpdb->prefix . 'tractor_meta'; // wp_tractor_meta
    $query = "SELECT * FROM $table_name WHERE tractor_id = $tractor_id";
    $tractors_meta = $wpdb->get_results($query);

    if ($wpdb->num_rows) {
        $tractor_meta = $tractors_meta[0];
        $status_code = 200;
        $response = array(
            't_id'          => $tractor_id,
            't_name'        => $tractor_meta->tractor_name,
            't_city'        => $tractor_meta->tractor_city,
            'gprs_lat'      => $tractor_meta->tractor_gprs_latitude,
            'gprs_long'     => $tractor_meta->tractor_gprs_longitude,
            'gps_lat'       => $tractor_meta->tractor_gps_latitude,
            'gps_long'      => $tractor_meta->tractor_gps_longitude,
            'gps_alt'       => $tractor_meta->tractor_gps_altitude,
            'gps_sp'        => $tractor_meta->tractor_gps_speed,
            's_d1'          => $tractor_meta->sensor_water_temperature,
            's_d2'          => $tractor_meta->sensor_oil_pressure,
            's_d3'          => $tractor_meta->sensor_differential_lock,
            's_d4'          => $tractor_meta->sensor_battery_charge,
            's_d5'          => $tractor_meta->sensor_air,
            's_d6'          => $tractor_meta->sensor_reserved_1,
            's_d7'          => $tractor_meta->sensor_reserved_2,
            's_a1'          => $tractor_meta->sensor_battery_voltage,
            's_a2'          => $tractor_meta->sensor_performance,
            's_a3'          => $tractor_meta->sensor_reserved_3,
            'msg_num'       => $tractor_meta->message_number,
            'st_stat'       => $tractor_meta->sample_start_status,
            'sms_stat'      => $tractor_meta->sms_sending_status,
            'err_stat'      => $tractor_meta->tractor_error_status,
            'he_stat'       => $tractor_meta->tractor_health_status,
            'net_stat'      => $tractor_meta->tractor_network_status,
            'act_stat'      => $tractor_meta->tractor_active_status,
            'samp_dt'       => $tractor_meta->sampling_datetime,
            'm_dt'          => $tractor_meta->meta_datetime,
            'm_mdf'         => $tractor_meta->meta_modified
        );
    } else {
        $status_code = 404;
        $response = array(
            'error_message' => __('Metadata not Found!.', 'datalogger-api'),
            'error_detail'  => $wpdb->last_error
        );
    }

    return new WP_REST_Response($response, $status_code);
}

/* POST: Callback for update custom metadata of a tractor
****************************************************************************************************/
function update_metadata_by_id(WP_REST_Request $request)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'tractor_meta'; // wp_tractor_meta

    $tractor_id = $request->get_param('id');
    $tractor_city = $request->get_param('t_city');
    $tractor_gprs_latitude = $request->get_param('gprs_lat');
    $tractor_gprs_longitude = $request->get_param('gprs_long');
    $tractor_gps_latitude = $request->get_param('gps_lat');
    $tractor_gps_longitude = $request->get_param('gps_long');
    $tractor_gps_altitude = $request->get_param('gps_alt');
    $tractor_gps_speed = $request->get_param('gps_sp');
    $sensor_water_temperature = $request->get_param('s_d1');
    $sensor_oil_pressure = $request->get_param('s_d2');
    $sensor_differential_lock = $request->get_param('s_d3');
    $sensor_battery_charge = $request->get_param('s_d4');
    $sensor_air = $request->get_param('s_d5');
    $sensor_reserved_1 = $request->get_param('s_d6');
    $sensor_reserved_2 = $request->get_param('s_d7');
    $sensor_battery_voltage = $request->get_param('s_a1');
    $sensor_performance = $request->get_param('s_a2');
    $sensor_reserved_3 = $request->get_param('s_a3');
    $message_number = $request->get_param('msg_num');
    $sample_start_status = $request->get_param('st_stat');
    $sms_sending_status = $request->get_param('sms_stat');
    $tractor_error_status = $request->get_param('err_stat');
    $tractor_health_status = $request->get_param('he_stat');
    $tractor_network_status = $request->get_param('net_stat');
    $tractor_active_status = $request->get_param('act_stat');
    $sampling_datetime = $request->get_param('samp_dt');

    if (isset($sampling_datetime)) {
        $now = current_time('mysql');
        $query = "UPDATE $table_name SET sampling_datetime = '$sampling_datetime', meta_modified = '$now'";

        // Optional params
        isset($tractor_city) ? $query .= ", tractor_city = '$tractor_city'" : "";
        isset($tractor_gprs_latitude) ? $query .= ", tractor_gprs_latitude = '$tractor_gprs_latitude'" : "";
        isset($tractor_gprs_longitude) ? $query .= ", tractor_gprs_longitude = '$tractor_gprs_longitude'" : "";
        isset($tractor_gps_latitude) ? $query .= ", tractor_gps_latitude = '$tractor_gps_latitude'" : "";
        isset($tractor_gps_longitude) ? $query .= ", tractor_gps_longitude = '$tractor_gps_longitude'" : "";
        isset($tractor_gps_altitude) ? $query .= ", tractor_gps_altitude = '$tractor_gps_altitude'" : "";
        isset($tractor_gps_speed) ? $query .= ", tractor_gps_speed = '$tractor_gps_speed'" : "";
        isset($sensor_water_temperature) ? $query .= ", sensor_water_temperature = '$sensor_water_temperature'" : "";
        isset($sensor_oil_pressure) ? $query .= ", sensor_oil_pressure = '$sensor_oil_pressure'" : "";
        isset($sensor_differential_lock) ? $query .= ", sensor_differential_lock = '$sensor_differential_lock'" : "";
        isset($sensor_battery_charge) ? $query .= ", sensor_battery_charge = '$sensor_battery_charge'" : "";
        isset($sensor_air) ? $query .= ", sensor_air = '$sensor_air'" : "";
        isset($sensor_reserved_1) ? $query .= ", sensor_reserved_1 = '$sensor_reserved_1'" : "";
        isset($sensor_reserved_2) ? $query .= ", sensor_reserved_2 = '$sensor_reserved_2'" : "";
        isset($sensor_battery_voltage) ? $query .= ", sensor_battery_voltage = '$sensor_battery_voltage'" : "";
        isset($sensor_performance) ? $query .= ", sensor_performance = '$sensor_performance'" : "";
        isset($sensor_reserved_3) ? $query .= ", sensor_reserved_3 = '$sensor_reserved_3'" : "";
        isset($message_number) ? $query .= ", message_number = '$message_number'" : "";
        isset($sample_start_status) ? $query .= ", sample_start_status = '$sample_start_status'" : "";
        isset($sms_sending_status) ? $query .= ", sms_sending_status = '$sms_sending_status'" : "";
        isset($tractor_error_status) ? $query .= ", tractor_error_status = '$tractor_error_status'" : "";
        isset($tractor_health_status) ? $query .= ", tractor_health_status = '$tractor_health_status'" : "";
        isset($tractor_network_status) ? $query .= ", tractor_network_status = '$tractor_network_status'" : "";
        isset($tractor_active_status) ? $query .= ", tractor_active_status = '$tractor_active_status'" : "";

        $query .= " WHERE tractor_id = $tractor_id";
        $query_result = $wpdb->query($query);

        if ($query_result) {
            // Add logs of update metadata to wp_tractor_meta_log table
            $log_table_name = $wpdb->prefix . 'tractor_meta_log'; // wp_tractor_meta_log
            $query_fields = "tractor_id, sampling_datetime, log_datetime";
            $query_values = "$tractor_id, '$sampling_datetime', '$now'";

            // Optional params
            if (isset($tractor_gprs_latitude)) {
                $query_fields .= ", tractor_gprs_latitude";
                $query_values .= ", $tractor_gprs_latitude";
            }
            if (isset($tractor_gprs_longitude)) {
                $query_fields .= ", tractor_gprs_longitude";
                $query_values .= ", $tractor_gprs_longitude";
            }
            if (isset($tractor_gps_latitude)) {
                $query_fields .= ", tractor_gps_latitude";
                $query_values .= ", $tractor_gps_latitude";
            }
            if (isset($tractor_gps_longitude)) {
                $query_fields .= ", tractor_gps_longitude";
                $query_values .= ", $tractor_gps_longitude";
            }
            if (isset($tractor_gps_altitude)) {
                $query_fields .= ", tractor_gps_altitude";
                $query_values .= ", $tractor_gps_altitude";
            }
            if (isset($tractor_gps_speed)) {
                $query_fields .= ", tractor_gps_speed";
                $query_values .= ", $tractor_gps_speed";
            }
            if (isset($sensor_water_temperature)) {
                $query_fields .= ", sensor_water_temperature";
                $query_values .= ", $sensor_water_temperature";
            }
            if (isset($sensor_oil_pressure)) {
                $query_fields .= ", sensor_oil_pressure";
                $query_values .= ", $sensor_oil_pressure";
            }
            if (isset($sensor_differential_lock)) {
                $query_fields .= ", sensor_differential_lock";
                $query_values .= ", $sensor_differential_lock";
            }
            if (isset($sensor_battery_charge)) {
                $query_fields .= ", sensor_battery_charge";
                $query_values .= ", $sensor_battery_charge";
            }
            if (isset($sensor_air)) {
                $query_fields .= ", sensor_air";
                $query_values .= ", $sensor_air";
            }
            if (isset($sensor_reserved_1)) {
                $query_fields .= ", sensor_reserved_1";
                $query_values .= ", $sensor_reserved_1";
            }
            if (isset($sensor_reserved_2)) {
                $query_fields .= ", sensor_reserved_2";
                $query_values .= ", $sensor_reserved_2";
            }
            if (isset($sensor_battery_voltage)) {
                $query_fields .= ", sensor_battery_voltage";
                $query_values .= ", $sensor_battery_voltage";
            }
            if (isset($sensor_performance)) {
                $query_fields .= ", sensor_performance";
                $query_values .= ", $sensor_performance";
            }
            if (isset($sensor_reserved_3)) {
                $query_fields .= ", sensor_reserved_3";
                $query_values .= ", $sensor_reserved_3";
            }
            if (isset($message_number)) {
                $query_fields .= ", message_number";
                $query_values .= ", $message_number";
            }
            if (isset($sample_start_status)) {
                $query_fields .= ", sample_start_status";
                $query_values .= ", $sample_start_status";
            }
            if (isset($sms_sending_status)) {
                $query_fields .= ", sms_sending_status";
                $query_values .= ", $sms_sending_status";
            }
            if (isset($tractor_error_status)) {
                $query_fields .= ", tractor_error_status";
                $query_values .= ", $tractor_error_status";
            }
            if (isset($tractor_health_status)) {
                $query_fields .= ", tractor_health_status";
                $query_values .= ", $tractor_health_status";
            }
            if (isset($tractor_network_status)) {
                $query_fields .= ", tractor_network_status";
                $query_values .= ", $tractor_network_status";
            }
            if (isset($tractor_active_status)) {
                $query_fields .= ", tractor_active_status";
                $query_values .= ", $tractor_active_status";
            }

            $log_query = "INSERT INTO $log_table_name ($query_fields) VALUES ($query_values)";
            $wpdb->query($log_query);

            $status_code = 200;
            $response = array(
                'numberOfUpdatedRecords' => $query_result
            );
        } else {
            $status_code = 404;
            $response = array(
                'error_message' => 'Update record is failed.',
                'error_detail'  => $query_result ? $wpdb->last_error : 'Record does not exist with id: ' . $tractor_id,
            );
        }
    } else {
        $status_code = 400;
        $response = array(
            'error_message' => 'Required parameter(s) missing.',
            'error_detail'  => 'This request need parameters. Please enter at least sampling_datetime parameter.',
        );
    }

    return new WP_REST_Response($response, $status_code);
}

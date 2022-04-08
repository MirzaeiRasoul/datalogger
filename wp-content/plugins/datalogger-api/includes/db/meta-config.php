<?php

/* INSERT DATA: Function for create tractor meta datas
****************************************************************************************************/
function create_custom_meta_data($post_id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_meta'; // wp_custom_meta

    $tehran_lat = 35.6891975;
    $tehran_long = 51.3889736;
    $now = current_time('mysql');

    $query = "INSERT INTO $table_name (post_id, post_geo_location, meta_date, meta_modified) VALUES ($post_id, POINT($tehran_lat,$tehran_long), '$now', '$now')";

    $wpdb->query($query);
}

// A {status}_{post_type} action will execute when a post of type {post_type} transitions to {status} from any other status.
// Reference: https://codex.wordpress.org/Post_Status_Transitions
add_action('publish_tractor', 'create_custom_meta_data');

/* DELETE DATA: Function for delete tractor meta datas
****************************************************************************************************/
function delete_custom_meta_data($post_id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_meta'; // wp_custom_meta

    $query = "DELETE FROM $table_name WHERE post_id = $post_id";
    $wpdb->query($query);
}

add_action('delete_post', 'delete_custom_meta_data');

<?php

/* INSERT DATA: Function for create tractor meta datas
****************************************************************************************************/
function create_tractor_meta_data($post_id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'tractor_meta'; // wp_tractor_meta

    $tractor_name = get_post_field('post_title', $post_id);
    $now = current_time('mysql');

    $query = "INSERT INTO $table_name (tractor_id, tractor_name, meta_datetime, meta_modified) VALUES ($post_id, '$tractor_name', '$now', '$now')";
    $wpdb->query($query);
}

// A {status}_{post_type} action will execute when a post of type {post_type} transitions to {status} from any other status.
// Reference: https://codex.wordpress.org/Post_Status_Transitions
add_action('publish_tractor', 'create_tractor_meta_data');

/* DELETE DATA: Function for delete tractor meta datas
****************************************************************************************************/
function delete_tractor_meta_data($post_id)
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'tractor_meta'; // wp_tractor_meta

    $query = "DELETE FROM $table_name WHERE tractor_id = $post_id";
    $wpdb->query($query);
}

add_action('delete_post', 'delete_tractor_meta_data');

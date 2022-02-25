<?php

function add_sensors_box()
{
    global $post;
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_awesome_nonce', 'awesome_nonce');
    $checkbox_fields = get_post_meta($post->ID);
?>
    <p>
        <input type="checkbox" name="sensor_1" value="Active" <?php if (isset($checkbox_fields['sensor_1'])) checked($checkbox_fields['sensor_1'][0], 'Active'); ?>>
        <label for="sensor_1"> <?php _e('Sensor One', 'custom-api') ?> </label>
    </p>
    <p>
        <input type="checkbox" name="sensor_2" value="Active" <?php if (isset($checkbox_fields['sensor_2'])) checked($checkbox_fields['sensor_2'][0], 'Active'); ?>>
        <label for="sensor_2"> <?php _e('Sensor Two', 'custom-api') ?> </label>
    </p>
<?php }

function add_custom_meta_boxes()
{
    add_meta_box('list-of-sensors', __('List of Sensors', 'custom-api'), 'add_sensors_box', 'tractor', 'side', 'high');
}

add_action('add_meta_boxes', 'add_custom_meta_boxes');

function save_meta_fields($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    if ((isset($_POST['my_awesome_nonce'])) && (!wp_verify_nonce($_POST['my_awesome_nonce'], plugin_basename(__FILE__))))
        return $post_id;
    if ((isset($_POST['post_type'])) && ('page' == $_POST['post_type'])) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    }

    // Save Sensor 1 value
    isset($_POST['sensor_1']) ? update_post_meta($post_id, 'sensor_1', "Active") : update_post_meta($post_id, 'sensor_1', "Inactive");

    // Save Sensor 2 value
    isset($_POST['sensor_2']) ? update_post_meta($post_id, 'sensor_2', "Active") : update_post_meta($post_id, 'sensor_2', "Inactive");
}

add_action('save_post', 'save_meta_fields');

<?php

function add_tractor_meta_boxes($post)
{
    add_meta_box('tractor_sensors_meta_box', __('Sensors', 'custom-api'), 'build_tractor_meta_box', 'tractor', 'side', 'high');
}

add_action('add_meta_boxes', 'add_tractor_meta_boxes');

function build_tractor_meta_box($post)
{
    // make sure the form request comes from WordPress
    wp_nonce_field(basename(__FILE__), 'tractor_meta_box_nonce');

    $sensors = array(__('Sensor 1', 'custom-api'), __('Sensor 2', 'custom-api'), __('Sensor 3', 'custom-api'), __('Sensor 4', 'custom-api'), __('Vehicle Performance', 'custom-api'), __('Vehicle Location', 'custom-api'));

    // stores _tractor_sensors array 
    $current_sensors = (get_post_meta($post->ID, '_tractor_sensors', true)) ? get_post_meta($post->ID, '_tractor_sensors', true) : array();

?>
    <div class="sensors-container">
        <?php foreach ($sensors as $sensor) { ?>
            <div class="sensor-box-item">
                <input type="checkbox" name="sensors[]" value="<?php echo $sensor; ?>" <?php checked((in_array($sensor, $current_sensors)) ? $sensor : '', $sensor); ?> />
                <span><?php echo $sensor; ?></span>
            </div>
        <?php } ?>
    </div>
<?php
}

function save_tractor_meta_box_data($post_id)
{
    // verify meta box nonce
    if (!isset($_POST['tractor_meta_box_nonce']) || !wp_verify_nonce($_POST['tractor_meta_box_nonce'], basename(__FILE__))) {
        return;
    }

    // return if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // store custom fields values
    // sensors array
    if (isset($_POST['sensors'])) {
        $sensors = (array) $_POST['sensors'];

        // sinitize array
        $sensors = array_map('sanitize_text_field', $sensors);

        // save data
        update_post_meta($post_id, '_tractor_sensors', $sensors);
    } else {
        // delete data
        delete_post_meta($post_id, '_tractor_sensors');
    }
}

add_action('save_post', 'save_tractor_meta_box_data');

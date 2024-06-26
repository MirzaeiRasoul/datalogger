<?php

/* Create meta box views
****************************************************************************************************/
function add_post_active_meta($post)
{
    add_meta_box('active_meta_box', __('Tractor Status', 'datalogger-api'), 'create_active_meta_box', 'tractor', 'side', 'high');
}

function create_active_meta_box($post)
{
    // make sure the form request comes from WordPress
    wp_nonce_field(basename(__FILE__), 'active_meta_box_nonce');

    // Read tractor_active_status status from wp_tractor_meta table
    global $wpdb;
    $table_name = $wpdb->prefix . 'tractor_meta'; // wp_tractor_meta

    $query = "SELECT tractor_active_status FROM $table_name WHERE tractor_id = $post->ID";
    $active_meta = $wpdb->get_var($query);
?>
    <div class="active-meta-box-container">
        <div class="active-meta-box-item">
            <label for="active-meta"><?php echo __('Active', 'datalogger-api'); ?></label>
            <input type="checkbox" id="active-meta" name="active-meta" <?php echo $active_meta ? 'checked' : ''; ?> />
        </div>
    </div>
<?php
}

add_action('add_meta_boxes', 'add_post_active_meta');

/* Check and update meta box data
****************************************************************************************************/
function save_meta_data($post_id)
{
    // verify meta box nonce
    if (!isset($_POST['active_meta_box_nonce']) || !wp_verify_nonce($_POST['active_meta_box_nonce'], basename(__FILE__))) return;

    // return if autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) return;

    // Update tractor_active_status status in wp_tractor_meta table
    global $wpdb;
    $table_name = $wpdb->prefix . 'tractor_meta'; // wp_tractor_meta

    $new_active_meta_box = $_POST['active-meta'];
    isset($new_active_meta_box) ? $new_tractor_active_status = 1 : $new_tractor_active_status = 0;

    $query = "UPDATE $table_name SET tractor_active_status = $new_tractor_active_status WHERE tractor_id = $post_id";
    $wpdb->query($query);
}

add_action('save_post', 'save_meta_data');

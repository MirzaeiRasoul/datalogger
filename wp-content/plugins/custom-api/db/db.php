<?php

function create_tractors_table() // Best Practices
{
    global $wpdb; // Global wordpress database class
    $table_name = $wpdb->prefix . 'tractors2'; // wp-tractors
    $table_charset = 'DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci'; // Default is $wpdb->get_charset_collate()

    $sql = "CREATE TABLE IF NOT EXISTS $table_name
    ( 
        id          INT(10) NOT NULL AUTO_INCREMENT,
        code        INT(10) NOT NULL,
        city        VARCHAR(30) NOT NULL,
        model       VARCHAR(40) NOT NULL,
        PRIMARY KEY (id)
    ) $table_charset;";

    // Rather than executing an SQL query directly, we'll use the dbDelta function in wp-admin/includes/upgrade.php (we'll have to load this file, as it is not loaded by default). The dbDelta function examines the current table structure, compares it to the desired table structure, and either adds or modifies the table as necessary.
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(CUSTOM_API_FILE, 'create_tractors_table'); // Run function on plugin activation

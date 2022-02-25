<?php

// function create_tractors_table()
// {
//     global $wpdb;
//     $table_charset = 'DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci';
//     $table_name = $wpdb->prefix . 'tractors'; // wp-tractors
//     $query = "CREATE TABLE IF NOT EXISTS $table_name ( 
//         id          INT(10) NOT NULL AUTO_INCREMENT,
//         code        INT(10) NOT NULL,
//         city        VARCHAR(30) NOT NULL,
//         model       VARCHAR(40) NOT NULL,
//         PRIMARY KEY  (id))
//     $table_charset;";

//     // Rather than executing an SQL query directly, we'll use the dbDelta function in wp-admin/includes/upgrade.php (we'll have to load this file, as it is not loaded by default). The dbDelta function examines the current table structure, compares it to the desired table structure, and either adds or modifies the table as necessary.
//     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//     dbDelta($query);
// }

// function test_bulk_insert_data()
// {
//     global $wpdb;
//     $table_name = $wpdb->prefix . 'sensors'; // wp-sensors
//     $rows = array(
//         array(
//             'id'        => '1',
//             'name'      => 'matt',
//             'age'       => '20',
//             'point_one' => '0.45',
//             'point_two' => '0.22'
//         ),
//         array(
//             'id'        => '2',
//             'name'      => 'james',
//             'age'       => '6',
//             'point_one' => '0.27',
//             'point_two' => '0.17'
//         )
//     );
//     foreach ($rows as $row) {
//         $wpdb->insert($table_name, $row);
//     }
// }

// یک جدول با عنوان تراکتور متا که برای هر تراکتور اطلاعات متا مثل مقادیر سنسورها، لوکیشن و غیره را نگه می‌دارد.
function create_sensors_table()
{
    global $wpdb;
    $table_charset = 'DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci';
    $table_name = $wpdb->prefix . 'sensors'; // wp-sensors
    $query = "CREATE TABLE IF NOT EXISTS $table_name (
        sensor_id               bigint(20) unsigned NOT NULL auto_increment,
        post_id                 bigint(20) unsigned NOT NULL,
        sensor_name             varchar(50) NOT NULL,
        sensor_persian_name     varchar(50) NOT NULL,
        sensor_value            longtext NOT NULL,
        sensor_date             datetime NOT NULL default '0000-00-00 00:00:00',
        sensor_modified         datetime NOT NULL default '0000-00-00 00:00:00',
        PRIMARY KEY  (sensor_id),
        UNIQUE KEY post_id_sensor_name (post_id,sensor_name),
        KEY post_id (post_id)
    ) $table_charset;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($query);
}

// register_activation_hook(CUSTOM_API_FILE, 'create_tractors_table'); // Run function on plugin activation
register_activation_hook(CUSTOM_API_FILE, 'create_sensors_table'); // Run function on plugin activation

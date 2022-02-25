<?php

/* CREATE TABLE: Function for create table for store tractor meta datas
****************************************************************************************************/
function create_custommeta_table()
{
    global $wpdb;
    $table_charset = 'DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci';
    $table_name = $wpdb->prefix . 'custommeta'; // wp-custommeta
    $query = "CREATE TABLE IF NOT EXISTS $table_name (
        meta_id                     bigint(20) unsigned NOT NULL auto_increment,
        post_id                     bigint(20) unsigned NOT NULL default '0',
        post_city                   varchar(50) NOT NULL,
        post_location               longtext NOT NULL,
        sensor_water_temperature    BOOLEAN NOT NULL default false,
        sensor_oil_pressure         BOOLEAN NOT NULL default false,
        sensor_differential_lock    BOOLEAN NOT NULL default false,
        sensor_battery_charge       BOOLEAN NOT NULL default false,
        sensor_air                  BOOLEAN NOT NULL default false,
        sensor_reserved             BOOLEAN NOT NULL default false,
        meta_date                   datetime NOT NULL default '0000-00-00 00:00:00',
        meta_modified               datetime NOT NULL default '0000-00-00 00:00:00',
        PRIMARY KEY  (meta_id),
        KEY post_id (post_id)
    ) $table_charset;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($query);
}

/* Run functions on plugin activation
****************************************************************************************************/
register_activation_hook(CUSTOM_API_FILE, 'create_custommeta_table');
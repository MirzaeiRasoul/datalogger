<?php

/* CREATE TABLE: Create table for store tractor meta datas
****************************************************************************************************/
function create_tractor_meta_table()
{
    global $wpdb;
    $table_charset = 'DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci';
    $table_name = $wpdb->prefix . 'tractor_meta'; // wp_tractor_meta
    $query = "CREATE TABLE IF NOT EXISTS $table_name (
        meta_id                     BIGINT(20) UNSIGNED NOT NULL auto_increment,
        tractor_id                  BIGINT(20) UNSIGNED NOT NULL default '0',
        tractor_name                VARCHAR(10) NOT NULL default 'N',
        tractor_city                VARCHAR(100) NOT NULL default 'Tehran',
        tractor_gprs_latitude       DECIMAL(10,8) NOT NULL default 35.6891975,
        tractor_gprs_longitude      DECIMAL(11,8) NOT NULL default 51.3889736,
        tractor_gps_latitude        DECIMAL(10,8) NOT NULL default 0.0,
        tractor_gps_longitude       DECIMAL(11,8) NOT NULL default 0.0,
        tractor_gps_altitude        DECIMAL(12,9) NOT NULL default 0.0,
        tractor_gps_speed           DECIMAL(6,4) NOT NULL default 0.0,
        sensor_water_temperature    BOOLEAN NOT NULL default false,
        sensor_oil_pressure         BOOLEAN NOT NULL default false,
        sensor_differential_lock    BOOLEAN NOT NULL default false,
        sensor_battery_charge       BOOLEAN NOT NULL default false,
        sensor_air                  BOOLEAN NOT NULL default false,
        sensor_reserved_1           BOOLEAN NOT NULL default false,
        sensor_reserved_2           BOOLEAN NOT NULL default false,
        sensor_battery_voltage      DECIMAL(5,2) NOT NULL default 0.0,
        sensor_performance          DECIMAL(5,2) NOT NULL default 0.0,
        sensor_reserved_3           DECIMAL(5,2) NOT NULL default 0.0,
        message_number              SMALLINT(3) UNSIGNED default 0,
        sample_start_status         BOOLEAN NOT NULL default false,
        sms_sending_status          BOOLEAN NOT NULL default false,
        tractor_error_status        SMALLINT(2) UNSIGNED NOT NULL default 0,
        tractor_health_status       SMALLINT(2) UNSIGNED NOT NULL default 0,
        tractor_network_status      SMALLINT(2) UNSIGNED NOT NULL default 0,
        tractor_active_status       BOOLEAN NOT NULL default true,
        sampling_datetime           DATETIME NOT NULL default '0000-00-00 00:00:00',
        meta_datetime               DATETIME NOT NULL default '0000-00-00 00:00:00',
        meta_modified               DATETIME NOT NULL default '0000-00-00 00:00:00',
        PRIMARY KEY  (meta_id),
        UNIQUE KEY tractor_id (tractor_id)
    ) $table_charset;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($query);
}

/* CREATE TABLE: Create table for store tractor meta log datas
****************************************************************************************************/
function create_tractor_meta_log_table()
{
    global $wpdb;
    $table_charset = 'DEFAULT CHARACTER SET utf8 COLLATE utf8_persian_ci';
    $table_name = $wpdb->prefix . 'tractor_meta_log'; // wp_tractor_meta_log
    $query = "CREATE TABLE IF NOT EXISTS $table_name (
        log_id                      BIGINT(20) UNSIGNED NOT NULL auto_increment,
        tractor_id                  BIGINT(20) UNSIGNED NOT NULL default '0',
        tractor_gprs_latitude       DECIMAL(10,8) NOT NULL default 35.6891975,
        tractor_gprs_longitude      DECIMAL(11,8) NOT NULL default 51.3889736,
        tractor_gps_latitude        DECIMAL(10,8) NOT NULL default 0.0,
        tractor_gps_longitude       DECIMAL(11,8) NOT NULL default 0.0,
        tractor_gps_altitude        DECIMAL(12,9) NOT NULL default 0.0,
        tractor_gps_speed           DECIMAL(6,4) NOT NULL default 0.0,
        sensor_water_temperature    BOOLEAN NOT NULL default false,
        sensor_oil_pressure         BOOLEAN NOT NULL default false,
        sensor_differential_lock    BOOLEAN NOT NULL default false,
        sensor_battery_charge       BOOLEAN NOT NULL default false,
        sensor_air                  BOOLEAN NOT NULL default false,
        sensor_reserved_1           BOOLEAN NOT NULL default false,
        sensor_reserved_2           BOOLEAN NOT NULL default false,
        sensor_battery_voltage      DECIMAL(5,2) NOT NULL default 0.0,
        sensor_performance          DECIMAL(5,2) NOT NULL default 0.0,
        sensor_reserved_3           DECIMAL(5,2) NOT NULL default 0.0,
        message_number              SMALLINT(3) UNSIGNED default 0,
        sample_start_status         BOOLEAN NOT NULL default false,
        sms_sending_status          BOOLEAN NOT NULL default false,
        tractor_error_status        SMALLINT(2) UNSIGNED NOT NULL default 0,
        tractor_health_status       SMALLINT(2) UNSIGNED NOT NULL default 0,
        tractor_network_status      SMALLINT(2) UNSIGNED NOT NULL default 0,
        tractor_active_status       BOOLEAN NOT NULL default true,
        sampling_datetime           DATETIME NOT NULL default '0000-00-00 00:00:00',
        log_datetime                DATETIME NOT NULL default '0000-00-00 00:00:00',
        PRIMARY KEY  (log_id)
    ) $table_charset;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($query);
}

/* Run functions on plugin activation
****************************************************************************************************/
register_activation_hook(DATALOGGER_API_FILE, 'create_tractor_meta_table');
register_activation_hook(DATALOGGER_API_FILE, 'create_tractor_meta_log_table');

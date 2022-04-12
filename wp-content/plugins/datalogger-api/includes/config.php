<?php

/* Load text domain and translation
****************************************************************************************************/
function load_text_domain()
{
    /**
     * Defining translation functionality of the plugin.
     * DATALOGGER_API_LANGUAGE is equal to datalogger-api/languages
     */
    load_plugin_textdomain('datalogger-api', false, DATALOGGER_API_LANGUAGE);
}

add_action('plugins_loaded', 'load_text_domain');

/* Load admin styles
****************************************************************************************************/
function load_admin_styles()
{
    wp_enqueue_style('admin_style', DATALOGGER_API_URI . 'admin/assets/css/admin.css');
}

add_action('admin_enqueue_scripts', 'load_admin_styles');

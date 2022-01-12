<?php

function load_text_domain()
{
    /**
     * Defining translation functionality of the plugin.
     * CUSTOM_API_LANGUAGE is equal to custom-api/languages
     */
    load_plugin_textdomain('custom-api', false, CUSTOM_API_LANGUAGE);
}

add_action('plugins_loaded', 'load_text_domain');

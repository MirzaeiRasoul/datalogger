<?php

/** 
 * Plugin Name: Custom API
 * Plugin URI: https://mirzaeirasoul.ir
 * Author: Rasoul Mirzaei Zadeh
 * Author URI: https://mirzaeirasoul.ir
 * Description: This is test
 * Version: 1.0.0
 */

/* General Definition
******************************/
define('CUSTOM_API_PATH', plugin_dir_path(__FILE__));
define('CUSTOM_API_URI', plugin_dir_url(__FILE__));
define('CUSTOM_API_FILE', __FILE__);

/* Load Plugin Prefix Config
******************************/
require_once CUSTOM_API_PATH . 'api/prefix-config.php';

/* Load Plugin API
******************************/
require_once CUSTOM_API_PATH . 'api/api.php';

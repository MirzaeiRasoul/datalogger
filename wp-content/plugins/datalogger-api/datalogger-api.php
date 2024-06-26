<?php

/** 
 * Plugin Name: Data Logger API
 * Plugin URI: https://mirzaeirasoul.ir
 * Author: Rasoul Mirzaei Zadeh
 * Author URI: https://mirzaeirasoul.ir
 * Description: This is my first plugin.
 * Version: 1.0.0
 */

/* Global Definition
****************************************************************************************************/
define('DATALOGGER_API_PATH', plugin_dir_path(__FILE__));
define('DATALOGGER_API_URI', plugin_dir_url(__FILE__));
define('DATALOGGER_API_FILE', __FILE__);
define('DATALOGGER_API_LANGUAGE', plugin_basename(__DIR__) . '/languages');

/* Load Plugin Config
****************************************************************************************************/
require_once DATALOGGER_API_PATH . 'includes/config.php';

/* Load API Prefix Config
****************************************************************************************************/
require_once DATALOGGER_API_PATH . 'includes/api/prefix-config.php';

/* Load API Manager
****************************************************************************************************/
require_once DATALOGGER_API_PATH . 'includes/api/api.php';

/* Load Database Manager
****************************************************************************************************/
require_once DATALOGGER_API_PATH . 'includes/db/db.php';
require_once DATALOGGER_API_PATH . 'includes/db/meta-config.php';

/* Register Post Type
****************************************************************************************************/
require_once DATALOGGER_API_PATH . 'includes/post-type/tractor-post-type.php';
require_once DATALOGGER_API_PATH . 'includes/post-type/tractor-meta-box.php';

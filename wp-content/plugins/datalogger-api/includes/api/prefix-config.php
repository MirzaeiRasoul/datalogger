<?php

/**
 * This will replace the 'wp-json' REST API prefix with 'api'.
 * Be sure to flush your rewrite rules for this change to work.
 */
add_filter('rest_url_prefix', function () {
    return 'api';
});

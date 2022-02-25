<?php

/**
 * Template part for displaying page content in page.php
 */

$url = 'http://localhost/health-logger/api/v1/tractors';
$args = array(
    'method' => 'GET'
);
$request = wp_remote_get($url, $args);

if (is_array($request) && !is_wp_error($request)) {
    // $http_code = wp_remote_retrieve_response_code($response);
    $response = wp_remote_retrieve_body($request);
    $json = json_decode($response);
    $data = $json->data;
    if (!empty($data)) {
        foreach ($data as $tractor) {
?>
            <div class="row">
                <div class="flex-1"><?php echo $tractor->title; ?></div>
                <div class="flex-1"><?php echo $tractor->permalink; ?></div>
            </div>
<?php
        }
    }
} else {
    echo "Something went wrong";
    echo wp_remote_retrieve_response_code($response);
}

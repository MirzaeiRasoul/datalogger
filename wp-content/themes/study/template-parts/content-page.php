<?php

/**
 * Template part for displaying page content in page.php
 */

// WP_REST_Response
// wp_remote_get()
$response = file_get_contents('http://localhost/health-logger/api/v1/test');
$response = json_decode($response);
// echo $response->status;
echo $response->message;
echo "<br>";
?>

<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
<?php

function create_test_post_type()
{
    register_post_type('test', array(
        'public' => true,
        'labels' => array(
            'name' => 'test',
        )
    ));
}

add_action('init', 'create_test_post_type');

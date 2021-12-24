<?php

function load_styles()
{
    wp_enqueue_style('default_style', get_stylesheet_uri());
    wp_enqueue_style('helper_style', get_theme_file_uri('/css/helper.css'));
    wp_enqueue_style('component_style', get_theme_file_uri('/css/component.css'));
}

add_action('wp_enqueue_scripts', 'load_styles');

function config_features()
{
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'config_features');

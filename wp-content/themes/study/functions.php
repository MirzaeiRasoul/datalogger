<?php

function theme_setup()
{
    /*
	 * Let WordPress manage the document title.
	 * This theme does not use a hard-coded <title> tag in the document head,
	 * WordPress will provide it for us.
	 */
    add_theme_support('title-tag');

    /*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
    load_theme_textdomain('study', get_template_directory() . '/languages');
}

add_action('after_setup_theme', 'theme_setup');

function load_styles()
{
    wp_enqueue_style('default_style', get_stylesheet_uri());
    wp_enqueue_style('helper_style', get_theme_file_uri('/css/helper.css'));
    wp_enqueue_style('component_style', get_theme_file_uri('/css/component.css'));
}

add_action('wp_enqueue_scripts', 'load_styles');

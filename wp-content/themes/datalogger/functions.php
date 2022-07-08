<?php

/* Initialize theme
****************************************************************************************************/
function setup_theme()
{
    /*
	 * Let WordPress manage the document title.
	 * This theme does not use a hard-coded <title> tag in the document head,
	 * WordPress will provide it for us.
	 */
    add_theme_support('title-tag');

    /*
	 * Featured images (also sometimes called Post Thumbnails) are images that represent an individual Post, Page,
     * or Custom Post Type. When you create your Theme, you can output the featured image in a number of different ways,
     * on your archive page, in your header, or above a post, for example.
     */
    add_theme_support('post-thumbnails');

    /*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
    load_theme_textdomain('datalogger', get_template_directory() . '/languages');

    add_filter('wp_mail_content_type', 'set_content_type');
    function set_content_type($content_type)
    {
        return 'text/html';
    }
}

add_action('after_setup_theme', 'setup_theme');

/* Load styles
****************************************************************************************************/
function load_styles()
{
    wp_enqueue_style('default_style', get_stylesheet_uri());
    wp_enqueue_style('main_style', get_theme_file_uri('/assets/css/main.css'));
    wp_enqueue_style('helper_style', get_theme_file_uri('/assets/css/helper.css'));
    wp_enqueue_style('font_awesome', get_theme_file_uri('/assets/font-awesome-4.7.0/css/font-awesome.min.css'));
}

add_action('wp_enqueue_scripts', 'load_styles');

/* Remove some admin menu pages
****************************************************************************************************/
function remove_menus()
{
    remove_menu_page('edit.php');           //Posts
    remove_menu_page('edit-comments.php');  //Comments
}

add_action('admin_menu', 'remove_menus');

/* Costomize sort of admin menu pages
****************************************************************************************************/
function wpse_custom_menu_order($menu_ord)
{
    if (!$menu_ord) return true;

    return array(
        'index.php',                   // Dashboard
        'edit.php?post_type=tractor',  // Tractors
        'upload.php',                  // Media
        'edit.php?post_type=page',     // Pages
        'separator1',                  // First separator
        'themes.php',                  // Appearance
        'plugins.php',                 // Plugins
        'options-general.php',         // Settings
        'separator2',                  // Second separator
        'users.php',                   // Users
        'tools.php',                   // Tools
        'separator3',                  // Third separator
        'separator-last',              // Last separator
    );
}

add_filter('custom_menu_order', 'wpse_custom_menu_order', 10, 1);
add_filter('menu_order', 'wpse_custom_menu_order', 10, 1);

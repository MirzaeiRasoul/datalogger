<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>

<body>
    <div class="container">
        <div class="content">
            <header class="header">
                <div class="brand">
                    <!-- <h1 class="site-title"><?php esc_html_e('Home', 'health-logger'); ?></h1> -->
                    <h1 class="site-title"><?php echo the_title(); ?></h1>
                </div>
                <!-- <nav class="navbar">
                    <ul class="navbar-list">
                        <li class="navbar-item"><a href="#"><?php esc_html_e('About', 'health-logger'); ?></a></li>
                        <li class="navbar-item"><a href="#">Hello</a></li>
                        <li class="navbar-item"><a href="#">Welcome</a></li>
                    </ul>
                </nav> -->
            </header> <!-- .header -->
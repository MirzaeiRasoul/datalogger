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
                    <h1 class="site-title"><?php echo the_title(); ?></h1>
                </div>
            </header> <!-- .header -->
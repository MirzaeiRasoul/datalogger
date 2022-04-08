<?php

/**
 * The template for displaying index page
 */

get_header(); ?>

<main class="main mg-t-20">
    <?php
    get_template_part('template-parts/post-index');
    ?>
</main> <!-- .main -->

<?php
get_footer();
get_sidebar();

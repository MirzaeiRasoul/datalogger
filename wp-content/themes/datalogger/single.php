<?php

/**
 * The template for displaying posts
 */

get_header(); ?>

<main class="main mg-t-20">
    <?php
    get_template_part('template-parts/post-single');
    ?>
</main> <!-- .main -->

<?php
get_footer();
get_sidebar();

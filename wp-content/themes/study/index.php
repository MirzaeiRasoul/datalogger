<?php

get_header(); ?>

<main class="main">
    <div class="row">
        <div class="card flex-1">
            <div class="card-content">col1</div>
        </div>
        <div class="card flex-2">
            <div class="card-content">col2</div>
        </div>
    </div>
    <div class="row">
        <div class="card flex-1">
            <div class="card-content">
                <?php
                $tractor_posts = new WP_Query(array(
                    'post_type' => 'tractor'
                ));

                while ($tractor_posts->have_posts()) {
                    $tractor_posts->the_post();
                    get_template_part('template-parts/content');
                }
                ?>
            </div>
        </div>
    </div>
</main> <!-- .main -->

<?php
get_footer();
get_sidebar();

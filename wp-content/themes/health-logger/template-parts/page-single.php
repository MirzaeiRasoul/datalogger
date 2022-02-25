<?php

/**
 * Template part for displaying page content in page.php
 */

while (have_posts()) {
    the_post();
}
?>
<div class="section-content">
    <div class="card">
        <div class="card-title">
            <h3>توضیحات تکمیلی</h3>
        </div>
        <div class="card-content">
            <?php the_content(); ?>
        </div>
    </div>
</div>
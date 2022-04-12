<?php

/**
 * Template part for displaying content in page.php
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
            <h3><?php echo __('Description', 'datalogger') ?></h3>
        </div>
    </div>
</div>
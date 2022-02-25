<?php

/**
 * Template part for displaying page content in single posts
 */

while (have_posts()) {
    the_post();
}
?>
<div class="section-header mg-r-10 mg-l-10 mg-b-15">
    <span class="section-title">
        <h2>
            <?php esc_html_e('Details', 'health-logger') . ' ' . esc_html_e('Tractor', 'health-logger') . ' ' . the_title(); ?>
        </h2>
    </span>
</div>
<div class="section-content">
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th><?php esc_html_e('Name', 'health-logger'); ?></th>
                    <th><?php esc_html_e('Value', 'health-logger'); ?></th>
                    <th><?php esc_html_e('Last Modified Time', 'health-logger'); ?></th>
                    <th><?php esc_html_e('Status', 'health-logger'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tractor_meta_sensors = get_post_meta($post->ID, '_tractor_sensors', true);
                foreach ($tractor_meta_sensors as $sensor) { ?>
                    <tr>
                        <td class="f-700"><?php echo $sensor; ?></td>
                        <td>50</td>
                        <td>11:05 ۱۴۰۰/۱۱/۲۲</td>
                        <td> <span class="status-active"><?php echo current_time('mysql', false); ?></span> </td>
                        <!-- <td> <span class="status-active">فعال</span> </td> -->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="card mg-t-15">
        <div class="card-title">
            <h3>توضیحات تکمیلی</h3>
        </div>
        <div class="card-content">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php

/**
 * Template part for displaying page content in index.php
 */

?>
<div class="section-header mg-r-10 mg-l-10 mg-b-15">
    <span class="section-title">
        <h2><?php esc_html_e('Tractors List', 'health-logger'); ?></h2>
    </span>
    <span class="section-actions">
        <a class="filter-btn" href="#" title="<?php esc_html_e('Filters', 'health-logger'); ?>">
            <i class="fa fa-filter" aria-hidden="true"></i>
        </a>
    </span>
</div>
<div class="section-content">
    <table>
        <tr>
            <th><?php esc_html_e('Name', 'health-logger'); ?></th>
            <th><?php esc_html_e('Status', 'health-logger'); ?></th>
            <th><?php esc_html_e('Post Creation Time', 'health-logger'); ?></th>
            <th><?php esc_html_e('Last Modified Time', 'health-logger'); ?></th>
            <th class="ta-center"><?php esc_html_e('Actions', 'health-logger'); ?></th>
        </tr>
        <?php
        $tractor_posts = new WP_Query(array(
            'post_type'      => 'tractor',
            'orderby'        => 'post__in',
            'posts_per_page' => 10,
            // 'paged'          => (get_query_var('paged') ? get_query_var('paged') : 1)
        ));
        while ($tractor_posts->have_posts()) {
            $tractor_posts->the_post(); ?>
            <tr>
                <!-- <td><?php the_title(); ?></td> -->
                <td class="f-700">
                    <a href="<?php the_permalink(); ?>">
                        <?php esc_html_e('Device', 'health-logger'); ?> <?php the_title(); ?>
                    </a>
                </td>
                <!-- <td><?php echo get_post_meta(get_the_ID(), 'sensor_1', true); ?></td> -->
                <td>
                    <span class="status-active"><?php esc_html_e('Active', 'health-logger'); ?></span>
                </td>
                <td><?php echo get_the_time('H:i') . " " . get_the_date(); ?></td>
                <td><?php echo get_post_modified_time('H:i') . " " . get_the_modified_date(); ?></td>
                <td class="ta-center">
                    <a class="action-btn" href="<?php the_permalink(); ?>" title="<?php esc_html_e('Details', 'health-logger'); ?>">
                        <i class="fa fa-info" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>

        <?php } ?>
    </table>
</div>
<?php

/**
 * Template part for displaying content in page-home.php
 */

$page_number = get_query_var('page') ? get_query_var('page') : 1;
?>
<div class="section-header mg-r-10 mg-l-10 mg-b-15">
    <span class="section-title">
        <h2><?php esc_html_e('Tractors List', 'datalogger'); ?></h2>
    </span>
    <span class="section-actions">
        <div class="pagination mg-l-15">
            <a class="page-btn nav-btn" href="<?php echo get_site_url() . '/page/' . ($page_number + 1); ?>">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
            <a class="page-btn" href="<?php echo get_site_url() . '/page/' . ($page_number + 2); ?>">
                <?php echo $page_number + 2; ?>
            </a>
            <a class="page-btn" href="<?php echo get_site_url() . '/page/' . ($page_number + 1); ?>">
                <?php echo $page_number + 1; ?>
            </a>
            <a class="page-btn active"><?php echo $page_number; ?></a>
            <a class="page-btn nav-btn" href="<?php echo get_site_url() . '/page/' . ($page_number - 1); ?>">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>

        </div>
        <a class="filter-btn" href="#" title="<?php esc_html_e('Filters', 'datalogger'); ?>">
            <i class="fa fa-filter" aria-hidden="true"></i>
        </a>
    </span>
</div>
<div class="section-content">
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th><?php esc_html_e('Name', 'datalogger'); ?></th>
                    <th class="ta-center"><?php esc_html_e('Post Creation Date', 'datalogger'); ?></th>
                    <th class="ta-center"><?php esc_html_e('Post Creation Time', 'datalogger'); ?></th>
                    <th class="ta-center"><?php esc_html_e('Last Modified Date', 'datalogger'); ?></th>
                    <th class="ta-center"><?php esc_html_e('Last Modified Time', 'datalogger'); ?></th>
                    <th class="ta-center"><?php esc_html_e('Status', 'datalogger'); ?></th>
                    <th class="ta-center"><?php esc_html_e('Actions', 'datalogger'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tractor_posts = new WP_Query(array(
                    'post_type'      => 'tractor',
                    'orderby'        => 'post__in',
                    'paged'          => $page_number,
                    'posts_per_page' => 10,
                ));
                while ($tractor_posts->have_posts()) {
                    $tractor_posts->the_post(); ?>
                    <tr>
                        <td class="f-700">
                            <a class="link" href="<?php the_permalink(); ?>">
                                <?php esc_html_e('Device', 'datalogger'); ?> <?php the_title(); ?>
                            </a>
                        </td>
                        <td class="ta-center"><?php echo get_the_date(); ?></td>
                        <td class="ta-center"><?php echo get_the_time('H:i'); ?></td>
                        <td class="ta-center"><?php echo get_the_modified_date(); ?></td>
                        <td class="ta-center"><?php echo get_post_modified_time('H:i'); ?></td>
                        <td class="ta-center">
                            <span class="status-active"><?php esc_html_e('Active', 'datalogger'); ?></span>
                        </td>
                        <td class="ta-center">
                            <a class="action-btn" href="<?php the_permalink(); ?>" title="<?php esc_html_e('Details', 'datalogger'); ?>">
                                <i class="fa fa-info" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
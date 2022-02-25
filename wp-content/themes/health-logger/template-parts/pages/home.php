<?php

/**
 * Template part for displaying page content in page.php
 */

$page_number = get_query_var('page') ? get_query_var('page') : 1;
?>
<div class="section-header mg-r-10 mg-l-10 mg-b-15">
    <span class="section-title">
        <h2><?php esc_html_e('Tractors List', 'health-logger'); ?></h2>
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
        <a class="filter-btn" href="#" title="<?php esc_html_e('Filters', 'health-logger'); ?>">
            <i class="fa fa-filter" aria-hidden="true"></i>
        </a>
    </span>
</div>
<div class="section-content">
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th><?php esc_html_e('Name', 'health-logger'); ?></th>
                    <th><?php esc_html_e('Post Creation Time', 'health-logger'); ?></th>
                    <th><?php esc_html_e('Last Modified Time', 'health-logger'); ?></th>
                    <th><?php esc_html_e('Status', 'health-logger'); ?></th>
                    <th class="ta-center"><?php esc_html_e('Actions', 'health-logger'); ?></th>
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
                            <a href="<?php the_permalink(); ?>">
                                <?php esc_html_e('Device', 'health-logger'); ?> <?php the_title(); ?>
                            </a>
                        </td>
                        <td><?php echo get_the_time('H:i') . " " . get_the_date(); ?></td>
                        <td><?php echo get_post_modified_time('H:i') . " " . get_the_modified_date(); ?></td>
                        <td>
                            <span class="status-active"><?php esc_html_e('Active', 'health-logger'); ?></span>
                        </td>
                        <td class="ta-center">
                            <a class="action-btn" href="<?php the_permalink(); ?>" title="<?php esc_html_e('Details', 'health-logger'); ?>">
                                <i class="fa fa-info" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
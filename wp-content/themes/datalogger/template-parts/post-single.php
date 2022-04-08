<?php

/**
 * Template part for displaying content in single.php
 */

while (have_posts()) {
    the_post();
}
?>
<div class="section-header mg-r-10 mg-l-10 mg-b-15">
    <span class="section-title">
        <h2>
            <?php echo __('Tractor Details', 'datalogger') ?>
            <?php echo the_title(); ?>
        </h2>
    </span>
</div>
<div class="section-content">
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th><?php esc_html_e('Name', 'datalogger'); ?></th>
                    <th><?php esc_html_e('Value', 'datalogger'); ?></th>
                    <th><?php esc_html_e('Post Creation Time', 'datalogger'); ?></th>
                    <th><?php esc_html_e('Last Modified Time', 'datalogger'); ?></th>
                    <th><?php esc_html_e('Status', 'datalogger'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $url = 'http://localhost/datalogger/api/v1/tractors/' . get_the_ID() . '/metadata/';
                $args = array(
                    'method' => 'GET'
                );
                $request = wp_remote_get($url, $args);
                if (!is_wp_error($request) && is_array($request)) {
                    $response = wp_remote_retrieve_body($request);
                    $json = json_decode($response);
                    $data = $json->data;
                    if (!empty($data)) { ?>
                        <tr>
                            <td class="f-700"><?php echo $data->post_id; ?></td>
                            <td><?php echo $data->post_city; ?></td>
                            <td><?php echo $data->post_geo_location; ?></td>
                            <td><?php echo $data->meta_modified; ?></td>
                            <td> <span class="status-active">فعال</span> </td>
                        </tr>
                    <?php
                    } else { ?>
                        <tr>
                            <td class="f-700"><?php echo $json->error->message; ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    } ?>
                <?php
                } else {
                    echo $request->get_error_message();
                } ?>
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
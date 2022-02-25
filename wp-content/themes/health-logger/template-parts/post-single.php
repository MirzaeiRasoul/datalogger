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
                    <th><?php esc_html_e('Post Creation Time', 'health-logger'); ?></th>
                    <th><?php esc_html_e('Last Modified Time', 'health-logger'); ?></th>
                    <th><?php esc_html_e('Status', 'health-logger'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $url = 'http://localhost/health-logger/api/v1/tractors/' . get_the_ID() . '/sensors/';
                $args = array(
                    'method' => 'GET'
                );
                $request = wp_remote_get($url, $args);
                if (is_array($request) && !is_wp_error($request)) {
                    $response = wp_remote_retrieve_body($request);
                    $json     = json_decode($response);
                    $data     = $json->data;
                    if (!empty($data)) {
                        foreach ($data as $sensor) {
                ?>
                            <tr>
                                <td class="f-700"><?php echo $sensor->persianName; ?></td>
                                <td><?php echo $sensor->value; ?></td>
                                <td><?php echo $sensor->date; ?></td>
                                <td><?php echo $sensor->modified; ?></td>
                                <td> <span class="status-active">فعال</span> </td>
                            </tr>
                <?php
                        }
                    }
                } else {
                    echo "Something went wrong";
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
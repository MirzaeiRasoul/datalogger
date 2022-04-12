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
                    <th><?php echo __('Specifications', 'datalogger') ?></th>
                    <th class="ta-center"></th>
                    <th class="ta-center"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $url = get_site_url() . '/api/v1/tractors/' . get_the_ID() . '/metadata/';
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
                            <td>
                                <span class="fw-700"><?php echo __('Name', 'datalogger') ?>: </span>
                                <span><?php echo the_title(); ?></span>
                            </td>
                            <td>
                                <span class="fw-700"><?php echo __('City', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->post_city; ?></span>
                            </td>
                            <td>
                                <span class="fw-700"><?php echo __('Coordinates', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->post_geo_location; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="fw-700"><?php echo __('Water Temperature', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->sensor_water_temperature; ?></span>
                            </td>
                            <td>
                                <span class="fw-700"><?php echo __('Oil Pressure', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->sensor_oil_pressure; ?></span>
                            </td>
                            <td>
                                <span class="fw-700"><?php echo __('Differential Lock', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->sensor_differential_lock; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="fw-700"><?php echo __('Battery Charge', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->sensor_battery_charge; ?></span>
                            </td>
                            <td>
                                <span class="fw-700"><?php echo __('Air', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->sensor_air; ?></span>
                            </td>
                            <td>
                                <span class="fw-700"><?php echo __('Reserved', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->sensor_reserved; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="fw-700"><?php echo __('Meta Date', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->meta_date; ?></span>
                            </td>
                            <td>
                                <span class="fw-700"><?php echo __('Meta Modified', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->meta_modified; ?></span>
                            </td>
                            <td>
                                <span class="fw-700"><?php echo __('Meta Active', 'datalogger') ?></span>: </span>
                                <span><?php echo $data->meta_active; ?></span>
                            </td>
                            <!-- <td><span class="status-active">فعال</span></td> -->
                        </tr>
                    <?php
                    } else { ?>
                        <tr>
                            <td><?php echo $json->error->message; ?></td>
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
            <h3><?php echo __('Description', 'datalogger') ?></h3>
        </div>
        <div class="card-content">
            <?php the_content(); ?>
        </div>
    </div>
</div>
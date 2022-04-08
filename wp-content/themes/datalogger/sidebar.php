</div> <!-- .content -->
<aside class="sidebar">
    <section class="sidebar-top">
        <a class="sidebar-logo mg-t-20 mg-b-10" href="<?php echo get_site_url(); ?>">
            <i class="fa fa-dashboard m" aria-hidden="true"></i>
            <span class="mg-r-10"><?php esc_html_e('Data Logger', 'datalogger'); ?></span>
        </a>
        <ul class="sidebar-list">
            <li class="sidebar-item <?php echo is_page('home') ? 'active' : '' ?>">
                <a href="<?php echo site_url(); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <span><?php esc_html_e('Home', 'datalogger'); ?></span>
                </a>
            </li>
            <li class="sidebar-item <?php echo is_page('reports') ? 'active' : '' ?>">
                <a href="<?php echo site_url('reports'); ?>">
                    <i class="fa fa-pie-chart" aria-hidden="true"></i>
                    <span><?php esc_html_e('Reports', 'datalogger'); ?></span>
                </a>
            </li>
        </ul>
    </section>
    <section class="sidebar-bottom">
        <ul class="sidebar-list">
            <!-- <li class="sidebar-item">
                <a href="#">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <span><?php esc_html_e('Setting', 'datalogger'); ?></span>
                </a>
            </li> -->
            <li class="sidebar-item <?php echo is_page('about') ? 'active' : '' ?>">
                <a href="<?php echo site_url('about'); ?>">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <span><?php esc_html_e('About', 'datalogger'); ?></span>
                </a>
            </li>
        </ul>

        <div class="sidebar-profile mg-b-10">
            <?php global $current_user; ?>
            <?php echo get_avatar($current_user->id, 100); ?>
            <span>رسول میرزایی</span><!-- echo $current_user->display_name; -->
        </div>
    </section>
</aside> <!-- .sidebar -->
</div> <!-- .container -->

<?php wp_footer(); ?>
</body>

</html>
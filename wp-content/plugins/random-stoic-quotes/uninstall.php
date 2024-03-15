<?php

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

global $wpdb;
$plugin_name = "randomstoicquotes";
$table_name = $wpdb->prefix . $plugin_name;
$wpdb->query("DROP TABLE IF EXISTS $table_name");
delete_option($plugin_name);
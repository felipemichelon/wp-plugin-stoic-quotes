<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\Base;

class Activate
{
    public static function activate()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'randomstoicquotes';

        $sql = "CREATE TABLE " . $table_name . " (
            id int(11) NOT NULL AUTO_INCREMENT,
            quote_text tinytext NOT NULL,
            quote_auhor VARCHAR(10) NOT NULL,
            PRIMARY KEY  (id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        flush_rewrite_rules();
    }

}

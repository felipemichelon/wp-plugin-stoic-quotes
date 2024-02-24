<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\Base;

class RandomStoicQuotesDb extends BaseController
{
    public static function createTable()
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
    }
    
    public static function removeTable()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS wp_randomstoicquotes");
    }
}

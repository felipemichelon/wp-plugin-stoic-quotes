<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\Base;

class RandomStoicQuotesDb extends BaseController
{
    public function removeDbTable()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'randomstoicquotes';

        $sql = "DROP TABLE " . $table_name . ";";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        return dbDelta($sql);
    }
}

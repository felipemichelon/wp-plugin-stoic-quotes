<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\RandomStoicQuotesClasses;

if ( ! class_exists( 'RsqActivate' ) ) {
    class RsqActivate
    {
        public static function activate()
        {
            global $wpdb;
    
            $table_name = $wpdb->prefix . 'randomstoicquotes';
    
            $sql = "CREATE TABLE " . $table_name . " (
                id int(11) NOT NULL AUTO_INCREMENT,
                quote_text tinytext NOT NULL,
                quote_author VARCHAR(100) NOT NULL,
                PRIMARY KEY  (id)
            );";
    
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            
            flush_rewrite_rules();
        }
    
    }
}

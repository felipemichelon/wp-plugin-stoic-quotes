<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\RandomStoicQuotesClasses;

if (!class_exists('RsqActivate')) {
    class RsqActivate
    {
        public static function activate()
        {
            self::createTable();
            self::addDefaultQuotes();
            // flush_rewrite_rules();

            if (!isset($control)) {
                $control = new RsqController();
            }
            $control->cacheQuotes();
        }

        private static function createTable()
        {
            global $wpdb;
            $sql = "CREATE TABLE " . $wpdb->prefix . 'randomstoicquotes' . " (
                id int(11) NOT NULL AUTO_INCREMENT,
                quote_text tinytext NOT NULL,
                quote_author VARCHAR(100) NOT NULL,
                quote_active TINYINT NOT NULL DEFAULT 1,
                category VARCHAR(50),
                PRIMARY KEY  (id)
            );";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }

        private static function addDefaultQuotes()
        {
            $list = file_get_contents(plugin_dir_path(dirname(__FILE__, 2)) . "defaultQuotesList.json");
            $list = json_decode($list, true);
            foreach ($list as $item) {
                self::addQuoteToDb($item);
                flush_rewrite_rules();
            }
            flush_rewrite_rules();
        }

        private static function addQuoteToDb($item)
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'randomstoicquotes';

            $itemToAdd = array(
                'quote_text' => $item['quote_text'],
                'quote_author' => $item['quote_author'],
                'quote_active' => 1,
                'category' => 'default',
            );

            $sql = "SELECT count(*) FROM $table_name WHERE quote_text=%s AND quote_author=%s";

            $sqlPrepared = $wpdb->prepare(
                $sql,
                $itemToAdd["quote_text"],
                $itemToAdd["quote_author"]
            );

            
            $itemSaved = (int)$wpdb->get_var($sqlPrepared);

            if($itemSaved == 0){
                $wpdb->insert($table_name, $itemToAdd);
            }
        }
    }
}

<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\RandomStoicQuotesClasses;

if (!class_exists('RsqController')) {
    class RsqController
    {
        public $plugin_dir_path;
        public $options;
        public $quotes_list_filename;
        public $table_name;

        public function __construct()
        {
            global $wpdb;
            $this->plugin_dir_path = plugin_dir_path(dirname(__FILE__, 2));
            $this->options = get_option('randomstoicquotes_number_quotes_per_page');
            $this->quotes_list_filename = RSQ_DEFAULT_QUOTES;
            $this->table_name = $wpdb->prefix . 'randomstoicquotes';
        }
        public function register()
        {
            $this->updateDefaultQuotesStatus();
            if (isset(get_option('randomstoicquotes')['show_on_admin']) && get_option('randomstoicquotes')['show_on_admin'] == 'on'){
                add_action('admin_notices', [$this, 'showRandomStoicQuotesOnAdmin']);
            }
        }

        public function showRandomStoicQuotesOnAdmin()
        {
            $list = $this->getQuotesList();

            if (empty($list)) {
                return false;
            }
            
            $chosen = $list[mt_rand(0, count($list) - 1)];

            $quoteStructure = '<p id="random_stoic_quotes"><span>%s</span></p>';
            if($chosen['quote_author'] != ''){
                $quoteStructure = '<p id="random_stoic_quotes"><span>%s</span><span> - '.$chosen['quote_author'].'</span></p>';
            }

            printf(
                $quoteStructure,
                $chosen['quote_text']
            );
        }

        public function getQuotesList()
        {
            if(file_exists($this->plugin_dir_path .$this->quotes_list_filename)){
                $list = file_get_contents($this->plugin_dir_path .$this->quotes_list_filename);
                $list = json_decode($list, true);
                return $list;
            }

            return $this->cacheQuotes();
        }

        public function getAllQuotesFromDb()
        {
            global $wpdb;
            $sql = "SELECT quote_text, quote_author FROM $this->table_name WHERE quote_active=1";
            return $wpdb->get_results($sql, ARRAY_A);
        }

        public function cacheQuotes()
        {
            $list = $this->getAllQuotesFromDb();

            file_put_contents(
                $this->plugin_dir_path . $this->quotes_list_filename,
                json_encode($list)
            );

            return $list;
        }

        public function updateDefaultQuotesStatus()
        {
            global $wpdb;
            $status = isset(get_option('randomstoicquotes')['show_default_quotes']) ? 1 : 0;
            $wpdb->update(
                $this->table_name,
                array('quote_active' => $status),
                array('category' => 'default')
            );
            $this->cacheQuotes();
        }
    }
}

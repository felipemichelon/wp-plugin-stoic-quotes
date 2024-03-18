<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc;

if (!class_exists('rsqController')) {
    class rsqController
    {
        public $plugin_basename;
        public $plugin_dir_path;
        public $default_quotes_filename;
        public $cached_quotes_filename;
        public $table_name;
        public $default_option_name;
        public $default_options;
        public function __construct()
        {
            $this->plugin_basename = RSQ_BASENAME;
            $this->plugin_dir_path = RSQ_DIR_PATH;
            $this->default_quotes_filename = RSQ_DEFAULT_QUOTES_FILENAME;
            $this->cached_quotes_filename = RSQ_CACHED_QUOTES_FILENAME;

            global $wpdb;
            $this->table_name = $wpdb->prefix . RSQ_MAIN_FILE_NAME;
            $this->default_option_name = RSQ_MAIN_FILE_NAME;

            $this->default_options = array(
                'show_on_admin'=> 'on',
                'show_default_quotes'=> 'on',
                'quotes_per_page'=> RSQ_NUMBER_QUOTES_PER_PAGE,
            );
        }

        public function createTable()
        {
            $sql = "CREATE TABLE IF NOT EXISTS " . $this->table_name . " (
                id int(11) NOT NULL AUTO_INCREMENT,
                quote_text tinytext NOT NULL,
                quote_author VARCHAR(100) NOT NULL,
                quote_active TINYINT DEFAULT 1,
                category VARCHAR(50),
                PRIMARY KEY  (id)
            );";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            return $this;
        }

        public function dropTable()
        {
            global $wpdb;
            $wpdb->query("DROP TABLE IF EXISTS $this->table_name");
        }

        public function insertItemToTable($quote_text, $quote_author, $quote_active = 1, $category = '')
        {
            global $wpdb;
            if($this->getItemFromTable(null, $quote_text, $quote_author, $quote_active, $category)){
                return;
            }

            $itemToAdd = array(
                'quote_text' => $quote_text,
                'quote_author' => $quote_author,
                'quote_active' => $quote_active,
                'category' => $category,
            );
            $wpdb->insert($this->table_name, $itemToAdd);
            return $this;
        }

        public function getItemFromTable($item_id = null, $quote_text = null, $quote_author = null, $quote_active = null, $category = null)
        {
            global $wpdb;
            $where = "";
            $select = "SELECT * FROM $this->table_name";

            if ($item_id){
                $where = " WHERE id=$item_id";
            }
            if($quote_text){
                $where .= ($where == "") ? " WHERE" : " AND";
                $where .= " quote_text=\"$quote_text\"";
            }
            if($quote_text){
                $where .= ($where == "") ? " WHERE" : " AND";
                $where .= " quote_author=\"$quote_author\"";
            }
            if($quote_active){
                $where .= ($where == "") ? " WHERE" : " AND";
                $where .= " quote_active=\"$quote_active\"";
            }
            if($category){
                $where .= ($where == "") ? " WHERE" : " AND";
                $where .= " category=\"$category\"";
            }
            $where .= ($where == "") ? $where : ";";
            
            $sqlPrepared = $select . $where;
            return $wpdb->get_row($sqlPrepared);
        }

        public function getAllQuotesFromTable($quote_active = null)
        {
            global $wpdb;
            $where = "";
            $sql = "SELECT * FROM $this->table_name";
            if($quote_active){
                $where = " WHERE quote_active=$quote_active";
            }
            if($where != ""){
                $where .= ";";
                $sql = $sql . $where;
            }

            return $wpdb->get_results($sql, ARRAY_A);
        }

        public function inserDefaultQuotesToTable()
        {
            $filename = $this->plugin_dir_path . $this->default_quotes_filename;
            $defaultQuotes = $this->readFile($filename);
            foreach( $defaultQuotes as $quote){
                $this->insertItemToTable(
                    $quote['quote_text'],
                    $quote['quote_author'],
                    1,
                    'default'
                );
            }
            return $this;
        }
        
        public function getDefaultOptions()
        {
            return get_option($this->default_option_name);
        }

        public function setDefaultOptions()
        {
            update_option($this->default_option_name, $this->default_options);
            return $this;
        }

        public function updateDefaultQuoteStatus( $status )
        {
            global $wpdb;
            $list = $this->getAllQuotesFromTable();
            foreach( $list as $quote ){
                $newStatus = ($status) ? 1 : 0;
                $wpdb->update(
                    $this->table_name,
                    array('quote_active' => $newStatus),
                    array(
                        'id' => $quote['id'],
                        'category' => 'default'
                    ),
                );
                $quote['quote_active'] = $newStatus;
            }
            return $this;
        }

        // public function getCachedQuotes()
        // {
        //     $filename = $this->plugin_dir_path . $this->cached_quotes_filename;
        //     if(!file_exists($filename)){
        //         $this->updateCachedQuotesFile();
        //     }
        //     return $this->readFile($filename);
        // }

        // public function updateCachedQuotesFile()
        // {
        //     $quotesList = $this->getAllQuotesFromTable();
        //     file_put_contents(
        //         $this->plugin_dir_path . $this->cached_quotes_filename,
        //         json_encode($quotesList, JSON_PRETTY_PRINT)
        //     );
        //     return $this;
        // }

        private function readFile($filename)
        {
            if(!file_exists($filename)){
                return false;
            }
            $content = file_get_contents($filename);
            return json_decode($content, true);
        }
    }
}

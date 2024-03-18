<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc;

if (!class_exists('randomStoicQuotes')) {
    class randomStoicQuotes extends rsqController
    {
        public function register()
        {
            add_action('admin_notices', [$this, 'showRandomStoicQuotesOnAdmin']);
        }

        public function activate()
        {
            $this->createTable();
            $this->setDefaultOptions();
            $this->inserDefaultQuotesToTable();
        }

        public function deactivate()
        {
            //
        }

        public function showRandomStoicQuotesOnAdmin()
        {
            $options = get_option($this->default_option_name);
            $this->updateDefaultQuoteStatus(array_key_exists('show_default_quotes', $options));
            
            if (!array_key_exists('show_on_admin', $options)){
                return $this;
            }

            $list = $this->getAllQuotesFromTable(1);
            if (empty($list)) {
                return $this;
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
    }
}

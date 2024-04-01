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
            $this->insertDefaultQuotesToTable();
        }

        public function deactivate()
        {
            flush_rewrite_rules();
        }

        public function showRandomStoicQuotesOnAdmin()
        {
            $options = get_option($this->default_option_name);
            if(!$options){
                return $this;
            }
            $this->updateDefaultQuoteStatus(array_key_exists('show_default_quotes', $options));
            
            if (!array_key_exists('show_on_admin', $options)){
                return $this;
            }

            $chosen = $this->getRandomStoicQuoteRandomly();
            if(!$chosen){
                return $this;
            }

            if($chosen['quote_author'] != ''){
                echo '<p id="random_stoic_quotes"><span>'.esc_html($chosen['quote_text']).'</span><span> - '.esc_attr($chosen['quote_author']).'</span></p>';
                return;
            }
            echo '<p id="random_stoic_quotes"><span>'.esc_html($chosen['quote_text']).'</span></p>';
        }
    }
}

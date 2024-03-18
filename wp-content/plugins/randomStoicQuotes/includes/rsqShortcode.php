<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc;

if (!class_exists('rsqShortcode')) {
    class rsqShortcode extends rsqController
    {
        public function register()
        {
            add_shortcode( 'random_stoic_quote', array ( $this, 'randomStoicQuoteShortcode') );
        }

        public function randomStoicQuoteShortcode() 
        {
            $options = get_option($this->default_option_name);
            if (!array_key_exists('shortcode_use_option', $options)){
                return;
            }

            $quote = $this->getRandomStoicQuoteRandomly();
            $quoteToShow = $quote['quote_text'];
            if($quote['quote_author']){
                $quoteToShow .= " - " . $quote['quote_author'];
            }
            return $quoteToShow;
        }
    }
}

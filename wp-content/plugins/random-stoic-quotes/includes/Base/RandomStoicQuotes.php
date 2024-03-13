<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\Base;

class RandomStoicQuotes extends BaseController
{
    public function register()
    {
        if(isset(get_option('randomstoicquotes')['show_on_admin']) && get_option('randomstoicquotes')['show_on_admin'] == 'on')
            add_action( 'admin_notices', [$this, 'showRandomStoicQuotes'] );
        
    }

    function showRandomStoicQuotes() {
        global $wpdb;
        $list = $wpdb->get_results("SELECT quote_text, quote_author FROM wp_randomstoicquotes", ARRAY_A);

        $chosen = $list[mt_rand(0, count($list) -1)];
    
        printf(
            '<p id="random_stoic_quotes"><span>%s</span><span> - %s</span></p>',
            $chosen['quote_text'],
            $chosen['quote_author']
        );
    }
}

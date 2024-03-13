<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\RandomStoicQuotesClasses;

if ( ! class_exists( 'RsqDeactivate' ) ) {
    class RsqDeactivate
    {
        public static function deactivate()
        {
            flush_rewrite_rules();
        }
    }
}

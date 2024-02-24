<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\Base;

class Activate
{
    public static function activate()
    {
        RandomStoicQuotesDb::createTable();
        flush_rewrite_rules();
    }

}

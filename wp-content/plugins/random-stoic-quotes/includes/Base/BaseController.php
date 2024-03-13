<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\Base;

class BaseController
{
    public $plugin_dir_path;
    public $options;
    public function __construct()
    {
        $this->plugin_dir_path = plugin_dir_path(dirname(__FILE__, 2));

        $this->getAllOptions();
    }

    public function getAllOptions()
    {
        $this->options = get_option('randomstoicquotes_number_quotes_per_page');
    }
}

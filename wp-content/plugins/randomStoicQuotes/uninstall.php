<?php

/**
 * @package RandomStoicQuotes
 */

 namespace Inc;

use Inc\RsqController;

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

$controller = new RsqController();

$controller->dropTable();
delete_option($controller->default_option_name);
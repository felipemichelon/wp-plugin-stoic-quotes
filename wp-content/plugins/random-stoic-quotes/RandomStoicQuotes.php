<?php
use Inc\RandomStoicQuotesClasses\RsqActivate;
use Inc\RandomStoicQuotesClasses\RsqAdmin;
use Inc\RandomStoicQuotesClasses\RsqDeactivate;

/**
 * @link              https://github.com/felipemichelon/wp-plugin-stoic-quotes
 * @since             1.0.0
 * @package           random_stoic_quotes
 *
 * @wordpress-plugin
 * Plugin Name:       Random Stoic Quotes
 * Plugin URI:        https://github.com/felipemichelon/wp-plugin-stoic-quotes
 * Description:       Plugin that shows stoic sentences randomly.
 * Version:           1.0.0
 * Author:            Felipe Michelon
 * License:           GPLv3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       random-stoic-quotes
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

//defaul options
if ( ! defined( 'RSQ_NUMBER_QUOTES_PER_PAGE' ) ) {
    define( 'RSQ_NUMBER_QUOTES_PER_PAGE', '7' );
}

function activateRandomStoicQuotesPlugin()
{
    Inc\RandomStoicQuotesClasses\RsqActivate::activate();
}
register_activation_hook(__FILE__, 'activateRandomStoicQuotesPlugin');

function deactivateRandomStoicQuotesPlugin()
{
    Inc\RandomStoicQuotesClasses\RsqDeactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivateRandomStoicQuotesPlugin');

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

if (class_exists('Inc\\RsqInit')) {
    Inc\RsqInit::register_services();
}
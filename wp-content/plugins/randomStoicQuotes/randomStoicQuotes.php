<?php

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

use Inc\randomStoicQuotes;

if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

if (!defined('RSQ_BASENAME')) {
    define('RSQ_BASENAME', plugin_basename(__FILE__));
}
if (!defined('RSQ_DIR_PATH')) {
    define('RSQ_DIR_PATH', plugin_dir_path(__FILE__));
}
if (!defined('RSQ_MAIN_FILE_NAME')) {
    define('RSQ_MAIN_FILE_NAME', strtolower(plugin_basename(dirname(__FILE__))));
}

if (!defined('RSQ_NUMBER_QUOTES_PER_PAGE')) {
    define('RSQ_NUMBER_QUOTES_PER_PAGE', '7');
}
if (!defined('RSQ_DEFAULT_QUOTES_FILENAME')) {
    define('RSQ_DEFAULT_QUOTES_FILENAME', 'defaultQuotes.json');
}

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

function activateRandomStoicQuotesPlugin()
{
    if(!isset($randomStoicQuotes)){
        $randomStoicQuotes = new randomStoicQuotes();
    }
    $randomStoicQuotes->activate();
}
register_activation_hook(__FILE__, 'activateRandomStoicQuotesPlugin');

function deactivateRandomStoicQuotesPlugin()
{
    if(!isset($randomStoicQuotes)){
        $randomStoicQuotes = new randomStoicQuotes();
    }
    $randomStoicQuotes->deactivate();
}
register_deactivation_hook(__FILE__, 'deactivateRandomStoicQuotesPlugin');

load_plugin_textdomain(
    'random-stoic-quotes',
    false,
    'randomStoicQuotes' .'/languages/'
);

if(class_exists('Inc\\rsqInit')){
    Inc\rsqInit::register_services();
}

if(!isset($randomStoicQuotes)){
    $randomStoicQuotes = new randomStoicQuotes();
}
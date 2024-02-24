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

use Inc\Base\Activate;
use Inc\Base\Deactivate;

if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

function rsq_create_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'randomstoicquotes';

    $sql = "CREATE TABLE " . $table_name . " (
        id int(11) NOT NULL AUTO_INCREMENT,
        quote_text tinytext NOT NULL,
        quote_auhor VARCHAR(10) NOT NULL,
        PRIMARY KEY  (id)
    );";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    ;
}
register_activation_hook(__FILE__, 'rsq_create_table');

function rsq_remove_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'randomstoicquotes';

    $sql = "DROP TABLE IF EXISTS $table_name;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_deactivation_hook(__FILE__, 'rsq_remove_table');

// function activateRandomStoicQuotesPlugin()
// {
//     Activate::activate();
// }
// register_activation_hook(__FILE__, 'activateRandomStoicQuotesPlugin');

// function deactivateRandomStoicQuotesPlugin()
// {
//     Deactivate::deactivate();
// }
// register_deactivation_hook(__FILE__, 'deactivateRandomStoicQuotesPlugin');



// if (class_exists('Inc\\Init')) {
//     Inc\Init::register_services();
// }

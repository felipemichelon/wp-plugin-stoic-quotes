<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\Base;

class RandomStoicQuotesAdmin extends BaseController
{
    public function register()
    {
        add_action('admin_menu', [$this, 'rsq_add_plugin_menu']);
    }

    public function rsq_add_plugin_menu()
    {
        add_menu_page(
            'Stoic Quotes',
            'Stoic Quotes',
            'manage_options',
            'stoic_quotes',
            [$this, 'rsq_admin_menu'],
            'dashicons-format-quote',
            110
        );

        $submenu = add_submenu_page(
            'chatbots', 
            'Meus Chatbots', 
            'Meus Chatbots', 
            'activate_plugins', 
            'chatbots', 
            'rsq_admin_menu');

        add_submenu_page(
            'Quotes',
            'Add Stoic Quotes',
            'Add Stoic Quotes',
            'activate_plugins',
            'chatbot_form',
            'stoic_quotes_form'
        );
    }

    public function rsq_admin_menu()
    {
        // return require_once(plugin_dir_path(dirname(__FILE__, 2)) . "/templates/admin.php");

        $controll = new RandomStoicQuotesControll();
        $controll->prepare_items();

        $message = '';
?>
        <div class="wrap">
            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
            <h2>Stoic Quotes <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=stoic_quote_form'); ?>">Add Quote</a>
            </h2>
            <?php echo $message; ?>

            <form id="stoic-quote-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <?php $controll->display() ?>
            </form>
        </div>
    <?php
    }

}

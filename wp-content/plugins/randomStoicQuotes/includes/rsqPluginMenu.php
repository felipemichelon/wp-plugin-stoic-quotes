<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc;

if (!class_exists('rsqPluginMenu')) {
    class rsqPluginMenu extends rsqController
    {
        public function register()
        {
            add_action('admin_menu',  [$this, 'rsqPluginMenu']);
        }

        public function rsqPluginMenu()
        {
            add_menu_page(
                'Random Stoic Quotes',
                __('Random Stoic Quotes', 'random-stoic-quotes'),
                'manage_options',
                'random_stoic_quotes',
                [$this, 'rsq_quotes_list'],
                'dashicons-format-quote',
                110
            );

            add_submenu_page(
                'random_stoic_quotes',
                'Add Quote',
                __('Add Quote', 'random-stoic-quotes'),
                'manage_options',
                'rsq_form_add',
                [$this, 'rsq_form_quotes'],
            );

            add_submenu_page(
                'random_stoic_quotes',
                'Configuration',
                __('Configuration', 'random-stoic-quotes'),
                'manage_options',
                'rsq_configuration',
                [$this, 'rsq_submenu_configuration'],
            );
        }

        public function rsq_quotes_list()
        {
            if (!isset($quotesTable)) {
                $quotesTable = new rsqQuotesTable();
            }
            $quotesTable->prepare_items();

            $message = '';
?>
            <div class="wrap">
                <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                <h2><?php echo __('Random Stoic Quotes', 'random-stoic-quotes') ?> <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=rsq_form_add'); ?>"><?php echo __('Add Sentence', 'random-stoic-quotes') ?></a>
                </h2>
                <?php echo $message; ?>

                <form id="stoic-quote-table" method="GET">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                    <?php $quotesTable->display() ?>
                </form>
            </div>
        <?php
        }

        function rsq_form_quotes()
        {
            global $wpdb;
            $message = '';
            $notice = '';

            // Esse é o $item padrão que será usado para novos registros
            $default = array(
                'id' => 0,
                'quote_text' => '',
                'quote_author' => '',
                'category' => 'personal',
            );

            // Aqui estamos verificando se o request é post e tem o correto nonce
            if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
                // Combina nosso item padrão com os parâmetros do request
                $item = shortcode_atts($default, $_REQUEST);
                // Valida os dados, e se todos estão ok salva o item no banco
                // se id é zero, então INSERT senão UPDATE
                $item_valid = $this->rsq_validate_quote($item);
                if ($item_valid === true) {
                    if ($item['id'] == 0) {
                        $result = $wpdb->insert($this->table_name, $item);
                        $item['id'] = $wpdb->insert_id;
                        if ($result) {
                            $message = __('Sentence saved successfully', 'random-stoic-quotes');
                        } else {
                            $notice = __('Error trying to save the item', 'random-stoic-quotes');
                        }
                        $item['id'] = 0;
                        $item['quote_text'] = null;
                        $item['quote_author'] = null;
                        $item['category'] = 'personal';
                    } else {
                        $result = $wpdb->update($this->table_name, $item, array('id' => $item['id']));
                        if ($result) {
                            $message = __('Updated successfully', 'random-stoic-quotes');
                        } else {
                            $notice = __('Error trying to update the item', 'random-stoic-quotes');
                        }
                    }
                } else {
                    // Se $item_valid não foi true, então contém mensagem de erro
                    $notice = $item_valid;
                }
            } else {
                // se isso não for postado, carregamos o item para editar ou damos um novo para criar
                $item = $default;
                if (isset($_REQUEST['id'])) {
                    $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
                    if (!$item) {
                        $item = $default;
                        $notice = __('Item not found', 'random-stoic-quotes');
                    }
                }
            }
            add_meta_box('rsq_form_meta_box', __('Fields', 'random-stoic-quotes'), [$this, 'rsq_handler_form_meta_box'], 'random_stoic_quotes_meta_box', 'normal', 'default');

        ?>
            <div class="wrap">
                <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
                <h2>Quote <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=random_stoic_quotes'); ?>"><?php echo __('Back to list', 'random-stoic-quotes') ?></a>
                </h2>

                <?php if (!empty($notice)) : ?>
                    <div id="notice" class="error">
                        <p><?php echo $notice ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($message)) : ?>
                    <div id="message" class="updated">
                        <p><?php echo $message ?></p>
                    </div>
                <?php endif; ?>

                <form id="form" method="POST">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__)) ?>" />
                    <?php /* Observação: Nós estamos armazenando id para veriricar se será adicionado ou atualizado */ ?>
                    <input type="hidden" name="id" value="<?php echo $item['id'] ?>" />

                    <div class="metabox-holder" id="poststuff">
                        <div id="post-body">
                            <div id="post-body-content">
                                <?php /* Aqui chamamos nosso custom meta box */ ?>
                                <?php do_meta_boxes('random_stoic_quotes_meta_box', 'normal', $item); ?>
                                <input type="submit" value="Salvar" id="submit" class="button-primary" name="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
<?php
        }

        function rsq_handler_form_meta_box($item)
        {
            require_once($this->plugin_dir_path . "/templates/rsqQuoteFormFields.php");
        }
        
        function rsq_submenu_configuration()
        {
            require_once($this->plugin_dir_path . "/templates/rsqConfiguration.php");
        }

        function rsq_validate_quote($item)
        {
            $messages = array();

            if (empty($item['quote_text'])) $messages[] = __('Name is mandatory', 'random-stoic-quotes');

            if (empty($messages)) return true;
            return implode('<br />', $messages);
        }
    }
}

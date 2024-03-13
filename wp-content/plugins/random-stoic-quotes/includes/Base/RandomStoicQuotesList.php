<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\Base;

use WP_List_Table;

class RandomStoicQuotesList extends WP_List_Table
{
    public $options;
    

    public function register()
    {
        parent::__construct(array(
            'singular' => 'quote',
            'plural' => 'quotes',
        ));
    }


    /**
     * [OBRIGATÓRIO]
     * Esse é o renderizador padrão da coluna
     * 
     * @param $item - row(key, value array)
     * @param $column_name - string (key)
     * @return HTML
    */
    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    /**
     * [OBRIGATÓRIO]
     * Renderizando a coluna de checkboxes
     * 
     * @param $item - row (key, value array)
     * @return HTML
    */
    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="id[]" value="%s" />', $item['id']);
    }

    /**
     * [OBRIGATÓRIO]
     * Esse método retorn as colunas para mostrar na tabela
     * você pode pular as colunas que você não quer mostrar,
     * como conteúdo ou descrição.
     * 
     * @return array
    */
    function get_columns()
    {
        $columns = array(
            'quote_text' => 'Quote',
            'quote_author' => 'Author',
        );
        return $columns;
    }

    /**
     * [OBRIGATÓRIO]
     * Esse é o método mais importante
     * Ele vai pegar os registros do banco de dados e prepará-los para mostrar na tabela
     */
    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'randomstoicquotes';

        $per_page = get_option('randomstoicquotes')['quotes_per_page']; // configuração de quantos registro vão aparecer na página

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // Configuração do header da tabela, que foi definido anteriormente
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPCIONAL] Processa ações em passa caso existam
        $this->process_bulk_action();

        // Será usado na configuração de paginação
        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

        // Prepara os parâmetros da query, como página atual, "order by" e direção de ordenação.
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] - 1) * $per_page) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'quote_text';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        // [OBRIGATÓRIO] define $items array
        // Observer que o último argumento é ARRAY_A, então vamos recuperar o array 
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

        // [OBRIGATÓRIO] configura a paginação
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total de itens definidos acima
            'per_page' => $per_page, // constante "per_page" definida anteriormente
            'total_pages' => ceil($total_items / $per_page) // calcula a contagem de páginas
        ));
    }

    /**
     * [OPCIONAL]
     * Esse é um exemplo de como renderizar
     * coluna com ações.
     * O menu "Edit | Delete" vai aparecer
     * quando passar o mouse na linha da tabela.
     * 
     * @param $item - row(key, value array)
     * @return HTML
    */
    function column_quote_text($item)
    {
        // Os links vão para /admin.php?page=[your_plugin_page][&other_params]
        // Observe que é usado o $_REQUEST['page'], então a ação será executada na página atual
        // Perceba também que é usado o $this->_args['singular'] então nesse exemplo
        // ficará algo como &tarefa=2
        $actions = array(
            'edit' => sprintf('<a href="?page=rsq_form_add&id=%s">%s</a>', $item['id'], 'Editar'),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], 'Excluir'),
        );

        return sprintf("%s %s",$item['quote_text'], $this->row_actions($actions));
    }

    /**
     * [OPCIONAL] 
     * Esse método processa ações em massa
     * Pode ser fora da classe
     * Não pode usar o wp_redirect por que já é uma saída
     * Nesse exemplo estamos processando a ação deletar
     * A mesagem de sucesso ao deletar aparecerá na página na próxima parte
     */
    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'randomstoicquotes';

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

}

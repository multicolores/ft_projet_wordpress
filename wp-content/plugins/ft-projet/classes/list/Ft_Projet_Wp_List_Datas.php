<?php

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/screen.php');
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Ft_Projet_Wp_List_Datas extends WP_List_Table
{
    public $_screen;

    public function __construct()
    {
        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

        parent::__construct([
            'singular' => __('Item', 'sp'),
            'plural'   => __('Items', 'sp'),
            'ajax'     => false
        ]);
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $data = $this->table_data();
        $currentPage = $this->get_pagenum();

        $perPage = 10;
        $this->set_pagination_args(array(
            'total_items' => count($data),
            'per_page'    => $perPage
        ));

        $data = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        $this->items = $data;
    }

    public function get_columns($columns = array())
    {
        global $wpdb;

        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'" . $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . "_pays" . "'";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        foreach ($result as $value)
            if ($value["COLUMN_NAME"] != "id" && $value["COLUMN_NAME"] != "disponible")
                $columns[$value["COLUMN_NAME"]] = __($value["COLUMN_NAME"]);

        return $columns;
    }

    public function get_hidden_columns($default = array())
    {
        return $default;
    }


    public function get_sortable_columns($sortable = array())
    {
        global $wpdb;

        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'wp_ft_projet_pays'";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        foreach ($result as $value)
            $sortable[$value["COLUMN_NAME"]] = array($value["COLUMN_NAME"], true);

        return $sortable;
    }

    public function table_data($per_page = 10, $page_number = 1, $orderbydefault = false)
    {

        global $wpdb;

        $sql = 'SELECT * FROM `' . $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . "_pays" . '`';

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY `' . esc_sql($_REQUEST['orderby']) . '`';
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    public function column_default($item, $column_name)
    {
        if (preg_match('/note/i', $column_name))
            return self::get_note($item['id'], $item['note']);

        if (preg_match('/majeur/i', $column_name))
            return self::get_majeur($item['id'], $item['majeur']);

        return @$item[$column_name];
    }

    private function get_note($id = 0, $note = 0)
    {
        if (!$id)
            return;

        printf("<select data-id=$id class='select-note' name='note'>");
        for ($i = 0; $i <= 5; $i++) {
            if ($note == $i)
                printf("<option value='$i' selected>$i</option>");
            else
                printf("<option value='$i'>$i</option>");
        }
        printf("</select>");
    }

    private function get_majeur($id = 0, $majeur = 0)
    {
        if (!$id)
            return;

        if ($majeur)
            printf("<input data-id=$id type='checkbox' name='majeur' checked class='majeur_checkBox'>");
        else
            printf("<input data-id=$id type='checkbox' name='majeur' class='majeur_checkBox'>");
    }

    // ajoue d'un style pour les pays non disponible 
    public function single_row($item)
    {
        $cssClass = ($item['disponible'] == 1) ? '' : 'ft_grid_disable_row';
        echo '<tr class="' . $cssClass . '">';
        $this->single_row_columns($item);
        echo '</tr>';
    }
}

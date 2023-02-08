<?php

class Ft_Projet_Crud_Index
{
    public function updatePaysMajeur($id, $value)
    {
        global $wpdb;

        $table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';

        if ($wpdb->update($table_name_pays, array('majeur' => $value), array('id' => $id)))
            return "update done";
        else
            return 'Erreur';
    }

    public function updatePaysNote($id, $value)
    {
        global $wpdb;

        $table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';

        if ($wpdb->update($table_name_pays, array('note' => $value), array('id' => $id)))
            return "update done";
        else
            return 'Erreur';
    }
}

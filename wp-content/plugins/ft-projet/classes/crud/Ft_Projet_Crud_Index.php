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

    static function getPays()
    {
        global $wpdb;
        $table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';

        $sql = "SELECT * FROM $table_name_pays";

        return $wpdb->get_results($sql, 'ARRAY_A');
    }

    static function updatePaysDisponible($idsListToChange)
    {
        global $wpdb;
        $table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';

        $idsOfPaysIndisponiblesSql = "SELECT * FROM $table_name_pays WHERE `disponible`=0";
        $idsOfPaysIndisponible = $wpdb->get_results($idsOfPaysIndisponiblesSql, 'ARRAY_A');

        if ($idsOfPaysIndisponible)
            foreach ($idsOfPaysIndisponible as $value)
                $wpdb->update($table_name_pays, array('disponible' => 1), array('id' => $value['id']));

        foreach ($idsListToChange as $id)
            $wpdb->update($table_name_pays, array('disponible' => 0), array('id' => $id));

        return "update done";
    }
}

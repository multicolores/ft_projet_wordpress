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

    static function getPaysAboutProspectAge($prospectId)
    {

        // il n'y as pas de système d'authentification donc on récupère toujours le dernier prospect ( une nouvelle inscription dans le formulaire )
        global $wpdb;
        $table_name_prospects = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects';

        $sqlGetPropectInfo = "SELECT * FROM $table_name_prospects WHERE `id`=$prospectId";
        $prospect = $wpdb->get_results($sqlGetPropectInfo, 'ARRAY_A');


        $dateNaissance = $prospect['0']['date_naissance'];
        $aujourdhui = date("Y-m-d");
        $dateDiff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
        $age = $dateDiff->format('%y');

        if ($age >= 18) {
            // le prospect est majeur
            $table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';

            $sql = "SELECT * FROM $table_name_pays WHERE `disponible`=1";

            return $wpdb->get_results($sql, 'ARRAY_A');
        } else {
            // le prospect est mineur
            $table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';

            $sql = "SELECT * FROM $table_name_pays WHERE `disponible`=1 AND `majeur`=0";

            return $wpdb->get_results($sql, 'ARRAY_A');
        }
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

    public function createProspect($nom, $prenom, $sexe, $email, $date_naissance)
    {
        global $wpdb;

        $table_name_prospects = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects';

        if ($wpdb->insert(
            $table_name_prospects,
            array(
                'nom' => $nom,
                'prenom' => $prenom,
                'sexe' => $sexe,
                'email' => $email,
                'date_naissance' => $date_naissance,
            )
        ))
            return "Insert done";
        else
            return "Erreur";
    }


    public function resetPaysOfProspect($prospectId)
    {
        global $wpdb;

        $table_name_prospects_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects_pays';

        if ($wpdb->delete(
            $table_name_prospects_pays,
            array(
                'id_prospects' => $prospectId,
            )
        ))
            return "Delete done";
        else
            return "Erreur";
    }

    public function createProspectPaysRelation($prospectId, $paysId)
    {
        global $wpdb;

        if ($paysId == null || $prospectId == null)
            return "Aucun prospect ou pays renseigné";

        $table_name_prospects_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects_pays';

        if ($wpdb->insert(
            $table_name_prospects_pays,
            array(
                'id_prospects' => $prospectId,
                'id_pays' => $paysId,
                'date_choix' => date("Y-m-d h:i:s"),
            )
        ))
            return "Insert done";
        else
            return "Erreur";
    }

    public function getProspectPays($prospectId)
    {
        global $wpdb;
        $table_name_prospects_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects_pays';

        $sqlGetPaysIdsOfProspect = "SELECT `id_pays` FROM $table_name_prospects_pays WHERE `id_prospects`=$prospectId";

        $paysIds =  $wpdb->get_results($sqlGetPaysIdsOfProspect, 'ARRAY_A');

        if (sizeof($paysIds) != 0) {
            $paysIdsSql = "";

            foreach ($paysIds as $pays) :
                $paysIdsSql .= "`id`=" . $pays['id_pays'] . " OR ";
            endforeach;

            // remove the last 'OR'
            $paysIdsSql = substr($paysIdsSql, 0, -3);

            $table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';

            $sql = "SELECT * FROM $table_name_pays WHERE $paysIdsSql";

            return $wpdb->get_results($sql, 'ARRAY_A');
        } else {
            return [];
        }
    }

    public function getProspectDateDernierChoix($prospectId)
    {
        global $wpdb;
        $table_name_prospects_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects_pays';

        $sqlGetLastChoixDateOfProspect = "SELECT `date_choix` FROM $table_name_prospects_pays WHERE `id_prospects`=$prospectId";

        return $wpdb->get_results($sqlGetLastChoixDateOfProspect, 'ARRAY_A');
    }

    public function getProspectById($prospectId)
    {

        global $wpdb;
        $table_name_prospects = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects';

        $sql = "SELECT * FROM $table_name_prospects WHERE `id`=$prospectId";

        return $wpdb->get_results($sql, 'ARRAY_A');
    }

    // il n'y as pas de système d'authentification donc on récupère toujours le dernier prospect ( une nouvelle inscription dans le formulaire )
    public function getLastProspectCreatedID()
    {
        global $wpdb;
        $table_name_prospects = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects';

        $sql = "SELECT * FROM $table_name_prospects WHERE `id`= (SELECT MAX(`id`) FROM $table_name_prospects)";

        $prospect = $wpdb->get_results($sql, 'ARRAY_A');
        if ($prospect)
            return $prospect[0]['id'];
        else
            return null;
    }
}

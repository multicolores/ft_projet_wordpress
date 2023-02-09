<?php
add_action('wp_ajax_ftprojetmajeur', array('Ft_Projet_Admin_Actions_Index', 'pays_majeur'));
add_action('wp_ajax_ftprojetnote', array('Ft_Projet_Admin_Actions_Index', 'pays_note'));
add_action('wp_ajax_ftprojetdisponible', array('Ft_Projet_Admin_Actions_Index', 'pays_disponible'));

class Ft_Projet_Admin_Actions_Index
{
    public static function pays_majeur()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        foreach ($_REQUEST as $key => $value)
            $$key = (string) trim($value);

        $Ft_Projet_Crud_Index = new Ft_Projet_Crud_Index();
        $res = $Ft_Projet_Crud_Index->updatePaysMajeur($id, $majeurValue);

        print $res;

        exit;
    }

    public static function pays_note()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        foreach ($_REQUEST as $key => $value)
            $$key = (string) trim($value);

        $Ft_Projet_Crud_Index = new Ft_Projet_Crud_Index();
        $res = $Ft_Projet_Crud_Index->updatePaysNote($id, $noteValue);

        print $res;

        exit;
    }

    public static function pays_disponible()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        foreach ($_REQUEST as $key => $value)
            $$key = $value;

        $Ft_Projet_Crud_Index = new Ft_Projet_Crud_Index();
        $res = $Ft_Projet_Crud_Index->updatePaysDisponible($idsListToChange);

        print $res;

        exit;
    }
}

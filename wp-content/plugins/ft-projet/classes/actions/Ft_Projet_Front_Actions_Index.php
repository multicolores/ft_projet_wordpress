<?php
add_action('wp_ajax_ftprojetcreateprospect', array('Ft_Projet_Front_Actions_Index', 'create_prospect'));
add_action('wp_ajax_nopriv_ftprojetcreateprospect', array('Ft_Projet_Front_Actions_Index', 'create_prospect'));

class Ft_Projet_Front_Actions_Index
{
    public static function create_prospect()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        $Ft_Projet_Crud_Index = new Ft_Projet_Crud_Index();

        foreach ($_REQUEST as $key => $value)
            $$key = (string) trim($value);

        print $Ft_Projet_Crud_Index->createProspect($nom, $prenom, $sexe, $email, $date_naissance);

        exit;
    }
}

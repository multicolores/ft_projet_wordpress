<?php
add_action('wp_ajax_ftprojetcreateprospect', array('Ft_Projet_Front_Actions_Index', 'create_prospect'));
add_action('wp_ajax_nopriv_ftprojetcreateprospect', array('Ft_Projet_Front_Actions_Index', 'create_prospect'));

add_action('wp_ajax_ftprojetcreateuserpayslist', array('Ft_Projet_Front_Actions_Index', 'create_pays_list_of_prospect'));
add_action('wp_ajax_nopriv_ftprojetcreateuserpayslist', array('Ft_Projet_Front_Actions_Index', 'create_pays_list_of_prospect'));


add_action('wp_ajax_ftprojetgetpropspectinfo', array('Ft_Projet_Front_Actions_Index', 'get_prospect_info'));
add_action('wp_ajax_nopriv_ftprojetgetpropspectinfo', array('Ft_Projet_Front_Actions_Index', 'get_prospect_info'));

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

    public static function create_pays_list_of_prospect()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        $Ft_Projet_Crud_Index = new Ft_Projet_Crud_Index();

        $prospectId = $Ft_Projet_Crud_Index->getLastProspectCreatedID();

        if ($Ft_Projet_Crud_Index->resetPaysOfProspect($prospectId))
            foreach ($_REQUEST as $key => $value)
                if (!in_array($key, ['security', 'action']))
                    $Ft_Projet_Crud_Index->createProspectPaysRelation($prospectId, $value);

        print 'done';

        exit;
    }

    public static function get_prospect_info()
    {
        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1)
            exit;

        $Ft_Projet_Crud_Index = new Ft_Projet_Crud_Index();

        $prospectId = $Ft_Projet_Crud_Index->getLastProspectCreatedID();
        $prospectInfo = $Ft_Projet_Crud_Index->getProspectById($prospectId);

        $responseString = "";

        foreach ($prospectInfo as $prospect) :
            $responseString .=  $prospect['nom'] . ';' . $prospect['prenom'] . ';' . $prospect['sexe'];
        endforeach;

        print $responseString;

        exit;
    }
}

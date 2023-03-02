<?php

class Ft_Projet_Admin
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'ft_menu'), -1);
        return;
    }

    public function ft_menu()
    {
        add_menu_page(
            'ft_projet',
            'ft_projet',
            'administrator',
            'ft_projet_settings',
            array($this, 'ft_projet_settings'),
            1000
        );

        add_submenu_page(
            'ft_projet_settings',
            __('ft_projet / Config'),
            __('Config'),
            'administrator',
            'ft_projet_config',
            array($this, 'ft_projet_config')
        );

        add_submenu_page(
            'ft_projet_settings',
            __('ft_projet / List Pays'),
            __('List Pays'),
            'administrator',
            'ft_projet_list_pays',
            array($this, 'ft_projet_list_pays')
        );

        add_submenu_page(
            'ft_projet_settings',
            __('ft_projet / List Prospects'),
            __('List Prospects'),
            'administrator',
            'ft_projet_list_prospects',
            array($this, 'ft_projet_list_prospects')
        );

        add_action('admin_enqueue_scripts', array($this, 'ft_assets'), 999);
    }

    public function ft_projet_settings()
    {
        return;
    }

    public function ft_projet_config()
    {
        $Ft_Projet_Views_Config = new Ft_Projet_Views_Config();
        return $Ft_Projet_Views_Config->display();
    }

    public function ft_projet_list_pays()
    {
        $Ft_Projet_Views_List_Pays = new Ft_Projet_Views_List_Pays();
        return $Ft_Projet_Views_List_Pays->display();
    }

    public function ft_projet_list_prospects()
    {
        $Ft_Projet_Views_List_Prospect = new Ft_Projet_Views_List_Prospect();
        return $Ft_Projet_Views_List_Prospect->display();
    }

    public function ft_assets()
    {
        wp_enqueue_style('admin-style-new', plugins_url(FT_PROJET_PLUGIN_NAME)  . '/assets/css/Ft_Projet_Admin_style.css');

        wp_register_script('ft_adminJs', plugins_url(FT_PROJET_PLUGIN_NAME . '/assets/js/Ft_Projet_Admin.js'), FT_PROJET_VERSION, true);
        wp_enqueue_script('ft_adminJs');
        wp_localize_script(
            'ft_adminJs',
            'ftadminscript',
            array(
                'security' => wp_create_nonce('ajax_nonce_security')
            )
        );
        return;
    }
}

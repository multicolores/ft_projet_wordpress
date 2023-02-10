<?php

class Ft_Projet_Front
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'addjs'), 0);

        return;
    }

    public function addjs()
    {
        wp_register_script('ft-projet-js', plugins_url(FT_PROJET_PLUGIN_NAME . '/assets/js/Ft_Projet_Front.js'), array('jquery-ft'), FT_PROJET_VERSION, true);
        wp_enqueue_script('ft-projet-js');
        wp_localize_script(
            'ft-projet-js',
            'ftprojetscript',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'security' => wp_create_nonce('ajax_nonce_security')
            )
        );

        return;
    }
}

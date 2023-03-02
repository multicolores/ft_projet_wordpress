<?php
/*
Plugin Name: ft-projet
Plugin URI: https://ft-projet.com/
Description: Ceci est le plugin de Florian TELLIER qui correspond au projet
Author: Florian TELLIER
Version: 1.0
Author URI: http://ft-projet.com/
*/


if (!defined('ABSPATH'))
    exit;

define('FT_PROJET_VERSION', '1.0.2');
define('FT_PROJET_FILE', __FILE__);
define('FT_PROJET_DIR', dirname(FT_PROJET_FILE));
define('FT_PROJET_BASENAME', pathinfo((FT_PROJET_FILE))['filename']);
define('FT_PROJET_PLUGIN_NAME', FT_PROJET_BASENAME);
define('FT_PROJET_BASE_TABLE_NAME', "ft_projet");
define('FT_PROJET_URL_STEP_1', '/choix-voyage');
define('FT_PROJET_URL_STEP_2', '/choix-voyage-step-select');
define('FT_PROJET_URL_STEP_3', '/choix-voyage-step-final');


foreach (glob(FT_PROJET_DIR . '/classes/*/*.php') as $filename)
    if (!preg_match('/export|cron/i', $filename))
        if (!@require_once $filename)
            throw new Exception(sprintf(__('Failed to include %s'), $filename));

register_activation_hook(FT_PROJET_FILE, function () {
    $Ft_Projet_Install = new Ft_Projet_Install();
    $Ft_Projet_Install->setup();
});

if (is_admin())
    new Ft_Projet_Admin();
else
    new Ft_Projet_Front();

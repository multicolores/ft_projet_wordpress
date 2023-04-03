<?php

add_shortcode('FORMULAIRE_FILE_ARIANE', array('Ft_Projet_Shortcode_Formulaire_File_Ariane', 'display'));

class Ft_Projet_Shortcode_Formulaire_File_Ariane
{

    static function display($atts)
    {
        // condition ici car a l'installation du plugin on n'a pas encore toutes le pages de créer ce qui créer une petite erreur 
        if (get_page_by_path(FT_PROJET_URL_STEP_1) && get_page_by_path(FT_PROJET_URL_STEP_2) && get_page_by_path(FT_PROJET_URL_STEP_3))
            return "
        <nav class='ft-nav-formulaire-file-ariane'>
            <a href='" . get_permalink(get_page_by_path(FT_PROJET_URL_STEP_1)->ID) . "' id='ft-nav-link-step1'>step1</a>
            <a href='" . get_permalink(get_page_by_path(FT_PROJET_URL_STEP_2)->ID) . "' id='ft-nav-link-step2' class='disable-link'>step2</a>
            <a href='" . get_permalink(get_page_by_path(FT_PROJET_URL_STEP_3)->ID) . "' id='ft-nav-link-step3' class='disable-link'>step3</a>
        </nav>";
        else
            return "";
    }
}

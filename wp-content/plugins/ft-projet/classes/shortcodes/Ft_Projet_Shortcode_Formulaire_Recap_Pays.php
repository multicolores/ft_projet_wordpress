<?php

add_shortcode('FORMULAIRE_RECAP_PAYS', array('Ft_Projet_Shortcode_Formulaire_Recap_Pays', 'display'));

class Ft_Projet_Shortcode_Formulaire_Recap_Pays
{

    static function display()
    {
        $Ft_Projet_Crud_Index = new Ft_Projet_Crud_Index();
        $paysList = $Ft_Projet_Crud_Index->getProspectPays("1");

        $paysListHTML = "";
        foreach ($paysList as $pays) :
            $unstarValue = 5 - intval($pays['note']);
            $starsHTML = '<span class="star-' . $pays['note'] . '"></span><span class="empty-star-' . $unstarValue . '"></span>';

            $paysListHTML .= '<li>' . $starsHTML . $pays['nom'] . '</li>';
        endforeach;

        return "
            <ul class='ft_pays_list_container'>
            " . $paysListHTML . "
            </ul>

            <button id='ft-form-pays-recap'>Oui, je valide mes choix</button>

            <div id='handlebarsModalBox'></div>

            <script src='https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js'></script>
            ";
    }
}

<?php

add_shortcode('FORMULAIRE_INSCRIPTION', array('Ft_Projet_Shortcode_Formulaire_Inscription', 'display'));

class Ft_Projet_Shortcode_Formulaire_Inscription
{

    static function display($atts)
    {

        $Ft_Projet_Crud_Index = new Ft_Projet_Crud_Index();

        $lastProspectId = $Ft_Projet_Crud_Index->getLastProspectCreatedID();

        if ($lastProspectId)
            $paysList = $Ft_Projet_Crud_Index->getProspectPays($lastProspectId);
        else
            $paysList = [];

        $mapHTML = "";

        // check si le prospect a déjà des pays selectionné
        if (sizeof($paysList) != 0) {
            $paysListData = "[['Country'],";
            foreach ($paysList as $pays) :
                $paysListData .= "['" . $pays['nom'] . "'],";
            endforeach;
            $paysListData = substr($paysListData, 0, -1);

            $paysListData .= "]";

            $mapHTML = "
                <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
                <script type='text/javascript'>
                    google.charts.load('current', {
                    'packages':['geochart'],
                    });
                    google.charts.setOnLoadCallback(drawRegionsMap);
            
                    function drawRegionsMap() {
                    var data = google.visualization.arrayToDataTable(" . $paysListData . ");
            
                    var options = {};
            
                    var chart = new google.visualization.GeoChart(document.getElementById('ft-pays-map'));
            
                    chart.draw(data, options);
                    }
                </script>
                    
                <h1>Vos pays déjà selectionné : </h1>
                <div class='map-container'>
                    <div id='ft-pays-map' style='width: 900px; height: 500px;'></div>
                    <button id='ft-reinitialisation-choix-boutton'>Réinitialiser mes choix</button>
                </div>
            ";
        }



        return $mapHTML . "
        <form id='ft-form-inscription'>
            <fieldset>
                <legend>Vos informations</legend>
                
                <div>
                    <label for='nom'>Entrer votre nom:</label>
                    <input type='text' id='nom' name='nom' required='required'>
                </div>

                <div>
                    <label for='prenom'>Entrer votre prenom:</label>
                    <input type='text' id='prenom' name='prenom' required='required'>
                </div>

                <div>
                    <label for='sexe'>Quel est votre genre ?</label>
                    <select name='sexe' id='sexe' required='required'>
                        <option value='Homme'>Homme</option>
                        <option value='Femme'>Femme</option>
                    </select>
                </div>

                <div>
                    <label for='email'>Entrer votre email:</label>
                    <input type='email' id='email' name='email' required='required'>
                </div>

                <div>
                    <label for='date_naissance'>Entrer votre date de naissance:</label>
                    <input type='date' id='date_naissance' name='date_naissance' required='required'>
                </div>
            </fieldset>

            <button id='ft-submit-button-inscription'>Suivant</button>
        </form>
";
    }
}

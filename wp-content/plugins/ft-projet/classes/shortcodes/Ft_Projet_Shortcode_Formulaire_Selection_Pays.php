<?php

add_shortcode('FORMULAIRE_SELECTION_PAYS', array('Ft_Projet_Shortcode_Formulaire_Selection_Pays', 'display'));

class Ft_Projet_Shortcode_Formulaire_Selection_Pays
{

    static function display($atts)
    {
        $Ft_Projet_Crud_Index = new Ft_Projet_Crud_Index();
        $paysList = $Ft_Projet_Crud_Index->getPaysAboutProspectAge();

        $paysOptionsList = "";
        foreach ($paysList as $pays) :
            $paysOptionsList .= '<option value="' . $pays['id'] . '">' . $pays['nom'] . '</option>';
        endforeach;

        return "
        <form id='ft-form-pays-list-select'>
            <fieldset>
                <legend>Vos Pays</legend>
                
                <div>
                    <label for='pays1'>Selectionné votre pays</label>
                    <select name='pays1' id='ft_select_pays1' required='required'>
                    <option disabled selected value> -- sélectionnez un pays -- </option>
                    " . $paysOptionsList . "
                    </select>
                </div>

                <div class='disable-select-pays' id='ft_select_pays2_container'>
                    <label for='pays2'>Selectionné votre pays</label>
                    <select name='pays2' id='ft_select_pays2' >
                    <option disabled selected value> -- sélectionnez un pays -- </option>
                    " . $paysOptionsList . "
                    </select>
                </div>

                <div class='disable-select-pays' id='ft_select_pays3_container'>
                    <label for='pays3'>Selectionné votre pays</label>
                    <select name='pays3' id='ft_select_pays3' >
                    <option disabled selected value> -- sélectionnez un pays -- </option>
                    " . $paysOptionsList . "
                    </select>
                </div>

                <div class='disable-select-pays' id='ft_select_pays4_container'>
                    <label for='pays4'>Selectionné votre pays</label>
                    <select name='pays4' id='ft_select_pays4' >
                    <option disabled selected value> -- sélectionnez un pays -- </option>
                    " . $paysOptionsList . "
                    </select>
                </div>

                <div class='disable-select-pays' id='ft_select_pays5_container'>
                    <label for='pays5'>Selectionné votre pays</label>
                    <select name='pays5' id='ft_select_pays5' >
                    <option disabled selected value> -- sélectionnez un pays -- </option>
                    " . $paysOptionsList . "
                    </select>
                </div>

            </fieldset>

            <button class='disable-select-pays' id='ft-form-submit-pays-list-select'>Valider mes choix</button>
        </form>
";
    }
}

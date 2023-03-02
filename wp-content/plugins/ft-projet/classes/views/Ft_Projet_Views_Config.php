<?php

class Ft_Projet_Views_Config
{
    public function display()
    {
        $Wp_List = new Ft_Projet_Wp_List_Datas();
        $tempscreen = get_current_screen();

        $paysConfig = Ft_Projet_Crud_Index::getPays();

?>

        <div class="wrap">
            <h1 class="wp-heading-inline"><?php print get_admin_page_title(); ?></h1>
            <hr class="wp-header-end" />
            <div class="notice notice-info notice-alt is-dismissible hide delete-confirmation">
                <p><?php _e('Updated done!'); ?></p>
            </div>
            <div class="wrap" id="list-table">
                <table class="wp-list-table widefat striped">
                    <tfoot>
                        <tr>
                            <th colspan="2">
                                <button class="button button-primary" id="ft-submitPaysConfigForm">
                                    Modifier
                                </button>
                            </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <th>
                                <select name="pays" id="ft-pays-multiselect" multiple>
                                    <?php foreach ($paysConfig as $pays) : ?>
                                        <option value="<?php print $pays['id'] ?>" <?php if ($pays['disponible'] == 0) print 'selected'; ?>><?php print $pays['nom'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="helper-text">
                                    Les pays selectionnés serront indisponible pour vos utilisateur
                                </span>
                            </th>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>



<?php

    }
}

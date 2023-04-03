<?php

class Ft_Projet_Install
{

    public function __construct()
    {
        return;
    }

    public function setup()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';
        $table_name_prospects = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects';
        $table_name_prospects_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects_pays';

        $page = get_page_by_path('choix-voyage');
        $select_page = get_page_by_path('choix-voyage-step-select');
        $recap_page = get_page_by_path('choix-voyage-step-final');

        if ($this->isTableBaseAlreadyCreated($table_name_pays, $table_name_prospects, $table_name_prospects_pays) && $page && $select_page && $recap_page)
            return;

        $sql_create_pays_table = "CREATE TABLE IF NOT EXISTS $table_name_pays (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nom VARCHAR(255) NOT NULL,
            code_iso VARCHAR(255) NOT NULL,
            note SMALLINT(6) NOT NULL,
            majeur SMALLINT(6) NOT NULL,
            disponible SMALLINT(6) NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql_create_prospects_table = "CREATE TABLE IF NOT EXISTS $table_name_prospects (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nom VARCHAR(255) NOT NULL,
            prenom VARCHAR(255) NOT NULL,
            sexe VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            date_naissance DATETIME NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql_create_prospects_pays = "CREATE TABLE IF NOT EXISTS $table_name_prospects_pays (
                id_prospects mediumint(9) NOT NULL,
                id_pays mediumint(9) NOT NULL,
                date_choix DATETIME NOT NULL,
                FOREIGN KEY (id_prospects) REFERENCES $table_name_prospects(id),
                FOREIGN KEY (id_pays) REFERENCES $table_name_pays(id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        if (dbDelta($sql_create_pays_table)) {
            $this->createBasePays($table_name_pays);
            if (dbDelta($sql_create_prospects_table))
                dbDelta($sql_create_prospects_pays);
        }

        // ----- Création des pages a l'installation du plugin -----
        if (!$page) {

            $page = array(
                'post_title' => 'Inscription au choix voyage',
                'post_name' => 'choix-voyage',
                'post_content' => '[FORMULAIRE_FILE_ARIANE] [FORMULAIRE_INSCRIPTION]',
                'post_status' => 'publish',
                'post_type' => 'page'
            );

            $page_id = wp_insert_post($page);

            add_rewrite_rule(
                '^choix-voyage$',
                'index.php?page_id=' . $page_id,
                'top'
            );
        }


        if (!$select_page) {

            $select_page = array(
                'post_title' => 'Liste des pays',
                'post_name' => 'choix-voyage-step-select',
                'post_content' => '[FORMULAIRE_FILE_ARIANE] [FORMULAIRE_SELECTION_PAYS]',
                'post_status' => 'publish',
                'post_type' => 'page'
            );

            $select_page_id = wp_insert_post($select_page);

            add_rewrite_rule(
                '^choix-voyage-step-select$',
                'index.php?page_id=' . $select_page_id,
                'top'
            );
        }


        if (!$recap_page) {

            $recap_page = array(
                'post_title' => 'Récapitulatif des choix',
                'post_name' => 'choix-voyage-step-final',
                'post_content' => '[FORMULAIRE_FILE_ARIANE] [FORMULAIRE_RECAP_PAYS]',
                'post_status' => 'publish',
                'post_type' => 'page'
            );

            $recap_page_id = wp_insert_post($recap_page);

            add_rewrite_rule(
                '^choix-voyage-step-final$',
                'index.php?page_id=' . $recap_page_id,
                'top'
            );
        }

        return;
    }

    public function isTableBaseAlreadyCreated($table_name_pays, $table_name_prospects, $table_name_prospects_pays)
    {
        global $wpdb;

        $sqlPays = 'SHOW TABLES LIKE \'%' . $table_name_pays . '%\'';
        $sqlProspects = 'SHOW TABLES LIKE \'%' . $table_name_prospects . '%\'';
        $sqlProspectsPays = 'SHOW TABLES LIKE \'%' . $table_name_prospects_pays . '%\'';

        return $wpdb->get_var($sqlPays) && $wpdb->get_var($sqlProspects) && $wpdb->get_var($sqlProspectsPays);
    }

    public function createBasePays($table_name_pays)
    {
        global $wpdb;

        $pays_array = array(
            'ABW' => 'Aruba',
            'AFG' => 'Afghanistan',
            'AGO' => 'Angola',
            'AIA' => 'Anguilla',
            'ALA' => 'Åland Islands',
            'ALB' => 'Albania',
            'AND' => 'Andorra',
            'ARE' => 'United Arab Emirates',
            'ARG' => 'Argentina',
            'ARM' => 'Armenia',
            'ASM' => 'American Samoa',
            'ATA' => 'Antarctica',
            'ATF' => 'French Southern Territories',
            'ATG' => 'Antigua and Barbuda',
            'AUS' => 'Australia',
            'AUT' => 'Austria',
            'AZE' => 'Azerbaijan',
            'BDI' => 'Burundi',
            'BEL' => 'Belgium',
            'BEN' => 'Benin',
            'BES' => 'Bonaire, Sint Eustatius and Saba',
            'BFA' => 'Burkina Faso',
            'BGD' => 'Bangladesh',
            'BGR' => 'Bulgaria',
            'BHR' => 'Bahrain',
            'BHS' => 'Bahamas',
            'BIH' => 'Bosnia and Herzegovina',
            'BLM' => 'Saint Barthélemy',
            'BLR' => 'Belarus',
            'BLZ' => 'Belize',
            'BMU' => 'Bermuda',
            'BOL' => 'Bolivia, Plurinational State of',
            'BRA' => 'Brazil',
            'BRB' => 'Barbados',
            'BRN' => 'Brunei Darussalam',
            'BTN' => 'Bhutan',
            'BVT' => 'Bouvet Island',
            'BWA' => 'Botswana',
            'CAF' => 'Central African Republic',
            'CAN' => 'Canada',
            'CCK' => 'Cocos (Keeling) Islands',
            'CHE' => 'Switzerland',
            'CHL' => 'Chile',
            'CHN' => 'China',
            'CMR' => 'Cameroon',
            'COG' => 'Congo',
            'COK' => 'Cook Islands',
            'COL' => 'Colombia',
            'COM' => 'Comoros',
            'CPV' => 'Cape Verde',
            'CRI' => 'Costa Rica',
            'CUB' => 'Cuba',
            'CUW' => 'Curaçao',
            'CXR' => 'Christmas Island',
            'CYM' => 'Cayman Islands',
            'CYP' => 'Cyprus',
            'CZE' => 'Czech Republic',
            'DEU' => 'Germany',
            'DJI' => 'Djibouti',
            'DMA' => 'Dominica',
            'DNK' => 'Denmark',
            'DOM' => 'Dominican Republic',
            'DZA' => 'Algeria',
            'ECU' => 'Ecuador',
            'EGY' => 'Egypt',
            'ERI' => 'Eritrea',
            'ESH' => 'Western Sahara',
            'ESP' => 'Spain',
            'EST' => 'Estonia',
            'ETH' => 'Ethiopia',
            'FIN' => 'Finland',
            'FJI' => 'Fiji',
            'FLK' => 'Falkland Islands (Malvinas)',
            'FRA' => 'France',
            'FRO' => 'Faroe Islands',
            'FSM' => 'Micronesia, Federated States of',
            'GAB' => 'Gabon',
            'GBR' => 'United Kingdom',
            'GEO' => 'Georgia',
            'GGY' => 'Guernsey',
            'GHA' => 'Ghana',
            'GIB' => 'Gibraltar',
            'GIN' => 'Guinea',
            'GLP' => 'Guadeloupe',
            'GMB' => 'Gambia',
            'GNB' => 'Guinea-Bissau',
            'GNQ' => 'Equatorial Guinea',
            'GRC' => 'Greece',
            'GRD' => 'Grenada',
            'GRL' => 'Greenland',
            'GTM' => 'Guatemala',
            'GUF' => 'French Guiana',
            'GUM' => 'Guam',
            'GUY' => 'Guyana',
            'HKG' => 'Hong Kong',
            'HND' => 'Honduras',
            'HRV' => 'Croatia',
            'HTI' => 'Haiti',
            'HUN' => 'Hungary',
            'IDN' => 'Indonesia',
            'IMN' => 'Isle of Man',
            'IND' => 'India',
            'IOT' => 'British Indian Ocean Territory',
            'IRL' => 'Ireland',
            'IRN' => 'Iran, Islamic Republic of',
            'IRQ' => 'Iraq',
            'ISL' => 'Iceland',
            'ISR' => 'Israel',
            'ITA' => 'Italy',
            'JAM' => 'Jamaica',
            'JEY' => 'Jersey',
            'JOR' => 'Jordan',
            'JPN' => 'Japan',
            'KAZ' => 'Kazakhstan',
            'KEN' => 'Kenya',
            'KGZ' => 'Kyrgyzstan',
            'KHM' => 'Cambodia',
            'KIR' => 'Kiribati',
            'KNA' => 'Saint Kitts and Nevis',
            'KOR' => 'Korea, Republic of',
            'KWT' => 'Kuwait',
            'LBN' => 'Lebanon',
            'LBR' => 'Liberia',
            'LBY' => 'Libya',
            'LCA' => 'Saint Lucia',
            'LIE' => 'Liechtenstein',
            'LKA' => 'Sri Lanka',
            'LSO' => 'Lesotho',
            'LTU' => 'Lithuania',
            'LUX' => 'Luxembourg',
            'LVA' => 'Latvia',
            'MAC' => 'Macao',
            'MAR' => 'Morocco',
            'MCO' => 'Monaco',
            'MDA' => 'Moldova, Republic of',
            'MDG' => 'Madagascar',
            'MDV' => 'Maldives',
            'MEX' => 'Mexico',
            'MHL' => 'Marshall Islands',
            'MKD' => 'Macedonia, the former Yugoslav Republic of',
            'MLI' => 'Mali',
            'MLT' => 'Malta',
            'MMR' => 'Myanmar',
            'MNE' => 'Montenegro',
            'MNG' => 'Mongolia',
            'MNP' => 'Northern Mariana Islands',
            'MOZ' => 'Mozambique',
            'MRT' => 'Mauritania',
            'MSR' => 'Montserrat',
            'MTQ' => 'Martinique',
            'MUS' => 'Mauritius',
            'MWI' => 'Malawi',
            'MYS' => 'Malaysia',
            'MYT' => 'Mayotte',
            'NAM' => 'Namibia',
            'NCL' => 'New Caledonia',
            'NER' => 'Niger',
            'NFK' => 'Norfolk Island',
            'NGA' => 'Nigeria',
            'NIC' => 'Nicaragua',
            'NIU' => 'Niue',
            'NLD' => 'Netherlands',
            'NOR' => 'Norway',
            'NPL' => 'Nepal',
            'NRU' => 'Nauru',
            'NZL' => 'New Zealand',
            'OMN' => 'Oman',
            'PAK' => 'Pakistan',
            'PAN' => 'Panama',
            'PCN' => 'Pitcairn',
            'PER' => 'Peru',
            'PHL' => 'Philippines',
            'PLW' => 'Palau',
            'PNG' => 'Papua New Guinea',
            'POL' => 'Poland',
            'PRI' => 'Puerto Rico',
            'PRK' => 'Korea, Democratic People\'s Republic of',
            'PRT' => 'Portugal',
            'PRY' => 'Paraguay',
            'PSE' => 'Palestinian Territory, Occupied',
            'PYF' => 'French Polynesia',
            'QAT' => 'Qatar',
            'REU' => 'Réunion',
            'ROU' => 'Romania',
            'RUS' => 'Russian Federation',
            'RWA' => 'Rwanda',
            'SAU' => 'Saudi Arabia',
            'SDN' => 'Sudan',
            'SEN' => 'Senegal',
            'SGP' => 'Singapore',
            'SGS' => 'South Georgia and the South Sandwich Islands',
            'SHN' => 'Saint Helena, Ascension and Tristan da Cunha',
            'SJM' => 'Svalbard and Jan Mayen',
            'SLB' => 'Solomon Islands',
            'SLE' => 'Sierra Leone',
            'SLV' => 'El Salvador',
            'SMR' => 'San Marino',
            'SOM' => 'Somalia',
            'SPM' => 'Saint Pierre and Miquelon',
            'SRB' => 'Serbia',
            'SSD' => 'South Sudan',
            'STP' => 'Sao Tome and Principe',
            'SUR' => 'Suriname',
            'SVK' => 'Slovakia',
            'SVN' => 'Slovenia',
            'SWE' => 'Sweden',
            'SWZ' => 'Swaziland',
            'SYC' => 'Seychelles',
            'SYR' => 'Syrian Arab Republic',
            'TCA' => 'Turks and Caicos Islands',
            'TCD' => 'Chad',
            'TGO' => 'Togo',
            'THA' => 'Thailand',
            'TJK' => 'Tajikistan',
            'TKL' => 'Tokelau',
            'TKM' => 'Turkmenistan',
            'TLS' => 'Timor-Leste',
            'TON' => 'Tonga',
            'TTO' => 'Trinidad and Tobago',
            'TUN' => 'Tunisia',
            'TUR' => 'Turkey',
            'TUV' => 'Tuvalu',
            'TWN' => 'Taiwan',
            'UGA' => 'Uganda',
            'UKR' => 'Ukraine',
            'UMI' => 'United States Minor Outlying Islands',
            'URY' => 'Uruguay',
            'USA' => 'United States',
            'UZB' => 'Uzbekistan',
            'VCT' => 'Saint Vincent and the Grenadines',
            'VNM' => 'Viet Nam',
            'VUT' => 'Vanuatu',
            'WLF' => 'Wallis and Futuna',
            'WSM' => 'Samoa',
            'YEM' => 'Yemen',
            'ZAF' => 'South Africa',
            'ZMB' => 'Zambia',
            'ZWE' => 'Zimbabwe'
        );

        foreach ($pays_array as $iso => $pays_name) {
            $wpdb->insert($table_name_pays, array('nom' => $pays_name, 'code_iso' => $iso, 'note' => '3', 'majeur' => 0, 'disponible' => 1));
        }
    }
}

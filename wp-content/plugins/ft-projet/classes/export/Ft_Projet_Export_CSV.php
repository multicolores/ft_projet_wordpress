<?php

$path = __DIR__;
preg_match('/(.*)wp\-content/i', $path, $dir);
require_once(end($dir) . 'wp-load.php');

function triming(string $val): string
{
    return trim($val);
}

global $wpdb;

$table_name_prospects_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects_pays';
$table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';
$table_name_prospects = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_prospects';

$sql = "SELECT $table_name_pays.code_iso, $table_name_prospects.* FROM $table_name_prospects_pays INNER JOIN $table_name_pays on $table_name_prospects_pays.id_pays = $table_name_pays.id INNER JOIN $table_name_prospects on $table_name_prospects_pays.id_prospects = $table_name_prospects.id";

$prospects = $wpdb->get_results($sql, 'ARRAY_A');

ob_start();

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header('Content-Type: text/csv; charset=UTF-8');


$heads = array(
    'GENRE',
    'NOM',
    'PRENOM',
    'MAIL',
    'AGE',
    'PAYS'
);

print '"' . implode('"; "', $heads) . "\"\n";


foreach ($prospects as $prospect) :

    $prospect = array_map('triming', $prospect);

    $date = new DateTime($prospect['date_naissance']);
    $now = new DateTime();
    $interval = $now->diff($date);
    $age = $interval->y;

    $fields = array(
        (string) $prospect['sexe'],
        (string) mb_strtoupper($prospect['nom'], 'UTF-8'),
        (string) mb_strtoupper($prospect['prenom'], 'UTF-8'),
        (string) strtolower($prospect['email']),
        (string) $age,
        (string) $prospect['code_iso'],
    );

    print '"' . implode('"; "', $fields) . "\"\n";

endforeach;

$filename = sprintf('Export_Ft_Projet_Prospects_%s.csv', date('d-m-Y_His'));
header('Content-Disposition: attachment; filename="' . $filename . '";');
header('Content-Transfer-Encoding: binary');

ob_end_flush();

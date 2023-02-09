<?php

$path = __DIR__;
preg_match('/(.*)wp\-content/i', $path, $dir);
require_once(end($dir) . 'wp-load.php');

global $wpdb;

$table_name_pays = $wpdb->prefix . FT_PROJET_BASE_TABLE_NAME . '_pays';

$sql = "SELECT * FROM $table_name_pays";

$paysList = $wpdb->get_results($sql, 'ARRAY_A');

ob_start();

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false);
header("Content-type: text/xml");

$xml = new SimpleXMLElement('<PaysList/>');
$xw = xmlwriter_open_memory();

xmlwriter_start_document($xw, '1.0', 'UTF-8');

foreach ($paysList as $pays) :
    $event = $xml->addChild("pays");

    foreach ($pays as $key => $value)
        $$key = $value;


    $event->addChild("nom", $nom . " " . $code_iso);
    $event->addChild("note", $note);

    if ($majeur)
        $event->addChild("etre_majeur", "oui");
    else
        $event->addChild("etre_majeur", "non");


    if ($disponible)
        $event->addChild("statut", "actif");
    else
        $event->addChild("statut", "inactif");


// foreach ($pays as $key => $value) :
//     $event->addChild($key, $value);
// endforeach;

endforeach;

print $xml->asXML();


$filename = sprintf('Export_Ft_Pays_%s.xml', date('d-m-Y_His'));
header('Content-Disposition: attachment; filename="' . $filename . '";');
header('Content-Transfer-Encoding: binary');

ob_end_flush();

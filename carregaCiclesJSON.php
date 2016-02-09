<?php
	
$ciclesFormatius["0"]["0"] = "Sense Especificar";
$ciclesFormatius["1"]["0"] = "Sense Especificar";
$ciclesFormatius["1"]["101"] = "Gestió Administrativa (CFGM)";
$ciclesFormatius["1"]["102"] = "Secretariat (CFGS)";
$ciclesFormatius["1"]["103"] = "Administració i Finances (CFGS)";
$ciclesFormatius["2"]["0"] = "Sense Especificar";
$ciclesFormatius["2"]["201"] = "Preimpressió Digital (CFGM)";
$ciclesFormatius["2"]["202"] = "Disseny i Edició de Publicacions Impresses i Multimèdia (CFGS)";
$ciclesFormatius["3"]["0"] = "Sense Especificar";
$ciclesFormatius["3"]["301"] = "Electromecànica d'Automòbils (CFGM)";
$ciclesFormatius["4"]["0"] = "Sense Especificar";
$ciclesFormatius["4"]["401"] = "Sistemes Microinformàtics i Xarxes (CFGM)";
$ciclesFormatius["4"]["402"] = "Desenvolupament d'Aplicacions Web (CFGS)";
$ciclesFormatius["4"]["403"] = "Desenvolupament d'Aplicacions Multiplataforma (CFGS)";
$ciclesFormatius["4"]["404"] = "Administració de Sistemes Informàtics en la Xarxa (CFGS)";
$ciclesFormatius["5"]["0"] = "Sense Especificar";
$ciclesFormatius["5"]["501"] = "Instal·lació i Manteniment Electromecànic i Conducció de Línies (CFGM)";
$ciclesFormatius["5"]["502"] = "Manteniment d'Equips Industrials (CFGS)";
$ciclesFormatius["5"]["503"] = "Prevenció de Riscos Laborals (CFGS)";
$ciclesFormatius["6"]["0"] = "Sense Especificar";
$ciclesFormatius["6"]["601"] = "Mecanització (CFGM)";
$ciclesFormatius["6"]["602"] = "Programació de la Producció en Fabricació Mecànica (CFGS)";


$gremi = trim($_POST["gremi"]);
$elsCFs = $ciclesFormatius[$gremi];

foreach($elsCFs as $codigo => $nombre) {
  $elements_json[] = "\"$codigo\": \"$nombre\"";
}

echo "{".implode(",", $elements_json)."}"
?>
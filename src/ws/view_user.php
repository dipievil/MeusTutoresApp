<?php
/**
 * Busca dados do usuário
 * User: dipi
 * Date: 07/05/2015
 * Time: 20:14
 */

include_once("../lib/inc.wsconfig.php");

if (!empty($_POST["facebookId"])) {
    $facebookId = $_POST["facebookId"];
} else if(!empty($_GET["facebookId"])){
    $facebookId = $_GET["facebookId"];
    $jsonFormat = false;
    if($jsonFormat=='true')
        $jsonFormat = true;
}

$objSQL = new queryConsult();
$objSQL->tableName = 'user';
//$objSQL -> accessKey = $_REQUEST['key'];
$appPass = 'v5b6n7';
$objSQL -> accessKey = hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$appPass);
//$strQuery = $objSQL->execSelect();
$arrayGetValues = $objSQL->execSelect();

echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));



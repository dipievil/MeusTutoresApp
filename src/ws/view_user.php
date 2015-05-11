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
$objSQL -> accessKey = $_REQUEST['key'];
$objSQL -> wheresCol = 'facebookId';
$objSQL -> wheresVal = $facebookId;
$strQuery = $objSQL->execQuery();

header('Content-Type: application/json; charset=utf-8');
echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));



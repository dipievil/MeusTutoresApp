<?php

/*
 * Arquivo de controller de sessão e dados do facebook
 */

include("../class/class.facebook.php");
include("../class/class.query.php");
include("../class/class.mysql.php");

session_start();

$AccountController = new AccountController();
$strQuery = "[{'data':'vazio'}]";

if($_REQUEST['logout']){
    $AccountController->RemoveMtSession();
    $strQuery = "[{'message':'Sessão encerrada com sucesso'}]";
    unset($_SESSION);
    session_destroy();
    header('Content-Type: application/json; charset=utf-8');
    print_r($_SESSION);
    echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));
} else {
    //Se recebeu dados do face, seta a session
    if ($_REQUEST['facebookId'] && $_REQUEST['faceName'] && $_REQUEST['faceEmail']) {
        $AccountController->CreateMtSession($_REQUEST['facebookId'], $_REQUEST['faceName'], $_REQUEST['faceEmail']);
        $objConfig = new appConfig();
        $urlToGo = ($objConfig->isWebProduction()) ? $objConfig->production_path : $objConfig->development_path;
        header('Location: http://' . $urlToGo . '/html/index.html');
    }
    $strQuery =  $AccountController->RetornaSessionData(true);
}

if($_REQUEST['getSessionData']){
    header('Content-Type: application/json; charset=utf-8');
    echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));
}
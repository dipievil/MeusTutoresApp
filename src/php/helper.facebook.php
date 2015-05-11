<?php

/*
 * Arquivo de controller de sessão e dados do facebook
 */

include("../class/class.facebook.php");

session_start();

$AccountController = new AccountController();
$strQuery = "[{'data':'vazio'}]";

//Se recebeu dados do face, seta a session
if($_REQUEST['facebookId'] && $_REQUEST['faceName'] && $_REQUEST['faceEmail']){
    $userExists = false;
    //Cria sessão dos dados do Face
    $AccountController->userFaceId = $_REQUEST['facebookId'];
    $AccountController->userMtName = $_REQUEST['faceName'];
    $AccountController->userMtMail = $_REQUEST['faceEmail'];
    $AccountController->SetaDadosSessaoFacebook();
    $userExists = $AccountController->BuscarUsuarioFaceNoMt($_REQUEST['facebookId']);

    //Se existe o usuario, joga os dados na session
    if($userExists)
        $AccountController->RetornaSessionData();
}

if($_REQUEST['getSessionData']){
    $strQuery =  $AccountController->RetornaSessionData(true);
}

if($_REQUEST['redirect']){
    //Se existe o usuário, joga na home, senão faz o cadastro
    if(!$userExists){
        //Faz o cadastro
        //TODO
    }
    $objConfig = new appConfig();
    $urlToGo = ($objConfig->isWebProduction()) ? $objConfig->production_path : $objConfig->development_path;
    header('Location: http://'.$urlToGo.'/html/index.html');
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));
}








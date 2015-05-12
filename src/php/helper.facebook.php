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
$userExists = false;

//Se recebeu dados do face, seta a session
if($_REQUEST['facebookId'] && $_REQUEST['faceName'] && $_REQUEST['faceEmail']){
    $userExists = false;
    //Cria sessão dos dados do Face
    $AccountController->userFaceId = $_REQUEST['facebookId'];
    $AccountController->userFaceName = $_REQUEST['faceName'];
    $AccountController->userFaceMail = $_REQUEST['faceEmail'];
    $AccountController->SetaDadosSessaoFacebook();
    $userExists = $AccountController->BuscarUsuarioFaceNoMt($_REQUEST['facebookId']);

    //Se usuario nao existe, cria
    if(!$userExists){
        $insertedID = 0;
        $objSql = new queryConsult();
        $objSql->tableName = 'user';
        $objSql->whereBasicsVal =  $objSql->ClearString($_REQUEST['faceName']) . "," .
            "1," .
            $_REQUEST['faceName'] . "," .
            $_REQUEST['facebookId'] . ",".
            $_REQUEST['faceEmail'] . ",".
            "noPass,0,0,".date('Y-m-d H:i:s').",1";
        $objSql->whereBasicsCol = 'user,tipo,nome,facebookid,email,pass,points,flag,date,ativo';

        $insertedID = $objSql->ExecInsert();
        if($insertedID>0){
            $AccountController->BuscarUsuarioFaceNoMt($_REQUEST['facebookId']);
            $AccountController->SetaDadosSessaoMt();
        }


    } else{
        $AccountController->SetaDadosSessaoMt();
    }

    $strQuery = $AccountController->RetornaSessionData();
    $objConfig = new appConfig();
    $urlToGo = ($objConfig->isWebProduction()) ? $objConfig->production_path : $objConfig->development_path;
    header('Location: http://'.$urlToGo.'/html/index.html');
}

if($_REQUEST['getSessionData']){
    $strQuery =  $AccountController->RetornaSessionData(true);
    header('Content-Type: application/json; charset=utf-8');
    echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));
}










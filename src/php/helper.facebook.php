<?php

/*
 * Arquivo de controller de sess�o e dados do facebook
 */

include("../class/class.facebook.php");
session_start();

$AccountController = new AccountController();

//Se recebeu dados do face, seta a session
if($_REQUEST['facebookId'] && $_REQUEST['faceName'] && $_REQUEST['faceEmail']){
    //Cria sess�o dos dados do Face
    $AccountController->userFaceId = $_REQUEST['facebookId'];
    $AccountController->userMtName = $_REQUEST['faceName'];
    $AccountController->userMtMail = $_REQUEST['faceEmail'];
    $AccountController->SetaDadosSessaoFacebook();
    $AccountController->BuscarUsuarioFaceNoMt();
}






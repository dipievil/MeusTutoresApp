<?php

include("../class/class.mysql.php");
include("../php/config.php");
include("../php/class.query.php");
	
$jsonResult = '[{"":""}]';
session_start();
	

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	if (!empty($_POST["formUsername"]))
	{
		$userName = $_POST["formUsername"];
		$userType = $_POST["formType"];
        $email = $_POST["formEmail"];
		$facebookId = $_POST["formFacebookId"];

		//Objeto de acesso ao banco
		$objSQL = new queryConsult('question');

		$objSQL->accessKey = $accessKey;
		$objSQL->whereBasicsCol = 'nome';
		$objSQL->whereBasicsVal = "'".$userName."'";

		$strResultUser = $objSQL->execQuery(null);

        //Verifica se o usu�rio j� existe
        if(strpos($strResultUser,'question')>1){

            //J� existe a usu�rio
            $objQuestionError = json_decode($strResultUser);
            foreach($objQuestionError as $arItem){
                $idRepetido = $arItem->id;
            }
            //$arResult['message'] = utf8_encode('Esta d�vida j� existe.');
            $arResult['message'] = utf8_encode('Este usu�rio j� est� cadastrado no sistema. Verifique <a href="/perfil?id='.$idRepetido.'">aqui</a>.');
        } else {

            //Agrega outros valores ao insert
            $objSQL->whereBasicsCol .= 'facebookid,email,tipo';
            $objSQL->whereBasicsVal .= $facebookId.",".$email.",".$userType;

            $arResult['message'] = utf8_encode('Falha ao cadastrar o usu�rio.');

            //Insere os dados na base
            $resultInsert = $objSQL->insertQuery();

            if(is_numeric($resultInsert)){
                if($resultInsert>0){
                    $arResult['id'] = $resultInsert;
                    $arResult['message'] = utf8_encode('Cadastrado com sucesso.');
                } else {
                    $arResult['message'] = utf8_encode("Ocorreu um erro interno.");
                    $arResult['error'] = utf8_encode('Result:0');
                }
            } else {
                $arResult['error'] = utf8_encode($resultInsert);
                $arResult['message'] = utf8_encode("Ocorreu um erro interno.");
            }
        }
	} else {
		$arResult['message'] = utf8_encode("Voc� precisa enviar os dados!");
		$arResult['error'] = "No question sent.".($strParams);
	}
}


header('Content-Type: application/json; charset=utf-8');	
if(count($arResult)>0){
	$jsonResult = json_encode($arResult);
}
echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $jsonResult)));


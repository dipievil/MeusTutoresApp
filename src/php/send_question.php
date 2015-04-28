<?php

include("../class/class.mysql.php");
include("../php/config.php");
include("../php/class.query.php");

if (isset($_POST["formQuestion"]))
	$formQuestion = $_POST["formQuestion"];
if (isset($_POST["formQuestion"]))	
	$accessKey = $_POST['key'];	
	
$jsonResult = '[{"":""}]';
	
//DEBUG
$formQuestion = $_REQUEST["formQuestion"];
$accessKey = $_REQUEST['key'];
$idUser = "1";
$date = getdate();
$apppass = 'v5b6n7';
$accessKey=hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$apppass);			
//DEBUG	

if (strlen($formQuestion)>0 && strlen($accessKey))
{
	//Objeto de acesso ao banco
	$objSQL = new queryConsult('question');	
	
	$objSQL->accessKey = $accessKey;
	$objSQL->whereBasicsCol = 'question,id_user';
	$objSQL->whereBasicsVal = "'".$formQuestion."',".$idUser;
		
	$strResultAnswer = $objSQL->execQuery(null);
		
	//Verifica se a pergunta já existe
	if(strpos($strResultAnswer,'question')>1){
		
		//Já existe a pergunta
		$objQuestionError = json_decode($strResultAnswer);
		foreach($objQuestionError as $arItem){
			$idRepetido = $arItem->id;
		}
		//$arResult['message'] = utf8_encode('Esta dúvida já existe.');
		$arResult['message'] = utf8_encode('Esta dúvida já existe. Verifique <a href="/question?id='.$idRepetido.'">aqui</a>.');
		
	} else {
		$arResult['message'] = utf8_encode('Falha ao enviar a pergunta.');
	
		//Insere os dados na base
		$resultInsert = $objSQL->insertQuery();
		
		if(is_numeric($resultInsert)){
			if($resultInsert>0){
				$arResult['id'] = $resultInsert;
				$arResult['message'] = utf8_encode('Cadastrada com sucesso.');
			} else 
				$arResult['error'] = utf8_encode('Result:0');
		} else {
			$arResult['error'] = utf8_encode($resultInsert);
		}
	}
}


header('Content-Type: application/json; charset=utf-8');	
if(count($arResult)>0){
	$jsonResult = json_encode($arResult);
}

echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $jsonResult)));


?>

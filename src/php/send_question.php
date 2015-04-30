<?php

include("../class/class.mysql.php");
include("../php/config.php");
include("../php/class.query.php");
	
$jsonResult = '[{"":""}]';
session_start();
	
//DEBUG
	$_SESSION['userid'] = '1';		
//DEBUG	

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(!empty($_SESSION["userid"])){
		
		$idUser = $_SESSION['userid'];	
		
		if (!empty($_POST["formQuestion"]))
		{
			
			$formQuestion = $_POST["formQuestion"];
			if (!empty($_POST["key"]))
			{
				$accessKey = $_POST['key'];
				
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
						} else {
							$arResult['message'] = utf8_encode("Ocorreu um erro interno.");
							$arResult['error'] = utf8_encode('Result:0');
						}
					} else {
						$arResult['error'] = utf8_encode($resultInsert);
						$arResult['message'] = utf8_encode("Ocorreu um erro interno.");
					}
				}
			} else{
				$arResult['message'] = utf8_encode("Ocorreu um erro interno.");
				$arResult['error'] = "No access key.".($strParams);
			}
		} else {
			$arResult['message'] = utf8_encode("Você precisa enviar uma pergunta!");
			$arResult['error'] = "No question sent.".($strParams);
		}	
		
	}else{
		$arResult['message'] = utf8_encode("Você precisa estar logado");
	}
	
} else {
	$arResult['message'] = utf8_encode("Ocorreu um erro interno.");
	$arResult['error'] = "Form submit wrong";	
}


header('Content-Type: application/json; charset=utf-8');	
if(count($arResult)>0){
	$jsonResult = json_encode($arResult);
}
echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $jsonResult)));


?>

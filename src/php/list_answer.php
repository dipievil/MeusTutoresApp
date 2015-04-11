<?
	include("../class/class.mysql.php");

	header('Content-Type: application/json; charset=utf-8');

	$db = new MySQL();
	
	$arWhereBasics = array('flag' => '0');
	
	if($_REQUEST['id_answer']){
		$arCol = array('id_question','answer','id_user','voto');
		$arWhere = array('id_answer' => $_REQUEST['id_answer']);
	} else if($_REQUEST['id_user']){
		$arCol = array('id_answer','id_question','answer','voto');
		$arWhere = array('id_user' => $_REQUEST['id_user']);
	}else {
		$arWhere = array();
		$arCol = array('id_answer','id_question','answer','id_user','voto');
	}

	$arWhere = array_merge($arWhereBasics, $arWhere);	
	$strQuery = $db->GetJSON($db->Query($db->BuildSQLSelect('answer',$arWhere, $arCol)));
	
	echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));

	$db->Kill();
?>
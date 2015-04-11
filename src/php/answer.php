<?
	include("../class/class.mysql.php");

	header('Content-Type: application/json; charset=utf-8');

	$db = new MySQL(); 
	
	$arCol = array('id_answer','id_question','answer','id_user','voto');
	$arWhere = array('id_answer' => $_REQUEST['id_answer']);
	
	if($_REQUEST['id_answer']){
		$arWhere = array('id_answer' => $_REQUEST['id_answer']);
	}else {
		$arSort = array('id_answer');
		$sortAscending = True;
	}
	
	$strQuery = $db->GetJSON($db->Query($db->BuildSQLSelect('question',$arWhere, $arCol)));
	
	echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));

	$db->Kill();
?>
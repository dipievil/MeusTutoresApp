<?
	include("../class/class.mysql.php");

	header('Content-Type: application/json; charset=utf-8');

	$db = new MySQL(); 
	
	$arWhereBasics = array('flag' => '0');
	
	if($_REQUEST['id_question']){
		$arCol = array('question','id_user');
		$arWhere = array('id_question' => $_REQUEST['id_question']);
	} else if($_REQUEST['id_user']){
		$arCol = array('id_question','question');
		$arWhere = array('id_user' => $_REQUEST['id_user']);
	}else {
		$arWhere = array();
		$arCol = array('id_question','question','id_user');	
	}
	
	$arWhere = array_merge($arWhereBasics, $arWhere);
	$strQuery = $db->GetJSON($db->Query($db->BuildSQLSelect('question',$arWhere, $arCol)));
	
	echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));

	$db->Kill();
?>
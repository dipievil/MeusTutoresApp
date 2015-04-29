<?
	include("../class/class.mysql.php");
	include("../php/config.php");
	include("../php/class.query.php");

	$objSQL = new queryConsult();
	
	$objSQL->tableName = 'question';
	$objSQL->whereBasicsCol = 'ativo';
	$objSQL->whereBasicsVal = '1';
	$objSQL -> accessKey = $_REQUEST['key'];
	
	if($_REQUEST['answered']){
		$arWheresCol[] = 'aswered';
		$arWheresVal[] = '1';
	}
	
	if($_REQUEST['sortcolumns'])
		$objSQL->sqlSortColumns = $_REQUEST[$sortColumns];
	else
		$objSQL->sqlSortColumns = 'data';
	
	$objSQL->sqlSortAscending = 'DESC';
	
	if($_REQUEST['id_question']){
		$objSQL -> cols = 'question,id_user,data,answered,flag';
		$arWheresCol[] = 'id';
		$arWheresVal[] = $_REQUEST['id_question']; 
	} else if($_REQUEST['id_user']){
		$objSQL -> cols = 'id,question,data,answered,flag';	
		$arWheresCol[] = 'id_user';
		$arWheresVal[] = $_REQUEST['id_user'];
	} else {
		$objSQL -> cols = 'id,question,id_user,answered,data';
	}

	if(count($arWheresCol)>0)
		$objSQL -> wheresCol = implode($arWheresCol);
	if(count($arWheresVal)>0)
		$objSQL -> wheresVal = implode($arWheresVal); 
	
	$strQuery = $objSQL->execQuery('answer');

	header('Content-Type: application/json; charset=utf-8');	
	echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));
	
?>
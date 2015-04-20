<?
	include("../class/class.mysql.php");
	include("../php/config.php");
	include("../php/class.query.php");

	$objSQL = new queryConsult();
	
	//DEBUG//
	$date = getdate();
	$apppass = 'v5b6n7';
	$objSQL -> accessKey=hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$apppass);			
	//DEBUG//	
	
	$objSQL->tableName = 'question';
	$objSQL->whereBasicsCol = 'ativo';
	$objSQL->whereBasicsVal = '1';
	
	if($_REQUEST['answered']){
		$arWheresCol[] = 'aswered';
		$arWheresVal[] = '1';
	}
	
	if($_REQUEST[$sortColumns])
		$objSQL->sqlSortColumns = $_REQUEST[$sortColumns];
	else
		$objSQL->sqlSortColumns = 'data';
	
	$objSQL->sqlSortAscending = 'DESC';
	
	if($_REQUEST['id_question']){
		$objSQL -> cols = 'question,id_user,data,flag';
		$arWheresCol[] = 'id_question';
		$arWheresVal[] = $_REQUEST['id_question']; 
	} else if($_REQUEST['id_user']){
		$objSQL -> cols = 'id_question,question,data,flag';	
		$arWheresCol[] = 'id_user';
		$arWheresVal[] = $_REQUEST['id_user'];
	} else {
		$objSQL -> cols = 'id_question,question,id_user';
	}
	echo $objSQL -> cols;
	$objSQL -> wheresCol = implode($arWheresCol);
	$objSQL -> wheresVal = implode($arWheresVal); 
	
	$strQuery = $objSQL->execQuery();

	header('Content-Type: application/json; charset=utf-8');	
	echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));
	
?>
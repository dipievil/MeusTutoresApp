<?
	include("../class/class.mysql.php");
	include("../php/config.php");
	include("../php/class.query.php");

	$objSQL = new queryConsult();
	session_start();
	

	$objSQL -> accessKey = $_REQUEST['key'];	
	$objSQL->tableName = 'menu';
	$objSQL->whereBasicsCol = 'ativo';
	$objSQL->whereBasicsVal = '1';
	$objSQL->sqlSortColumns = 'order';
	$objSQL->sqlSortAscending = 'ASC';
	$objSQL->sqlOperator = 'OR';
	
	$arWheresCol[] = 'type';
	$arWheresVal[] = '1';
	if($_SESSION["userid"]){
		$arWheresCol[] = 'type';
		$arWheresVal[] = '2';		
	} else {
		$arWheresCol[] = 'type';
		$arWheresVal[] = '3';		
	}
	
	if(count($arWheresCol)>0)
		$objSQL -> wheresCol = implode(',',$arWheresCol);
	if(count($arWheresVal)>0)
		$objSQL -> wheresVal = implode(',',$arWheresVal); 
		
		
	
	$strQuery = $objSQL->execQuery();
	
	header('Content-Type: application/json; charset=utf-8');	
	echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));	

?>
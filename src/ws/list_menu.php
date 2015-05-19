<?

	include("../lib/inc.wsconfig.php");

	$objSQL = new queryConsult();
	session_start();

	$objSQL -> accessKey = $_REQUEST['key'];

	$date = getdate();
	$apppass = 'v5b6n7';
	$arKey = array("GeneratedKey"=>hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$apppass));
	$objSQL -> accessKey = $arKey['GeneratedKey'];

	$objSQL->tableName = 'menu';
	$objSQL->whereBasicsCol = 'ativo';
	$objSQL->whereBasicsVal = '1';
	$objSQL->sqlSortColumns = 'order';
	$objSQL->sqlSortAscending = 'ASC';
	$objSQL->sqlOperator = 'OR';


	if($_REQUEST["userid"]>0 && $_SESSION['mtSession']['userType']){
		$arWheresCol[] = 'type';
		$arWheresVal[] = $_SESSION['mtSession']['userType'];
	} else {
		$arWheresCol[] = 'type';
		$arWheresVal[] = '3';
	}
	
	if(count($arWheresCol)>0)
		$objSQL -> wheresCol = implode(',',$arWheresCol);
	if(count($arWheresVal)>0)
		$objSQL -> wheresVal = implode(',',$arWheresVal);
	
	$strQuery = $objSQL->execSelect();
	
	header('Content-Type: application/json; charset=utf-8');	
	echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));	

?>
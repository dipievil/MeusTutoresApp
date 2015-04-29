<?

	include("../class/class.mysql.php");
	include("../php/config.php");
	include("../php/class.query.php");

	$objSQL = new queryConsult();
	
	$objSQL->tableName = 'answer';
	$objSQL->whereBasicsCol = 'ativo';
	$objSQL->whereBasicsVal = '1';
	$objSQL -> accessKey = $_REQUEST['key'];

	if($_REQUEST['sortcolumns'])
		$objSQL->sqlSortColumns = $_REQUEST[$sortColumns];
	else
		$objSQL->sqlSortColumns = 'data';
	
	$objSQL->sqlSortAscending = 'DESC';
	
	if($_REQUEST['id_question']){
		$objSQL -> cols = 'id,id_user,votes,answer,data,flag';
		$arWheresCol[] = 'id_question';
		$arWheresVal[] = $_REQUEST['id_question']; 
	} else if($_REQUEST['id_answer']){
		$objSQL -> cols = 'id_user,id_question,votes,answer,data,flag';	
		$arWheresCol[] = 'id';
		$arWheresVal[] = $_REQUEST['id_answer'];
	} else {
		$objSQL -> cols = 'id,id_user,id_question,votes,answer,data,flag';
	}	
	
	if(count($arWheresCol)>0)
		$objSQL -> wheresCol = implode($arWheresCol);
	if(count($arWheresVal)>0)
		$objSQL -> wheresVal = implode($arWheresVal); 
		
	
	$strQuery = $objSQL->execQuery();

	header('Content-Type: application/json; charset=utf-8');	
	echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));	
	
?>
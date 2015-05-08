<?

include("../lib/inc.wsconfig.php");

$objSQL = new queryConsult();

$objSQL->tableName = 'user';
$objSQL->whereBasicsCol = 'ativo';
$objSQL->whereBasicsVal = '1';
$objSQL -> accessKey = $_REQUEST['key'];


$strQuery = $objSQL->execQuery();

header('Content-Type: application/json; charset=utf-8');
echo str_replace('\\','',html_entity_decode(preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $strQuery)));

?>
<?
	header('Content-Type: application/json; charset=utf-8');
	$_SERVER['REQUEST_METHOD'];
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$date = getdate();
		$apppass = 'v5b6n7';
		$arKey = array("GeneratedKey"=>hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$apppass));
		
	} else {
		$arKey = array(""=>"");
		
	}
	echo json_encode($arKey);
?>
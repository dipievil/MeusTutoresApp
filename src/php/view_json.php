<?

	$date = getdate();
	$apppass = 'v5b6n7';
	$accessKey=hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$apppass);
	
	$url = 'http://meustutoresapp.esy.es/php/'.$_REQUEST['file'].'.php?key='.$accessKey;
	$contents = file_get_contents($url);
	
	echo $contents;
	
?>
<?

	include("mysql.class.php");

	$db = new MySQL(); 
	
	if (! $db->Open("test", "localhost", "root", "password")) {
		$db->Kill();
	}
	
	echo "You are connected to the database<br />\n"; 

?>
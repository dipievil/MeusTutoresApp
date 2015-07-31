<?php
require("simple_restclient.php");


$uid	= "user1";	# USERNAME FOR THE CONNECTION
$pwd	= "pass1";	# PASSWORD FOR THE CONNECTION
$client =new RESTClient("http://localhost:233/REST/server.php"); 
$client->SetClass("Greetings");
$val = array('var1'=>'jeff','var2'=>'hi'); # ARGUMENTS THAT WILL BE PASSED FOR THE METHOD
if($client->Service_Exists()){	# CHECK IF THE SERVICE EXISTS
	$client->SetAuth($uid, $pwd);	# AUTHENTICATE THE CONNECTION
	$client->Call->Method("Morning",$val,$return); 	# CALLING THE METHOD class->Morning('jeff','hi').
	print $return;
}else{
	print "Service not available for $url!";
}
?>
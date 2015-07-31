<?php
require("simple_restserver.php");
require("Greetings.php");

			$users[] = array("user1","pass1");	# < SAMPLE USERS AND PASSWORDS <-OPTIONAL
			$users[] = array("user2","pass2");	# < SAMPLE USERS AND PASSWORDS <-OPTIONAL
			$RestServer =new RestServer();	
			$RestServer->
				SetAuth($users)->			# SETS THE SERVICE AUTHENTCATIONS <-OPTIONAL
					SetClass('Greetings')->	# SETS THE YOUR CLASS
						ClassResponse();	# METHOD FOR THE SERVICE RESPONSE
?>
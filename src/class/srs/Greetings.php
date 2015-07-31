<?php
	# CLASS THAT WILL BE USED FOR THE REST SERVER
	class Greetings {
		function Morning($name,$greet){
			return "Good <b>morning</b> $name $greet";
		}
		function Afternoon($name){
			return "Good <i>afternoon</i> $name";
		}
		function Evening(){
			return "Good <u>evening</u> to you!";
		}
		function Welcome($ar){
			$return = "<pre>\n";
			$return.= "&gt; $ar[name] good $ar[daytime]! &lt;\n";
			$return.= "</pre>";
			return $return;
		}
		function ArrayTest($e){
			$j = json_encode($e);
			return array("param"=>$e,"json"=>$j);
		}
		function Test1($r){
			print "Print $r";
		}
	}
# PHP END_FILE
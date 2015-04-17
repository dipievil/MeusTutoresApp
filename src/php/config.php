<?
	class appConfig {
		
		public $sql_list_size;
		public $app_vote_question;
		
		function appConfig () {
			//perguntas por pсgina
			$this -> sql_list_size = 5;
			
			//Quantos votos uma pergunta precisa para ser aprovada
			$this -> app_vote_question = 5;
		}
	}
	
	class sqlRules {
		
		private $whereBasicsCol; 	//Condiчуo where caso nуo tenha nenhuma nada
		private $whereBasicsVal;
		private $cols;		  		//Colunas a serem esxibidas em um select
		private $wheresCol;      	//Condiчуo where da query
		private $wheresVal;

		
		//Constructor
		function sqlRules($whereBasicsCol='',
						  $whereBasicsVal='',
						  $cols='',
						  $wheresCol='',
						  $wheresVal){
			
		}
		
		function execQuery(){
			
			//SETA os arrays
			var $arWhereBasics;
			var $arCols;
			var $wheresCol;
			
		}
		
		//
		function outPutJson(){
			
		}
		
		//Converte um ou mais strings com virgulas em arrays
		private function stringSplitToArray ($strValues,$strColumns = Null){
			
			var $arReturn = array ();
			
			if($strColumns == Null){
				$arCols = explode(',', $strColumns);
				$arvals = explode(',', $strValues); 
				$arReturn = array_combine($arCols,$arVals);
			} else {
				$arReturn = explode(',', $strValues);
			}
			
			return $arReturn;
		}
	}
?>
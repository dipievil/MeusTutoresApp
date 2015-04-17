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
		
		public $whereBasicsCol; 	//Condiчуo where caso nуo tenha nenhuma
		public $whereBasicsVal;
		public $cols;		  		//Colunas a serem exibidas em um select
		public $wheresCol;      	//Condiчуo where da query
		public $wheresVal;
		public $tableName;   		//Nome da tabela

		//Constructor
		function sqlRules($tableName='',
						  $whereBasicsCol='',
						  $whereBasicsVal='',
						  $cols='',
						  $wheresCol='',
						  $wheresVal=''){
							  	  
			$this->whereBasicsCol = $whereBasicsCol; 	
			$this->whereBasicsVal = $whereBasicsVal;
			$this->cols = $cols;		  		
			$this->wheresCol = $wheresCol;      	
			$this->wheresVal = $wheresVal;
			$this->tableName = $tableName;
			
		}
		
		//Roda a query caso os pre-requisitos 
		//estejam preenchidos
		function execQuery(){
			
			//Deve ter, pelo menos, o nome da tabela
			if (strlen($this->tableName)>0){
				
				//SETA os arrays
				//Filtros bсsicos
				$arWhereBasics = array();
				if(strlen($this->whereBasicsCol)>0 && strlen($this->whereBasicsVal)>0){
					$arWhereBasicsCol = explode(',',$this->whereBasicsCol);
					$arWhereBasicsVal = explode(',',$this->whereBasicsVal);
					$arWhereBasics = array_combine($arWhereBasicsCol,$arWhereBasicsVal);
				}
				
				//Filtros opcionais
				$arWheres = array();
				if(strlen($this->wheresCol)>0 && strlen($this->wheresVal)>0){
					$arWhereCol = explode(',',$this->wheresCol);
					$arWhereVal = explode(',',$this->wheresVal);
					$arWheres = array_combine($arWhereCol,$arWhereVal);
				}
				
				//Junta os arrays
				$arWheres = array_merge($arWhereBasics,$arWheres);
								
				//Filtros das colunas
				$arCols = array();
				if(strlen($cols)>0)
				{
					$arCols = explode(',',$cols);
				}	
					
					
				$db = new MySQL();			
				$sqlQuery = $db->BuildSQLSelect($this->tableName,$arWheres,$arCols);
				$db->Query($sqlQuery);
				$jsonQuery = $db->GetJSON();
			}
			return $jsonQuery;	
		}
		
		
		
		//
		function outPutJson(){
			
		}
		
		//Converte um ou mais strings com virgulas em arrays
		// private function stringSplitToArray ($strValues,$strColumns = Null){
			
			// $arReturn = array ();
			
			// if($strColumns == Null){
				// $arCols = explode(',', $strColumns);
				// $arvals = explode(',', $strValues); 
				// $arReturn = array_combine($arCols,$arVals);
			// } else {
				// $arReturn = explode(',', $strValues);
			// }
			
			// return $arReturn;
		// }
	}
?>
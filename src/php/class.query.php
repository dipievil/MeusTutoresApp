<?	

	// Name:	Classe Query Consult
	// Desc:	Realiza as consultas ao banco de dados
	// Date:    20/04/2015
	class queryConsult {
		
		public $whereBasicsCol; 	//Condiчуo where caso nуo tenha nenhuma
		public $whereBasicsVal;
		public $cols;		  		//Colunas a serem exibidas em um select
		public $wheresCol;      	//Condiчуo where da query
		public $wheresVal;
		public $tableName;   		//Nome da tabela
		private $transactionKey;	//Chave interna de controle
		public $accessKey;			//Chave de acesso enviada pelo usuсrio

		public $sqlSortColumns;		//Lista de colunas para ordenar
		public $sqlSortAscending;	//Ordem das colunas
		public $sqlLimit;			//Numero de linhas para busca

		//Constructor
		// Name:	Classe Query Consult
		// Desc:	Realiza as consultas ao banco de dados
		// Date:    20/04/2015		
		function queryConsult($tableName='',
						  $whereBasicsCol='',
						  $whereBasicsVal='',
						  $cols='',
						  $wheresCol='',
						  $wheresVal='',
						  $sortColumns = null,
						  $sortAscending = true, 
						  $limit = null){
							  	  
			$this->whereBasicsCol = $whereBasicsCol; 	
			$this->whereBasicsVal = $whereBasicsVal;
			$this->cols = $cols;		  		
			$this->wheresCol = $wheresCol;      	
			$this->wheresVal = $wheresVal;
			$this->tableName = $tableName;
			$config = new appConfig();
			$this->transactionKey = $config->transactionKey;
			
			$this->sqlSortColumns = $sortColumns;
			$this->sqlSortAscending = $sortAscending;
			if($limit == null){
				$this->sqlLimit = $config->sql_list_size;
			} else {
				$this->sqlLimit = $limit;
			}
		}
		
		//Roda a query caso os pre-requisitos 
		//estejam preenchidos
		function execQuery(){
			
			$db = new MySQL();
			
			//Deve corresponder a chave de acesso
			if($this->transactionKey == $this->accessKey){
			
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
					
					if(strlen($this->cols)>0){
						$arCols = explode(',',$this->cols);
					}else{
						//Todas as colunas
						$tableName = $this->tableName;
						$arCols = $db->GetColumnNames($tableName);
					}
					
					$sqlQuery = $db->BuildSQLSelect($this->tableName,
													$arWheres,
													$arCols,
													$this->sqlSortColumns,
													$this->sqlSortAscending,
													$this->sqlLimit);
						
					$db->Query($sqlQuery);
					$jsonQuery = $db->GetJSON();
					if($jsonQuery == null)
						$jsonQuery = "{':'}";

					
				} else {
					$jsonQuery = '{}';
				
				}
			} else {
				$jsonQuery = "{'error':'Accesskey check fail'}";
			}
			
			
			return $jsonQuery;
				
			$db->Kill();
		}
		
	}
?>
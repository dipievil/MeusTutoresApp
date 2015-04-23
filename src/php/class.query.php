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
		function execQuery($subtable = null,$DEBUG = null){
			
			$db = new MySQL();
			
			//Deve corresponder a chave de acesso
			
			if($this->transactionKey == $this->accessKey || $DEBUG != null){
			
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
				
					//Todas as colunas
					$tableName = $this->tableName;
					if(strlen($this->cols)>0){
						$arCols = explode(',',$this->cols);
					}else{
						$arCols = $db->GetColumnNames($tableName);
					}
					
					$sqlQuery = $db->BuildSQLSelect($tableName,
													$arWheres,
													$arCols,
													$this->sqlSortColumns,
													$this->sqlSortAscending,
													$this->sqlLimit);
					
					
					//JOINs
					// Verifica se a coluna possui sufixo '_id'
					// e substitui pelo valor da tabela correspondente
					foreach ($arCols as $coluna){
						if(strpos($coluna,'id_') !== false && $coluna != 'id_'.$tableName){
							//Nome da tabela do Join
							$tableCheck = str_replace('id_','',$coluna);
							
							//Altera coluna do ID pela coluna com valor
							$keyToChange = array_search($coluna,$arCols);
							$arColChange = $db->GetColumnNames($tableCheck);
							$arCols[$keyToChange] = $arColChange[1];
							$sqlQuery = str_replace('`'.$tableName.'`.`'.$coluna.'`','`'.$tableCheck.'`.`'.$arColChange[1].'`',$sqlQuery);
							
							//Adiciona o Join da tabela se ainda nуo tem
							if(strpos($sqlQuery,' JOIN `'.$tableCheck.'`') == null){
								
								$joinSQL = ' JOIN `'.$tableCheck.'` ON `'.$tableName.'`.`'.$coluna.'` = `'.$tableCheck.'`.`id`';
								$sqlQuery = str_replace(' WHERE',$joinSQL.' WHERE ',$sqlQuery);
							}
						}
					}
					
					if($DEBUG != null)
						echo $sqlQuery."\n\n";
					
					//$db->Query($sqlQuery);
					if(!$db->Query($sqlQuery)){
						$jsonQuery = "{'Error':'".$db->Error()."'}";
					} else {
						
						
						//Adiciona as subtabelas no array final
						$arSubTable = explode(",",'subtable');
						if(count($arSubTable)>0){
							//Converte resultados para array
							$arQuery = $db->RecordsArray();
							
							//Cada uma das tabelas
							foreach($arSubTable as $xtTable){
								
								//Verifica o valor da tabela
								foreach($arQuery as $valueTable){
									
									//Para cada valor de id, adiciona um novo ramo
									//Nome da subtabela
									$xtTblName = $xtTable;
									//Campo da tabela referenciado
									//$xtTblWheres = array('id_'.$tableName=>$valueTable);
									
									$sqlQuery = $db->BuildSQLSelect($xtTblName,
															$xtTblWheres,
															null,
															'data',
															true,
															null);	
									
								}
							}
							$jsonQuery = json_encode($arQuery);
						} else {
							$jsonQuery = $db->GetJSON();
						}
						
						
						if($jsonQuery == null)
							$jsonQuery = '{"":""}';
					}
					
				} else {
					$jsonQuery = '{"":""}';
				
				}
			} else {
				$jsonQuery = '{"error":"Accesskey check fail"}';
			}
			
			
			return $jsonQuery;
				
			$db->Kill();
		}
		
	}
?>
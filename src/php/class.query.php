<?	

	// Name:	Classe Query Consult
	// Desc:	Realiza as consultas ao banco de dados
	// Date:    20/04/2015
	class queryConsult {
		
		public $whereBasicsCol; 	//Condição where caso não tenha nenhuma
		public $whereBasicsVal;
		public $cols;		  		//Colunas a serem exibidas em um select
		public $wheresCol;      	//Condição where da query
		public $wheresVal;
		public $tableName;   		//Nome da tabela
		private $transactionKey;	//Chave interna de controle
		public $accessKey;			//Chave de acesso enviada pelo usuário

		public $sqlSortColumns;		//Lista de colunas para ordenar
		public $sqlSortAscending;	//Ordem das colunas
		public $sqlLimit;			//Numero de linhas para busca
		
		private $strQuery;
		private $DEBUGMODE = false;

	
		/**
		 * Constructor : inicializa as variáveis
		 * @param string $tableName Nome da tabela
		 * @param string $whereBasicsCol Lista de colunas básicas na busca separadas por vírgula
		 * @param string $whereBasicsVal Lista de valores básicas na busca separados por vírgula
		 * @param string $cols Lista de colunas separadas por vírgula
		 * @param string $wheresCol Colunas da busca
		 * @param string $wheresVal Valores da busca
		 * @param string $sortColumns Colunas para ordenar
		 * @param string $sortAscending Ordem alfabética
		 * @param string $limit Número de resultados
		 * 
		 */		
		public function __construct($tableName='',
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
		
		/**
		 * Limpa as propriedades principais
		 */		
		public function ResetClass(){
			$this->whereBasicsCol = null; 	
			$this->whereBasicsVal = null;
			$this->cols = null;
			$this->wheresCol = null;
			$this->wheresVal = null;
			$this->tableName = null;	
			$this->sqlSortColumns = null;
			$this->sqlSortAscending = true;
		}
		
		/**
		 *  Insere as Joins quando necessário
		 * @param array $arCols Array de colunas
		 * @param string $query Querie a ser alterada
		 * @param array $tableName Nome da tabela a receber os joins
		 * @return string Retorna a uma querie com os joins
		 */
		private function InserJoins($arCols,$query = null,$tableName = null){
			$db = new MySQL();			
			if($tableName == null){
				$tableName = $this->tableName;	
			}

			if(strlen($query)<1)
				$sqlQuery = $this->strQuery;
			else 
				$sqlQuery = $query;
			
			
			//JOINs
			// Verifica se a coluna possui sufixo '_id'
			// e substitui pelo valor da tabela correspondente
			foreach ($arCols as $coluna){
				if(strpos($coluna,'id_') !== false && $coluna != 'id_'.$tableName){
					//Nome da tabela do Join
					$tableCheck = str_replace('id_','',$coluna);
					
					//Altera coluna do ID pela coluna com valor
					$keyToChange = array_search($coluna,$arCols);
					
					//Coluna para alterar
					$arColChange = $db->GetColumnNames($tableCheck);
					
					//Adiciona a nova coluna ao array
					//$arCols[] = $arColChange[1];
					
					$strQuerySearch = '`'.$tableName.'`.`'.$coluna.'`';
					$strQueryReplace = '`'.$tableName.'`.`'.$coluna.'`,`'.$tableCheck.'`.`'.$arColChange[1].'`';
					
					if($this->DEBUGMODE)
					echo "\n\nQuerie antes Join: ".$sqlQuery;
					
					//Altera a query
					$pos = strpos($sqlQuery,$strQuerySearch);
					if ($pos !== false) {
						$sqlQuery = substr_replace($sqlQuery,$strQueryReplace,$pos,strlen($strQuerySearch));
					}
					
					//Adiciona o Join da tabela se ainda não tem
					if(strpos($sqlQuery,' JOIN `'.$tableCheck.'`') == null){
						
						$joinSQL = ' JOIN `'.$tableCheck.'` ON `'.$tableName.'`.`'.$coluna.'` = `'.$tableCheck.'`.`id`';
						$sqlQuery = str_replace(' WHERE',$joinSQL.' WHERE ',$sqlQuery);
					}
					
					if($this->DEBUGMODE)
					echo "\n\nQuerie depois Join : ".$sqlQuery;
				}
			}
			
			if($query == null){
				$this->strQuery = $sqlQuery;
			} else {
				return $sqlQuery;
			}
		}

		
		/**
		 * [STATIC] Adiciona os dados da subtabela
		 * @param string $subtable Nome da subtabela
		 * @param array $arQuery Array com resultados da última querie
		 * @return array Retorna o arry da querie com os resultados da subtabela
		 */		
		private function SubTableAdd($subtable, $arQuery){
			
			$db = new MySQL();
			$arSubTable = explode(",",$subtable);		
			$arNewQuery = null;
			$tableName = $this->tableName;
				
			//Cada uma das tabelas
			foreach($arSubTable as $xtTable){
				
				//Verifica o valor da tabela
				for($i=0;$i<count($arQuery);$i++){
					
					//Para cada valor de id, adiciona um novo ramo
					
					//Nome da subtabela
					$xtTblName = $xtTable;
					
					//Chave da subtabela na tabela atual
					$idvalue = $arQuery[$i]['id'];
					
					//Campo da tabela referenciado
					$xtTblWheres = array('id_'.$tableName=>$idvalue);
					
					//Joins da Subtabela	
					$arxtColNames = $db->GetColumnNames($xtTblName);
					
					$sqlxtQuery = $db->BuildSQLSelect($xtTblName,
											$xtTblWheres,
											$arxtColNames,
											'data',
											true,
											null);
											
												
					if($this->DEBUGMODE){
						echo "\n\n subtabela BEFORE :\n ";
					}
						
					$sqlxtQuery = $this->inserJoins($arxtColNames, $sqlxtQuery, $xtTblName);
						
					if($this->DEBUGMODE)
						echo "\n subtabela AFTER: \n";	


					//Adiciona subconsulta ao array final
					if($db->Query($sqlxtQuery)){
						$arQuerySub = $db->RecordsArray();
						$arQuery[$i]['tbl'.$xtTblName] = $arQuerySub;
					} else {
						$arQuery = array("['Erro na subtabela':'".$db->Error()."']");
					}
				}
			}
			
			$arNewQuery = $arQuery;

			return $arNewQuery;
		}
		
		/**
		 * [STATIC] Roda uma query de insert
		 * @return string Retorna o json com o resultado
		 */			
		public function insertQuery(){
			//TODO
		}
		
		/**
		 * Roda uma query de select
		 * @param string $subtable Nome da subtabela
		 * @param bool $DEBUG True se deseja debugar
		 * @return string Retorna o json com o resultado
		 */			
		function execQuery($subtable = null,$DEBUG = null){
			
			$db = new MySQL();
			if($DEBUG)
				$this->DEBUGMODE = true;
			
			//Deve corresponder a chave de acesso
			
			if($this->transactionKey == $this->accessKey || $this->DEBUGMODE != null){
			
				//Deve ter, pelo menos, o nome da tabela
				if (strlen($this->tableName)>0){
					
					//SETA os arrays
					//Filtros básicos
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
													
					$this->strQuery = $sqlQuery;													
					
					//Trata os JOINS
					$this->InserJoins($arCols);
					
					if(!$db->Query($this->strQuery)){
						$jsonQuery = "{'Error':'".$db->Error()."'}";
					} else {
						
						$arQuery = $db->RecordsArray();
						
						
						if(strlen($subtable)>0){
							//Adiciona as subtabelas no array final							
							$arQuery = $this->SubTableAdd($subtable,$arQuery);
						}
						
						$jsonQuery = json_encode($arQuery);
						
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
<?
	// Name:	Configuration class
	// Desc:	Centraliza todas as op��es de configura��o da aplica��o
	// Date:    20/04/2015
	class appConfig {
		
		public $sql_list_size;
		public $app_vote_question;
		public $transactionKey;
		
		//Constructor da classe
		function appConfig () {
			//perguntas por p�gina
			$this -> sql_list_size = 5;
			
			//ordena��o dos resultados
			$this -> sql_result_order = "DESC";
			
			//Quantos votos uma pergunta precisa para ser aprovada
			$this -> app_vote_question = 5;
			
			//Chave de encripta��o
			$date = getdate();
			$apppass = 'v5b6n7';
			$this -> transactionKey=hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$apppass);
		}
	}

?>
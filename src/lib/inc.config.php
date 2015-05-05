<?
	// Name:	Configuration class
	// Desc:	Centraliza todas as op��es de configura��o 
	//          e regras de neg�cio da aplica��o
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
			
			//Quantos votos uma pergunta precisa para ser aprovada ou reprovada
			$this -> app_vote_question_aprove = 5;
			$this -> app_vote_question_reprove = 5;
			
			//N�mero de den�ncias para excluir perguntas
			$this -> app_flag_limits = 10;
			
			//Niveis do usu�rio professor
			$this -> profile_points_teacher = 10; //Pode responder
			$this -> profile_points_supervisor = 30; //Pode
			$this -> profile_points_manager = 60;
			$this -> profile_points_master = 100;
			
			//Chave de encripta��o
			$date = getdate();
			$apppass = 'v5b6n7';
			$this -> transactionKey=hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$apppass);
		}
	}
?>
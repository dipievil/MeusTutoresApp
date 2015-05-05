<?
	// Name:	Configuration class
	// Desc:	Centraliza todas as opções de configuração 
	//          e regras de negócio da aplicação
	// Date:    20/04/2015
	class appConfig {
		
		public $sql_list_size;
		public $app_vote_question;
		public $transactionKey;
		
		//Constructor da classe
		function appConfig () {
			//perguntas por página
			$this -> sql_list_size = 5;
			
			//ordenação dos resultados
			$this -> sql_result_order = "DESC";
			
			//Quantos votos uma pergunta precisa para ser aprovada ou reprovada
			$this -> app_vote_question_aprove = 5;
			$this -> app_vote_question_reprove = 5;
			
			//Número de denúncias para excluir perguntas
			$this -> app_flag_limits = 10;
			
			//Niveis do usuário professor
			$this -> profile_points_teacher = 10; //Pode responder
			$this -> profile_points_supervisor = 30; //Pode
			$this -> profile_points_manager = 60;
			$this -> profile_points_master = 100
			
			//Chave de encriptação
			$date = getdate();
			$apppass = 'v5b6n7';
			$this -> transactionKey=hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$apppass);
		}
	}

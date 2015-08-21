<?
	// Name:	Configuration class
	// Desc:	Centraliza todas as op��es de configura��o 
	//          e regras de neg�cio da aplica��o
	// Date:    20/04/2015


class appConfig {
		
    public $sql_list_size;
    public $app_vote_question;
    public $transactionKey;
    public $app_vote_question_aprove;
    public $app_vote_question_reprove;
    public $app_flag_limits;
    public $profile_points_teacher;
    public $profile_points_supervisor;
    public $profile_points_manager;
    public $profile_points_master;
    public $development_path;
    public $production_path;

    public $db_user;
    public $db_pass;
    public $db_dbname;

    /**
     * Construtor da Classe
     */
    function appConfig () {
        //perguntas por pagina
        $this -> sql_list_size = 5;

        //ordena��o dos resultados
        $this -> sql_result_order = "DESC";

        //Quantos votos uma pergunta precisa para ser aprovada ou reprovada
        $this -> app_vote_question_aprove = 5;
        $this -> app_vote_question_reprove = 5;

        //Número de dependências para excluir perguntas
        $this -> app_flag_limits = 10;

        //Niveis do usu�rio professor
        $this -> profile_points_teacher = 10; //Pode responder
        $this -> profile_points_supervisor = 30; //Pode
        $this -> profile_points_manager = 60;
        $this -> profile_points_master = 100;

        //Variaveis de caminho
        $this -> alfa_path = 'mtappalfa.esy.es';
        $this -> development_path = 'meustutoresapp.esy.es';
        $this -> production_path = 'www.meustutoresapp.com.br';

        //Configurações de banco
        switch($_SERVER['HTTP_HOST']){
            case $this -> alfa_path:
                $db_user = "u386071783_mtapp"; //user name
                $db_pass = "nEalQ6uSzi"; //password
                $db_dbname = "u386071783_mtapp"; //database name
            break;
            case $this -> development_path:
                $db_user = "u144166463_mtapp"; //user name
                $db_pass = "nEalQ6uSzi"; //password
                $db_dbname = "u144166463_mtapp"; //database name
            break;
            case $this -> production_path:
                $db_user = "u144166463_mtapp"; //user name
                $db_pass = "nEalQ6uSzi"; //password
                $db_dbname = "u144166463_mtapp"; //database name
            break;

        }

        //Chave de encriptação
        $date = getdate();
        $appPass = 'v5b6n7';
        $this -> transactionKey=hash('sha512', $date[mday].$date[mon].$date[year].$date[minutes].$appPass);
    }

    public function isWebProduction(){
        $boolIsProd = false;
        $dominioAtual = $_SERVER['HTTP_HOST'];
        if($dominioAtual == $this->production_path)
            $boolIsProd = true;
        return $boolIsProd;
    }
}
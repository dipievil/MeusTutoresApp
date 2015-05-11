<?php

session_start();

class AccountController {

    public $sessionMtId;
    public $userMtId;
    public $userMtName;
    public $userFaceName;
    public $userFaceId;
    public $userFaceMail;
    public $userMtType;

    private $sessionId;
    private $mtSessionKey;

    /**
     * Classe do constructor
     */
    public function __construct(){
        /*
         * mt Stuff
         */
        $this->userMtMail = null;
        $this->userMtId = null;
        $this->userMtName = null;
        $this->userMtType = null;

        /*
         * Facebook stuff
         */
        $this->userFaceName = null;
        $this->userFaceId = null;
        $this->userFaceMail = null;

        //Id dessa sessao
        $this->sessionId = null;
        $this->mtSessionKey = 'mtApp';

        //Segurança
        $this->GetSessionData();
    }

    /**
     * Verifica se a chave de segurança está ok
     * @param null $jsonFormat
     * @return bool|null|string
     */
    private function CheckSessionKey($jsonFormat=null){
        $jsonReturnCheck = null;
        $mtUserId = $this->userMtId;
        $keyPass = $this->mtSessionKey;
        $strHashInterno = hash('sha512', $keyPass.$mtUserId);

        //verifica na classe
        if($strHashInterno == $this->mtSessionKey){
            if($strHashInterno == $_SESSION['sessionMtId']){
                $jsonReturnCheck = $jsonFormat ? "[{'error':'ok'}]" : true;
            } else {
                $jsonReturnCheck = $jsonFormat ?"[{'error':'Chave da sessão não confere'}]" : false;
            }
        } else {
            $jsonReturnCheck = $jsonFormat ? "[{'error':'Erro interno de verificação das chaves'}]" : false;
        }
        return $jsonReturnCheck;
    }

    /**
     *Pega os dados da sessão e preenche a classe
     */
    private function GetSessionData()
    {
        if($_SESSION['sessionMtId']){
            $this->sessionId = $_SESSION['sessionMtId'];
            if($_SESSION['facebook']['facebookId'])
                $this->PegaDadosSessaoFacebook();
            if($_SESSION['mtSession']['userId'])
                $this->PegaDadosSessaoMt();
        }
    }

    /**
     * Salva os dados do Facebook na sess�o
     */
    public function SetaDadosSessaoFacebook(){

        $userId = $this->userFaceId;
        $userMail = $this->userFaceMail;
        $userName = $this->userFaceName;

        if($userId && $userName && $userMail){
            $_SESSION['facebook']['facebookId'] = $userId;
            $_SESSION['facebook']['userName'] = $userName;
            $_SESSION['facebook']['userMail'] = $userMail;
        }
    }

    /**
     * Pega os dados de sessão do Facebook e
     * grava na classe
     */
    private function PegaDadosSessaoFacebook(){
        $userId = $_SESSION['facebook']['facebookId'];
        $userName = $_SESSION['facebook']['userName'];
        $userMail = $_SESSION['facebook']['userMail'];

        if($userId && $userName && $userMail){
            $this->userFaceId = $userId;
            $this->userFaceMail =  $userMail;
            $this->userFaceName = $userName;
        }
    }

    /**

     * Seta os dados do MtApp na session
     */
    private function SetaDadosSessaoMt(){

        $userId = $this->userMtId;
        $userName = $this->userMtName;
        $userMail = $this->userMail;

        if($userId && $userName && $userMail){
            $_SESSION['mtSession']['userId'] = $userId;
            $_SESSION['mtSession']['userName'] = $userName;
            $_SESSION['mtSession']['userMail'] = $userMail;

        }
    }

    /**
     * Seta os dados da sessao MtApp na classe
     */
    private function PegaDadosSessaoMt(){

        $userId = $_SESSION['mtSession']['userId'];
        $userName = $_SESSION['mtSession']['userName'];
        $userMail = $_SESSION['mtSession']['userMail'];

        $this->userMtId = $userId;
        $this->userMtName = $userName;
        $this->userMail = $userMail;
    }

    /**
     *
     * Busca usuário logado no face no mt. Cria
     * session caso ainda não exista
     * @param $facebookId Id do facebook do usu�rio
     * @return bool Retorna true se existe
     */
    public function BuscarUsuarioFaceNoMt($facebookId){

        include ('../lib/inc.config.php');
        $userMtExists = false;
        $ambienteUrl = null;
        $objConfig = new appConfig();
        $appKey = $objConfig->transactionKey;

        $ambienteUrl = $objConfig->isWebProduction() ? $objConfig->production_path : $objConfig->development_path;
        $jsonUserData = file_get_contents('http://'.$ambienteUrl.'/ws/view_user.php?redirect=true&facebookId='.$facebookId.'&key='.$appKey);
        $arUser = json_decode($jsonUserData);

        //Cria a session com os dados do usuário
        if($arUser['id']) {
            $this->userMtId = $arUser['id'];
            $this->userMtName = $arUser['nome'];
            $this->userMtMail = $arUser['email'];
            $this->userMtType = $arUser['tipo'];
            $this->SetaDadosSessaoMt();
            $this->CreateSessionId();
            $userMtExists = true;
        }
        return $userMtExists;
    }

    /**
     * Retorna a chave da sessao
     * @return null|string
     */
    private function CreateSessionId(){
        $returnHash = null;

        $mtUserId = $this->userMtId;
        $keyPass = $this->mtSessionKey;

        if($mtUserId && $keyPass){
            $returnHash = hash('sha512', $keyPass.$mtUserId);
            $this->sessionId = $returnHash;
            $_SESSION['sessionMtId'] = $returnHash;
        }

        return $returnHash;
    }

    public function SetSessionKey(){
        if($_SESSION['sessionMtId']){
            $this->sessionId = $_SESSION['sessionMtId'];
        }
    }


    /**
     * Destroi a sessão
     * @param null $clearClass Limpa os dados da classe
     */
    private function destroySession($clearClass=null)
    {
        unset($_SESSION);
        if($clearClass){
            $this->ClearClass();
        }
    }

    /**
     * Limpa os dados de user da classe
     */
    private function ClearClass()
    {
        $this->userFaceId = null;
        $this->userFaceName = null;
        $this->userFaceMail = null;

        $this->userMtId = null;
        $this->userMtName = null;
        $this->userMtMail = null;
        $this->userMtType = null;

        $this->sessionId = null;
    }

    /**
     * TODO
     * @param bool|null $jsonData False para retornar em JSON
     * @return array|string Array ou JSON com os dados do usu�rio
     */
    public function BuscarDadosFace($jsonData = false){

    }

    /**
     * Retorna a sessão atual do sistema
     * @param bool $retornaJson Retorna em formato json
     * @return null|string Dados da session atual
     */
    public function RetornaSessionData($retornaJson = false)
    {
        $arReturnData = null;


        $arReturnData['sessionMtId'] = $_SESSION['sessionMtId'];

        $arReturnData['mtSessionUserId'] = $_SESSION['mtSession']['userId'];
        $arReturnData['mtSessionUserName'] = $_SESSION['mtSession']['userName'];
        $arReturnData['mtSessionUserMail'] = $_SESSION['mtSession']['userMail'];

        $arReturnData['facebookFacebookId'] = $_SESSION['facebook']['facebookId'];
        $arReturnData['facebookUserName'] = $_SESSION['facebook']['userName'];
        $arReturnData['facebookUserMail'] = $_SESSION['facebook']['userMail'];


        if(!$arReturnData['sessionMtId'])
            $arReturnData = null;

        if($retornaJson)
            $returnData = json_encode($arReturnData);
        else
            $returnData = $arReturnData;

        return $returnData;
    }
}

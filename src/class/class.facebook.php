<?php

class AccountController {

    public $sessionMtId;
    public $userMtId;
    public $userMtName;
    public $userFaceName;
    public $userFaceId;
    public $userFaceMail;

    private $sessionId;

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

        /*
         * Facebook stuff
         */
        $this->userFaceName = null;
        $this->userFaceId = null;
        $this->userFaceMail = null;

        $this->sessionId=null;

        /*
         *
        $_SESSION['mtSession']['userId'];
        $_SESSION['mtSession']['userName'];
        $_SESSION['mtSession']['userMail'];
        $_SESSION['mtSession']['facebookId'];
        $_SESSION['facebook']['facebookId'];
        $_SESSION['facebook']['userName'];
        $_SESSION['facebook']['userMail'];
         *
         */
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
     * Seta os dados do MtApp na session
     */
    public function SetaDadosSessaoMt(){

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
     *
     * Salva nas propriedades os dados do
     * usu�rio Mt
     * @param $facebookId Id do facebook do usu�rio
     * @return bool Retorna true se existe
     */
    public function BuscarUsuarioMt($facebookId){

        $userMtExists = false;
        $ambienteUrl = null;

        $objConfig = new appConfig();

        $ambienteUrl = $objConfig->isWebProduction() ? $objConfig->production_path : $objConfig->development_path;

        $jsonUserData = file_get_contents('http://'.$ambienteUrl.'/ws/view_user.php?facebookId='.$facebookId);

        if(count($arUser)) {
            $this->userMtId = $arUser['id'];
            $this->userMtName = $arUser['nome'];
            $this->userMtMail = $arUser['email'];
            $this->SetaDadosSessaoMt();
            $userMtExists = true;
        }
        return $userMtExists;
    }


    /**
     * TODO
     * Verifica se tem um usu�rio logado no Facebook
     * @return bool True se est� logado
     */
    public function VerificarUserFaceLogado(){
        $session = null;
        $logado = false;

        return $logado;
    }

    /**
     * Seta o ID da sessao
     * @param bool $returnKey Se sim, retorna a chava ao inv�s de gravar
     * na classe
     * @return null|string Chave da session
     * @internal param Id $FacebookUserId do usu�rio do Facebook
     */
    private function SetSessionId($returnKey = false){
        $passName = 'mtApp';
        $returnHash = null;
        $facebookUserId = $this->userFaceId;
        $mtUserId = $this->userMtId;
        if($facebookUserId && $mtUserId){
            $returnHash = hash('sha512', $facebookUserId.$passName.$mtUserId);
        }
        if($returnKey){
            return $returnHash;
        } else{
            $this->sessionId = $returnHash;
        }
    }

    /**
     * TODO
     */
    public function VerificarUserMtLogado(){
        if($_SESSION['mtSession']['userId']){

        }
    }

    /**
     * TODO
     * @param $FacebookID
     */
    public function VerificaUserFaceExiste($FacebookID){

    }


    /**
     * TODO
     * @param bool|null $jsonData False para retornar em JSON
     * @return array|string Array ou JSON com os dados do usu�rio
     */
    public function BuscarDadosFace($jsonData = false){


    }



}

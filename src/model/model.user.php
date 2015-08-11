<?php
class User extends DomainObjectAbstract
{
    public $id;
    public $user;
    public $tipo;
    public $nome;
    public $facebookid;
    public $email;
    public $pass;
    public $points;
    public $flag;
    public $date;
    public $ativo;

    /**
     * Get the full name of the User
     *
     * Demonstrates how other functions can be
     * added to the DomainObject
     *
     * @return string
     */
    public function getName()
    {
        return $this->nome;
    }
}
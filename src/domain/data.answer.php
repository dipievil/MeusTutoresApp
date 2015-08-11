<?php
class Answer extends DomainObjectAbstract
{
    public $id_question;
    public $id_user;
    public $votes;
    public $answer;
    public $date;
    public $flag;
    public $ativo;

    /**
     * Get the full name of the User
     *
     * Demonstrates how other functions can be
     * added to the DomainObject
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
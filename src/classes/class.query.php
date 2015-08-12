<?php
/**
 * Created by PhpStorm.
 * User: dritzel
 * Date: 10/08/2015
 * Time: 15:46
 *
 * Interface de acesso ao banco
 */
include_once('../classes/mysql.php');

class classQuery {

    public $sqlSortColumns;		//Lista de colunas para ordenar
    public $sqlSortAscending;	//Ordem das colunas
    public $sqlLimit;			//Numero de linhas para busca
    public $sqlOperator; 		//Operador diferenciado para o SQL nos wheres
    public $strTableName;       //Nome da tabela

    protected $db;

    public function __construct(){
        $this->db = new MySQL();
    }

    public function __destruct(){
        $this->db->Close();
    }

    /**
     * Deleta o registro do banco
     *
     * @param $id
     * @return bool $boolDeleted
     */
    public function Delete($id){
        $boolDeleted = true;
        $strSqlDelete = $this->db->BuildSQLDelete($this->strTableName,$id);
        if(!$this->db->Query($strSqlDelete)){
            $boolDeleted = false;
        }
        return $boolDeleted;
    }


    /**
     * Insere um registro na base
     * @param $arValues
     * @return int
     */
    public function Insert($arValues){

        $strSqlInsert = $this->db->BuildSQLInsert($this->strTableName,$arValues);
        $arCols = $this->db->GetColumnNames($this->strTableName);
        $arVals = explode(',',$this->whereBasicsVal);

        if(!$this->db->Query($strSqlInsert)){
            $strInsertID = 0;
        } else {
            $strInsertID = $this->db->GetLastInsertID();
        }

        return $strInsertID;
    }

    /*
     * Busca dados do banco via query
     *
     *
     *
     * @param $arWhere array
     * @return Records array
     */
    public function SelectQueryInArray($arWhere){

        $arConsult = array (''=>'');
        $arCols = $this->db->GetColumnNames($this->strTableName);

        $sqlQuery = $this->db->BuildSQLSelect($this->strTableName,
            $arWhere,
            $arCols,
            $this->sqlSortColumns,
            $this->sqlSortAscending,
            $this->sqlLimit);

        if($this->db->Query($sqlQuery))
            $arConsult = $this->db->RecordsArray();

        return $arConsult;
    }

} 
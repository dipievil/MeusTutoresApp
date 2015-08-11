<?php
/**
 * Created by PhpStorm.
 * User: dritzel
 * Date: 10/08/2015
 * Time: 15:46
 *
 * Interface de acesso as classes do banco
 */


class classQuery {

    public $sqlSortColumns;		//Lista de colunas para ordenar
    public $sqlSortAscending;	//Ordem das colunas
    public $sqlLimit;			//Numero de linhas para busca
    public $sqlOperator; 		//Operador diferenciado para o SQL nos wheres

    public function __construct(){
    }

    public function Insert($arValues,$tableName){
        $db = new MySQL();

        $strSqlInsert = $db->BuildSQLInsert($this->tableName,$arValues);

        $arCols = $db->GetColumnNames($tableName);

        $arVals = explode(',',$this->whereBasicsVal);

        if(!$db->Query($strSqlInsert)){
            $strInsertID = 0;
        } else {
            $strInsertID = $db->GetLastInsertID();
        }

        return $strInsertID;
    }

    /*
     * Busca dados do banco via query
     *
     */
    /**
     * @param $arWhere array
     * @return Records array
     */
    public function SelectQueryInArray($arWhere,$tableName){

        $db = new MySQL();

        $arCols = $db->GetColumnNames($tableName);

        $sqlQuery = $db->BuildSQLSelect($tableName,
            $arWhere,
            $arCols,
            $this->sqlSortColumns,
            $this->sqlSortAscending,
            $this->sqlLimit);

        $db->Query($sqlQuery);

        return $db->RecordsArray();
    }

} 
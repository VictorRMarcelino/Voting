<?php

namespace database;

/**
 * Conexão
 * @package database
 * @author Victor Ramos <httpsvictorramos@gmail.com>
 * @since 05/11/2025
 */
class Conexao {

    private $inTransaction;

    /**
     * Get the value of inTransaction
     * @return boolean
     */ 
    public function getInTransaction(){
        return $this->inTransaction;
    }

    /**
     * Set the value of inTransaction
     * @param boolean $inTransaction
     */ 
    public function setInTransaction($inTransaction){
        $this->inTransaction = $inTransaction;
    }

    public static function getInstance() {
        static $oConexao = null;

        if (!isset($oConexao)) {
            $oConexao = new Conexao();
        }

        return $oConexao;
    }

    /**
     * Retorna a conexão com o banco
     */
    public static function getConnection() {
        static $conn = null;

        if (!isset($conn)) {
            $connectionString = "host=localhost port=5432 dbname=voting user=postgres password=1309";
            $connection = pg_connect($connectionString);
        }

        return $connection;
    }
}
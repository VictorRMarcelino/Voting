<?php

namespace database;

class Query {

    /**
     * Executa uma query no banco de dados
     * @param string $sql
     */
    public static function query(string $sql) {
        $connection = Conexao::getConnection();
        return pg_query($connection, $sql);
    }

    /**
     * Executa um insert com uma query prepared
     * @param string $tabela
     * @param array $colunas
     * @param array $valores
     */
    public static function insertQueryPrepared($tabela, array $colunas, array $valores) {
        $connection = Conexao::getConnection();
        $params = [];

        foreach ($colunas as $index => $coluna) {
            $params[] = '$' . ($index + 1);
        }

        $result = pg_query_params($connection, 'INSERT INTO ' . $tabela . ' (' . implode(', ', $colunas) . ') VALUES (' . implode(', ', $params) . ')', $valores);
    
        if (!$result) {
            throw new \Exception(pg_last_error($connection));
        }
    }

    /**
     * Executa um insert com uma query prepared
     * @param string $tabela
     * @param array $colunas
     * @param array $valores
     * @param string $colunaRetorno
     */
    public static function insertQueryPreparedReturningColumn($tabela, array $colunas, array $valores, $colunaRetorno = '') {
        $connection = Conexao::getConnection();
        $params = [];

        foreach ($colunas as $index => $coluna) {
            $params[] = '$' . ($index + 1);
        }

        $result = pg_query_params($connection, 'INSERT INTO ' . $tabela . ' (' . implode(', ', $colunas) . ') VALUES (' . implode(', ', $params) . ') RETURNING ' . $colunaRetorno, $valores);
        
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['id'];
        } else {
            throw new \Exception(pg_last_error($connection));
        }
    }

    /** Inicia uma nova transação no banco */
    public static function begin() {
        if (!Conexao::getInstance()->getInTransaction()) {
            self::query('begin');
            Conexao::getInstance()->setInTransaction(true);
        }
    }

    /** Executa um commit no banco */
    public static function commit() {
        if (Conexao::getInstance()->getInTransaction()) { 
            self::query('commit');
            Conexao::getInstance()->setInTransaction(false);
        }
    }

    /** Executa um rollback no banco */
    public static function rollback() {
        if (Conexao::getInstance()->getInTransaction()) { 
            self::query('rollback');
            Conexao::getInstance()->setInTransaction(false);
        }
    }
}
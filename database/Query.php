<?php

namespace database;

class Query {

    /**
     * Executa uma query no banco de dados
     * @param string $sql
     */
    public static function query(string $sql) {
        $connection = Conexao::getConnection();
        $result = pg_query($connection, $sql);
        $erro = pg_last_error($connection);

        if ($erro != '') {
            throw new \Exception($erro);
        }

        return $result;
    }

    /**
     * Executa um select no banco de dados
     * @param string $tabela
     * @param array $colunas
     * @param array $condicoes
     * @param array $valores
     * @param array $orderBy
     * @throws \Exception
     */
    public static function select(string $tabela, array $colunas, array $condicoes = [], array $valores = [], array $orderBy = []) {
        $connection = Conexao::getConnection();

        $sql = 'SELECT ' . implode(', ', $colunas) . ' FROM ' . $tabela;

        if (count($condicoes) > 0) {
            $sql .= ' WHERE ' . implode(' AND ', $condicoes);
        }
        
        if (count($orderBy) > 0) {
            $sql .= ' ORDER BY ' . implode(' AND ', $orderBy);
        }

        $result = pg_query_params($connection, $sql, $valores);
    
        if (!$result) {
            throw new \Exception(pg_last_error($connection));
        }

        return $result;
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

    /**
     * Executa um update no banco de dados
     * @param string $tabela
     * @param array $colunasUpdate
     * @param array $condicoes
     */
    public static function update(string $tabela, array $colunasUpdate, array $condicoes) {
        $sql = 'UPDATE ' . $tabela . ' SET ' . implode(', ', $colunasUpdate) . ' WHERE ' . implode(' AND ', $condicoes) . '';
        self::query($sql);
    }

    /**
     * Executa um delete no banco de dados
     * @param string $tabela
     * @param array $condicoes
     * @return void
     */
    public static function delete(string $tabela, array $condicoes) {
        $sql = 'DELETE FROM ' . $tabela . ' WHERE ' . implode(' AND ', $condicoes) . '';
        self::query($sql);
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
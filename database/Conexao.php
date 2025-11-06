<?php

namespace database;

/**
 * Conexão
 * @package database
 * @author Victor Ramos <httpsvictorramos@gmail.com>
 * @since 05/11/2025
 */
class Conexao {

    /**
     * Retorna a conexão com o banco
     */
    private static function getConnection() {
        static $conn = null;

        if (!isset($conn)) {
            $connectionString = "host=localhost port=5432 dbname=voting user=postgres password=1309";
            $connection = pg_connect($connectionString);
        }

        return $connection;
    }

    public static function query(string $sql) {
        $connection = self::getConnection();
        return pg_query($connection, $sql);
    }

    public static function insertQueryPrepared($tabela, $colunas, $valores) {
        $connection = self::getConnection();
        $params = [];

        foreach ($colunas as $index => $coluna) {
            $params[] = '$' . ($index + 1);
        }

        return pg_query_params($connection, 'INSERT INTO ' . $tabela . ' (' . implode(', ', $colunas) . ') VALUES (' . implode(', ', $params) . ')', $valores);
    }
}
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
    public static function getConnection() {
        static $conn = null;

        if (!isset($conn)) {
            $connectionString = "host=localhost port=5432 dbname=voting user=postgres password=1309";
            $connection = pg_connect($connectionString);
        }

        return $connection;
    }
}
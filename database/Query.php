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
    public static function insertQueryPrepared($tabela, array $colunas, array $valores, $colunaRetorno = '') {
        $connection = Conexao::getConnection();
        $params = [];

        foreach ($colunas as $index => $coluna) {
            $params[] = '$' . ($index + 1);
        }

        $result = pg_query_params($connection, 'INSERT INTO ' . $tabela . ' (' . implode(', ', $colunas) . ') VALUES (' . implode(', ', $params) . ') ' . $colunaRetorno, $valores);
        
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['id'];
        }
    }
}
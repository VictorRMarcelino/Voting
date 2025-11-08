<?php

namespace src\core;

/**
 * Sessão
 * @package src
 * @subpackage core
 * @author Victor Ramos <httpsvictorramos@gmail.com>
 * @since 08/11/2025
 */
class Sessao {

    /** Inicia ou continua com uma sessão */
    public static function iniciaSessao() {
        session_start();
    }

    /**
     * Verifica se há uma sessão ativa
     * @return int
     */
    public static function isUsuarioLogado() {
        return $_SESSION['logado'] == true;
    }

    public static function setUsuarioLogado() {
        $_SESSION['logado'] = true;
    }
}
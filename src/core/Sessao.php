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
    public static function isSessaoAtiva() {
        return session_status() == PHP_SESSION_ACTIVE;
    }
}
<?php

namespace routes;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Contracts\CallableDispatcher;
use Illuminate\Routing\Router as Route;
use Illuminate\Routing\CallableDispatcher as BaseDispatcher;

/**
 * Router
 * @package routes
 * @author Victor Ramos <httpsvictorramos@gmail.com>
 * @since 05/11/2025
 */
class Router {

    /**
     * Retorna uma instância estática do Roteador da aplicação
     * @return Route
     */
    public static function getInstance() {
        static $router = null;

        if (!isset($router)) {
            $container = new Container();

            // Registra o binding obrigatório do dispatcher
            $container->singleton(CallableDispatcher::class, function ($app) {
                return new BaseDispatcher($app);
            });

            $events = new Dispatcher($container);
            $router = new Route($events, $container);
        }

        return $router;
    }
}
<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Contracts\CallableDispatcher;
use Illuminate\Routing\Router;
use Illuminate\Routing\CallableDispatcher as BaseDispatcher;

$container = new Container;
$events = new Dispatcher($container);
$router = new Router($events, $container);

// Registra o binding obrigatório do dispatcher
$container->singleton(CallableDispatcher::class, function ($app) {
    return new BaseDispatcher($app);
});

$router->get('/avaliacao', function () {
    $pagina = file_get_contents('../views/avaliacao.html');
    echo $pagina;
});

$router->post('/avaliacao/salvar', function () {
    $pagina = file_get_contents('../views/avaliacao.html');
    echo $pagina;
});

$request = Request::capture();
$response = $router->dispatch($request);
$response->send();

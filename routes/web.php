<?php

use routes\Router;

$router = Router::getInstance();
$router->get('/avaliacao', '\src\controller\ControllerAvaliacao@getTela');
$router->get('/avaliacao/perguntas', '\src\controller\ControllerAvaliacao@getPerguntas');
$router->post('/avaliacao/salvar', '\src\controller\ControllerAvaliacao@salvarAvaliacao');
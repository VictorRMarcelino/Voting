<?php

use routes\Router;

$router = Router::getInstance();
$router->get('/avaliacao', '\src\controller\ControllerAvaliacao@getView');
$router->get('/avaliacao/perguntas', '\src\controller\ControllerAvaliacao@getPerguntas');
$router->post('/avaliacao/salvar', '\src\controller\ControllerAvaliacao@salvarAvaliacao');
$router->get('/painelAdministrador', '\src\controller\ControllerPainelAdministrador@getView');
$router->get('/painelAdministrador/setores', '\src\controller\ControllerPainelAdministrador@getSetores');
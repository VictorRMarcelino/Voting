<?php

use routes\Router;

$router = Router::getInstance();
$router->get('/avaliacao', '\src\controller\ControllerAvaliacao@getView');
$router->get('/avaliacao/setores', '\src\controller\ControllerAvaliacao@getSetores');
$router->get('/avaliacao/perguntas', '\src\controller\ControllerAvaliacao@getPerguntas');
$router->post('/avaliacao/salvar', '\src\controller\ControllerAvaliacao@salvarAvaliacao');
$router->get('/painelAdministrador', '\src\controller\ControllerPainelAdministrador@getView');
$router->get('/painelAdministrador/setores', '\src\controller\ControllerPainelAdministrador@getSetores');
$router->get('/painelAdministrador/perguntas', '\src\controller\ControllerPainelAdministrador@getPerguntasByIdSetor');
$router->get('/login/verificar', '\src\controller\ControllerLogin@login');
$router->post('/painelAdministrador/setor/incluir', '\src\controller\ControllerPainelAdministrador@inserirSetor');
$router->put('/painelAdministrador/setor/alterar', '\src\controller\ControllerPainelAdministrador@alterarSetor');
$router->delete('/painelAdministrador/setor/deletar', '\src\controller\ControllerPainelAdministrador@excluirSetor');
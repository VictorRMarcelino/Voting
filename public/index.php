<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../routes/web.php';

use database\Query;
use Illuminate\Http\Request;
use routes\Router;
use src\core\Sessao;

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ERROR | E_PARSE);
Sessao::iniciaSessao();

try {
    $request = Request::capture();
    $response = Router::getInstance()->dispatch($request);
    $response->send();
} catch (Throwable $th) {
    Query::rollback();
    echo json_encode(['error' => strip_tags($th->getMessage())]);
} catch (Exception $ex) {
    Query::rollback();
    echo json_encode(['error' => strip_tags($ex->getMessage())]);
}

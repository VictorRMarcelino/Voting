<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../routes/web.php';

use Illuminate\Http\Request;
use routes\Router;

$request = Request::capture();
$response = Router::getInstance()->dispatch($request);
$response->send();

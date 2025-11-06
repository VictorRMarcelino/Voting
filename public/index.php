<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../routes/web.php';

use Illuminate\Http\Request;

$request = Request::capture();
$response = $router->dispatch($request);
$response->send();

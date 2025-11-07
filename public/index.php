<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../routes/web.php';

use Illuminate\Http\Request;
use routes\Router;

try {
    $request = Request::capture();
    $response = Router::getInstance()->dispatch($request);
    $response->send();
} catch (Throwable $th) {

} catch (Exception $ex) {

}

<?php

require __DIR__ . "/vendor/autoload.php";

use \Source\Http\Router;

$router = new Router(BASE_URL);

include __DIR__ . '/routes/api.php';

$router->run()->sendResponse();

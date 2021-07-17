<?php

use \Source\Controllers\Api\ApiController;
use \Source\Http\Response;

$router->get('/', [
    function ($request) {
        return new Response(200, ApiController::getDetails($request), 'json');
    },
]);

include __DIR__ . '/user.php';

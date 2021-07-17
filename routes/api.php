<?php

use \Source\Controllers\Api\ApiController;
use \Source\Http\Response;

$router->get('/', [
    function ($request) {
        return new Response(200, ApiController::getDetails($request), 'json');
    },
]);

include __DIR__ . '/user.php';
include __DIR__ . '/address.php';
include __DIR__ . '/city.php';
include __DIR__ . '/state.php';

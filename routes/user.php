<?php

use \Source\Controllers\Api\UserController;
use \Source\Http\JsonResponse;
use \Source\Http\Response;

$router->get('/user/{userId}', [
    function ($userId) {

        $returnUser = UserController::getUserById($userId);
        $jsonReturn = new JsonResponse($returnUser[0], $returnUser[1], $returnUser[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

$router->post('/user', [
    function ($request) {

        $requestVariables = $request->getPostVars();

        $returnUser = UserController::insert($requestVariables);
        $jsonReturn = new JsonResponse($returnUser[0], $returnUser[1], $returnUser[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

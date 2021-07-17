<?php

use \Source\Controllers\Api\UserController;
use \Source\Http\JsonResponse;
use \Source\Http\Response;

/**
 * busca usuario por id
 */
$router->get('/user/{userId}', [
    function ($userId) {

        $returnUser = UserController::getUserById($userId);
        $jsonReturn = new JsonResponse($returnUser[0], $returnUser[1], $returnUser[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * inserção de usuario
 */
$router->post('/user', [
    function ($request) {

        $requestVariables = $request->getPostVars();

        $returnUser = UserController::insert($requestVariables);
        $jsonReturn = new JsonResponse($returnUser[0], $returnUser[1], $returnUser[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * alteração de usuario
 */
$router->put('/user', [
    function ($request) {

        $requestVariables = $request->getPostVars();

        $returnUser = UserController::update($requestVariables);
        $jsonReturn = new JsonResponse($returnUser[0], $returnUser[1], $returnUser[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * deletar usuario por id
 */
$router->delete('/user/{userId}', [
    function ($userId) {

        $returnUser = UserController::deleteById($userId);
        $jsonReturn = new JsonResponse($returnUser[0], $returnUser[1], $returnUser[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

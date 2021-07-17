<?php

use \Source\Controllers\Api\StateController;
use \Source\Http\JsonResponse;
use \Source\Http\Response;

/**
 * busca todos estados
 */
$router->get('/state', [
    function ($stateId) {

        $returnAddress = StateController::getAllState();
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * busca estado pelo id
 */
$router->get('/state/id/{stateId}', [
    function ($stateId) {

        $returnAddress = StateController::getStateById($stateId);
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * retorna totalização de usuarios por estado
 */
$router->get('/state/users', [
    function () {

        $returnAddress = StateController::getUsersByState();
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * retorna totalização de usuarios por estado filtrando id
 */
$router->get('/state/users/{stateId}', [
    function ($stateId) {

        $returnAddress = StateController::getUsersByStateId($stateId);
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

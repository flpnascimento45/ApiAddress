<?php

use \Source\Controllers\Api\CityController;
use \Source\Http\JsonResponse;
use \Source\Http\Response;

/**
 * busca todas cidades
 */
$router->get('/city', [
    function ($stateId) {

        $returnAddress = CityController::getAllCity();
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * busca endereço pela cidade
 */
$router->get('/city/state/{stateId}', [
    function ($stateId) {

        $returnAddress = CityController::getCityByState($stateId);
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * busca cidade pelo id
 */
$router->get('/city/id/{cityId}', [
    function ($cityId) {

        $returnAddress = CityController::getCityById($cityId);
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

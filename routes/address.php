<?php

use \Source\Controllers\Api\AddressController;
use \Source\Http\JsonResponse;
use \Source\Http\Response;

/**
 * busca todos endereços
 */
$router->get('/address', [
    function () {

        $returnAddress = AddressController::getAllAddress();
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * busca endereço pela cidade
 */
$router->get('/address/city/{cityId}', [
    function ($cityId) {

        $returnAddress = AddressController::getAddressByCity($cityId);
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

/**
 * busca endereço pelo id
 */
$router->get('/address/id/{addressId}', [
    function ($addressId) {

        $returnAddress = AddressController::getAddressById($addressId);
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

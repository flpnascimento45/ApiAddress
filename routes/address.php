<?php

use \Source\Controllers\Api\AddressController;
use \Source\Http\JsonResponse;
use \Source\Http\Response;

/**
 * busca usuario por id
 */
$router->get('/address/city/{cityId}', [
    function ($cityId) {

        $returnAddress = AddressController::getAddressByCity($cityId);
        $jsonReturn = new JsonResponse($returnAddress[0], $returnAddress[1], $returnAddress[2]);

        return new Response(200, $jsonReturn, 'json');

    },
]);

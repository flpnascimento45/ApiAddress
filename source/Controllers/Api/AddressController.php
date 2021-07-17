<?php

namespace Source\Controllers\Api;

use \Exception;
use \Source\Models\Address;
use \Source\Models\City;

class AddressController
{

    /**
     * metodo para buscar usuario por id
     * @param integer $userId
     */
    public static function getAddressByCity($cityId)
    {
        try {

            if (!ctype_digit($cityId)) {
                throw new Exception('Falha ao recuperar id da cidade!');
            }

            $address = new Address(0);
            $address->setCity(new City($cityId));

            $addressReturn = $address->getAddressByCity();

            return array('success', $addressReturn, '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

}

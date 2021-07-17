<?php

namespace Source\Controllers\Api;

use \Exception;
use \Source\Models\Address;
use \Source\Models\City;

class AddressController
{

    /**
     * metodo para buscar endereço pela cidade
     * @param integer $cityId
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

    /**
     * metodo para buscar endereço pelo id
     * @param integer $addressId
     */
    public static function getAddressById($addressId)
    {
        try {

            if (!ctype_digit($addressId)) {
                throw new Exception('Falha ao recuperar id do endereço!');
            }

            $address = new Address($addressId);
            $address->getAddressById();

            return array('success', $address->returnArray(), '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

}

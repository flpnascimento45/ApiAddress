<?php

namespace Source\Controllers\Api;

use \Exception;
use \Source\Models\City;
use \Source\Models\CityReport;
use \Source\Models\State;

class CityController
{

    /**
     * metodo para buscar cidades pelo estado
     * @param integer $stateId
     */
    public static function getCityByState($stateId)
    {
        try {

            if (!ctype_digit($stateId)) {
                throw new Exception('Falha ao recuperar id do estado!');
            }

            $city = new City(0);
            $city->setState(new State($stateId));

            $cityReturn = $city->getCityByState();

            return array('success', $cityReturn, '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

    /**
     * metodo para buscar cidade pelo id
     * @param integer $cityId
     */
    public static function getCityById($cityId)
    {
        try {

            if (!ctype_digit($cityId)) {
                throw new Exception('Falha ao recuperar id do endereço!');
            }

            $city = new City($cityId);
            $city->getCityById();

            return array('success', $city->returnArray(), '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

    /**
     * metodo para buscar todas cidades
     */
    public static function getAllCity()
    {
        try {

            $returnCity = City::getAllCity();

            return array('success', $returnCity, '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

    /**
     * metodo para retornar quantidade de usuarios por cidade
     */
    public function getUsersByCity()
    {
        try {

            $cityReport = new CityReport();
            $returnReport = $cityReport->getUsersByCity();

            return array('success', $returnReport, '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

    /**
     * metodo para retornar quantidade de usuarios por cidade
     */
    public function getUsersByCityId($cityId)
    {
        try {

            $cityReport = new CityReport($cityId);
            $cityReport->getUsersByCity();

            return array('success', $cityReport->returnArray(), '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

}

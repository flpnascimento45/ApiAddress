<?php

namespace Source\Controllers\Api;

use \Exception;
use \Source\Models\State;
use \Source\Models\StateReport;

class StateController
{

    /**
     * metodo para buscar estado pelo id
     * @param integer $stateId
     */
    public static function getStateById($stateId)
    {
        try {

            if (!ctype_digit($stateId)) {
                throw new Exception('Falha ao recuperar id do endereço!');
            }

            $state = new State($stateId);
            $state->getStateById();

            return array('success', $state->returnArray(), '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

    /**
     * metodo para buscar todos estados
     */
    public static function getAllState()
    {
        try {

            $returnState = State::getAllState();

            return array('success', $returnState, '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

    /**
     * metodo para retornar quantidade de usuarios por estado
     */
    public function getUsersByState()
    {
        try {

            $stateReport = new StateReport();
            $returnReport = $stateReport->getUsersByState();

            return array('success', $returnReport, '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

    /**
     * metodo para retornar quantidade de usuarios por estado
     */
    public function getUsersByStateId($stateId)
    {
        try {

            $stateReport = new StateReport($stateId);
            $stateReport->getUsersByState();

            return array('success', $stateReport->returnArray(), '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

}

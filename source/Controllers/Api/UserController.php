<?php

namespace Source\Controllers\Api;

use \Exception;
use \Source\Models\User;

class UserController
{

    public static function getUserById($userId)
    {
        try {

            if (!ctype_digit($userId)) {
                throw new Exception('Falha ao recuperar id do usuario!');
            }

            $user = new User($userId);
            $user->getUserById();

            return array('success', $user->returnArray(), '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

    /**
     * metodo para validar dados de entrada na inserção e alteração
     * @param array $requestVariables
     */
    private static function validationUser($requestVariables, $type)
    {

        try {

            foreach (array('name', 'login', 'pass', 'address_id') as $field) {

                if (!isset($requestVariables[$field])) {
                    throw new Exception('Campo ' . $field . ' não localizado');
                }

                if (!strlen($requestVariables[$field]) > 0) {
                    throw new Exception('Campo ' . $field . ' não preenchido');
                }

            }

            if ($type != 'insert') {

                if (!isset($requestVariables['id'])) {
                    throw new Exception('Campo id não localizado');
                }

                if (!ctype_digit($requestVariables['id'])) {
                    throw new Exception('Campo id invalido!');
                }

            }

            return array('success');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }

    }

    public static function insert($requestVariables)
    {

        $returnValidation = self::validationUser($requestVariables, 'insert');

        if ($returnValidation[0] === 'error') {
            return $returnValidation;
        }

        return array('success', $requestVariables, '');

    }

}

<?php

namespace Source\Controllers\Api;

use \Exception;
use \Source\Models\Address;
use \Source\Models\User;

class UserController
{

    /**
     * metodo para buscar usuario por id
     * @param integer $userId
     */
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
    private static function validationUser($requestVariables)
    {

        foreach (array('name', 'login', 'pass', 'address_id') as $field) {

            if (!isset($requestVariables[$field])) {
                throw new Exception('Campo ' . $field . ' não localizado');
            }

            if (!strlen($requestVariables[$field]) > 0) {
                throw new Exception('Campo ' . $field . ' não preenchido');
            }

        }

    }

    /**
     * metodo para inserir usuario
     * @param array $requestVariables
     */
    public static function insert($requestVariables)
    {

        try {

            self::validationUser($requestVariables);

            $user = new User(0, $requestVariables['name'], $requestVariables['login'], $requestVariables['pass']);
            $user->setAddress(new Address($requestVariables['address_id']));
            $user->insert();
            $user->setPass('');

            return array('success', $user->returnArray(), '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }

    }

    /**
     * metodo para inserir usuario
     * @param array $requestVariables
     */
    public static function update($requestVariables, $userId)
    {

        try {

            self::validationUser($requestVariables);

            if (!isset($userId)) {
                throw new Exception('Campo id não localizado');
            }

            if (!ctype_digit($userId)) {
                throw new Exception('Campo id invalido!');
            }

            $user = new User($userId, $requestVariables['name'], $requestVariables['login'], $requestVariables['pass']);
            $user->setAddress(new Address($requestVariables['address_id']));
            $user->update();
            $user->setPass('');

            return array('success', $user->returnArray(), '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }

    }

    /**
     * metodo para deletar usuario por id
     * @param integer $userId
     */
    public static function deleteById($userId)
    {
        try {

            if (!ctype_digit($userId)) {
                throw new Exception('Falha ao recuperar id do usuario!');
            }

            $user = new User($userId);
            $user->deleteById();

            return array('success', 'Excluido com êxito', '');

        } catch (Exception $e) {
            return array('error', '', $e->getMessage());
        }
    }

}

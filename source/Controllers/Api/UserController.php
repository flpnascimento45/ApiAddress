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
}

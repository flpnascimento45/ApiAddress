<?php

namespace Source\Helpers;

class Environment
{

    /**
     * Carrega as variaveis de ambiente
     * @param  string $dir Caminho absoluto da pasta onde encontra-se o arquivo .env
     */
    public static function load($dir)
    {
        // verifica se arquivo existe
        if (!file_exists($dir . '/.env')) {
            return false;
        }

        // defini as variaveis
        $lines = file($dir . '/.env');

        foreach ($lines as $line) {
            putenv(trim($line));
        }
    }

}

<?php
use \Source\Helpers\Environment;

// carregar variaveis do arquivo .env
Environment::load(dirname(__DIR__, 1));

define('BASE_URL', getenv('BASE_URL'));
define('DBHOST', getenv('DBHOST'));
define('DBNAME', getenv('DBNAME'));
define('DBUSER', getenv('DBUSER'));
define('DBPASSWORD', getenv('DBPASSWORD'));

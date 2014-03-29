<?php

use Monolog\Logger;

// $BASE_PATH is set in htdocs/index.php

$BASE_APP_SETTINGS = [
    "mode" => "base",
    'view' => new \Slim\Views\Twig(),
    "debug" => false,
    "templates.path" => "{$BASE_PATH}/templates",
    "cookies.encrypt" => true,
    "cookies.lifetime" => "2 years",
    "cookies.path" => "/",
    "cookies.secure" => true,
    "cookies.httponly" => true,
    "cookies.secret_key" => "FIX_ME",
    "cookies.cipher" => MCRYPT_RIJNDAEL_256,
    "cookies.cipher_mode" => MCRYPT_MODE_CBC,
    "cookies.name" => "app_session",
    "http.version" => "1.1",

    "resty.debug" => false,

    "monolog.level" => Logger::ERROR,

    "csrf.secret" => "FIX_ME",

    "memcached.host" => "localhost",
    "memcached.port" => 11211,
    "memcached.default.expiration" => "+24 hours",

    "mysql_host" => "localhost",
    "mysql_dbname" => "greaterlala.in",
    "mysql_username" => "FIX_ME",
    "mysql_password" => "FIX_ME",
];

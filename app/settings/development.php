<?php

namespace GLLApp\settings;

use Monolog\Logger;

// $BASE_PATH is set in htdocs/index.php
include "{$BASE_PATH}/app/settings/base.php";

$APP_SETTINGS = array_merge($BASE_APP_SETTINGS, [
    "mode" => "development",
    "debug" => true,
    "cookies.encrypt" => false, // don't encrypt them in dev env
    "cookies.secure" => false, // cookies only over HTTPS if this is true
    "cookies.httponly" => false,
    "twig.debug" => true,
    "twig.cache_path" => "/tmp/twig_cache",

    "resty.debug" => false,

    "memcached.default.expriation" => "+30 seconds",

    "monolog.level" => Logger::DEBUG,
]);

// assigns these settings to the Fetcher class
Fetcher::$SETTINGS = $APP_SETTINGS;
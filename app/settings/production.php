<?php

namespace GLLApp\settings;

include "{$BASE_PATH}/app/settings/base.php";

$APP_SETTINGS = array_merge($BASE_APP_SETTINGS, [
    "mode" => "production",
    "debug" => false,
    "log.enabled" => false,
    "cookies.encrypt" => true,
    "cookies.secure" => true,
    "cookies.httponly" => true,
    "twig.debug" => false,
]);

// assigns these settings to the Fetcher class
Fetcher::$SETTINGS = $APP_SETTINGS;
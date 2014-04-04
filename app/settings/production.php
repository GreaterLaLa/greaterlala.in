<?php

namespace GLLApp\settings;

// $BASE_PATH is set in htdocs/index.php
include "{$BASE_PATH}/app/settings/base.php";

$APP_SETTINGS = array_merge($BASE_APP_SETTINGS, [
    "mode" => "production",
    "debug" => false,
    "log.enabled" => false,
    "cookies.encrypt" => true,
    "cookies.secure" => false, // cookies only over HTTPS if this is true
    "cookies.httponly" => true,
    "twig.debug" => false,
]);

// assigns these settings to the Fetcher class
Fetcher::$SETTINGS = $APP_SETTINGS;
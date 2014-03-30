<?php
$BASE_PATH = realpath(dirname(__FILE__) . '/..');

/**
 * We use the composer autoloader for everything
 */
require "{$BASE_PATH}/vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;

/**
 * $APP_SETTINGS is assigned inside the app-settings.php file
 */
include "{$BASE_PATH}/app/app-settings.php";
$app = new \GLLApp\Lib\App($APP_SETTINGS);

/**
 * set-up monolog in app singleton container
 */
$app->container->singleton('log', function () use ($app) {
    $log = new Logger('GLLApp');
    $log->pushHandler(new ErrorLogHandler(
        ErrorLogHandler::OPERATING_SYSTEM,
        $app->config('monolog.level')
    ));
    return $log;
});

/**
 * set Twig parser options
 */
$view = $app->view();
$view->parserOptions = array(
    'debug' => $app->config('twig.debug'),
    'cache' => $app->config('twig.cache_path'),
);
/**
 * add Twig parser extensions for Slim
 */
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
    new Twig_Extension_Debug()
);

/**
 * Add JSON auto-decode middleware. This decodes the request body if
 * content-type is application/json and assigns it to $app->request->json
 */
$app->add(new \GLLApp\Middleware\DecodeJson());

/**
 * add encrypted cookie session middleware
 * Note that the SessionCookie MW is added LAST so it loads BEFORE any
 * middleware that interacts with the session!
 */
$app->add(new \Slim\Middleware\SessionCookie([
    "encrypt" => $app->config("cookies.encrypt"),
    "expires" => $app->config("cookies.lifetime"),
    "path" => $app->config("cookies.path"),
    "secure" => $app->config("cookies.secure"),
    "httponly" => $app->config("cookies.httponly"),
    "secret_key" => $app->config("cookies.secret_key"),
    "cipher" => $app->config("cookies.cipher"),
    "cipher_mode" => $app->config("cookies.cipher_mode"),
    "name" => $app->config("cookies.name"),
]));

/**
 * include route files
 */
include "{$BASE_PATH}/app/routes/index.php";
include "{$BASE_PATH}/app/routes/api.php";

$app->run();

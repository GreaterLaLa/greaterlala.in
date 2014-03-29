<?php
use \GLLApp\Lib\GeocodioApi;
use \GLLApp\Lib\GovtrackApi;
use \GLLApp\Lib\Cache;


$app->error(function (\Exception $e) use ($app) {
    $app->log->addError("Exception thrown: " . $e->getMessage());
    $app->render('pages/error.html', 500);
});

$app->get('/', function () use ($app) {
    $app->render('pages/index.html');
});


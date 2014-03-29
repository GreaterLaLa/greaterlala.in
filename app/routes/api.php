<?php

$app->group('api', function () use ($app) {

    $app->get('/', function () use ($app) {
        echo "hi!";
    });

});
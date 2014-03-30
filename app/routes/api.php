<?php

use \Model as ParisModel;

$app->group('/api', function () use ($app) {

    $app->group('/suggestions', function () use ($app) {

        $app->get('/', function () use ($app) {
            $sugg = ParisModel::factory('\GLLApp\Model\Suggestion');
            $suggestions = $sugg->find_many();
            $resp_json = [];
            foreach ($suggestions as $suggestion) {
                $sugg_arr = $suggestion->as_array();
                $sugg_arr['type'] = $suggestion->type()->find_one()->as_array();
                $resp_json[] = $sugg_arr;
            }
            $app->setJSONBody($resp_json, 200);
        });
    });
});
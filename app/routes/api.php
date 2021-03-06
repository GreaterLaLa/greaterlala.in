<?php

use \Model as ParisModel;

$app->group('/api', function () use ($app) {

    $app->group('/suggestions', function () use ($app) {

        /**
         * make a model object
         * @var \GLLApp\Model\Suggestion
         */
        $sugg_m = ParisModel::factory('\GLLApp\Model\Suggestion');

        /**
         * get suggestions
         */
        $app->get('/', function () use ($app, $sugg_m) {
            // get limit
            if ($limit = (int)$app->request->get('limit')) {
                $sugg_m->limit($limit);
            }

            // get skip
            if ($skip = (int)$app->request->get('skip')) {
                $sugg_m->offset($skip);
            }

            // ?random=1
            $app->log->addDebug('GET', $app->request->get());
            if ($app->request->get('random') == '1') {
                $app->log->addDebug('GETTING RANDOM');
                $sugg_m->order_by_expr('RAND() DESC');
            } else {
                $sugg_m->order_by_desc('created_at');
            }

            $suggestions = $sugg_m->find_many();
            $resp_json = [];
            foreach ($suggestions as $suggestion) {
                $sugg_arr = $suggestion->as_array();
                $sugg_arr['type'] = $suggestion->type()->find_one()->as_array();
                $resp_json[] = $sugg_arr;
            }
            $app->setJSONBody($resp_json, 200);
        });


        /**
         * create a new suggestion
         *
         * There is no authorization on this. anyone can hit this and add stuff
         * to the DB with a simple POST call. It does do a CSRF check but you
         * could work around that if you're determined.
         */
        $app->post('/', function () use ($app, $sugg_m) {
            $sugg_text = $app->request->post('suggestion');
            if ($sugg_text && is_string($sugg_text)) {
                $sugg_text = trim($sugg_text);
            } else {
                $app->log->addError('problem adding suggestion');
                $app->log->addError('POST content', $app->request->post());
                $app->halt(400);
                return;
            }

            $suggestion = $sugg_m->create([
                'content' => $sugg_text,
                'type_id' => 1,
            ]);
            // doing this manually is painful
            $suggestion->set_expr('created_at', 'NOW()');
            $suggestion->set_expr('updated_at', 'NOW()');
            $suggestion->save();

            // now we re-read the value so we get the DB-calculated data
            $sugg_arr = $sugg_m->find_one($suggestion->id)->as_array();
            $sugg_arr['type'] = $suggestion->type()->find_one()->as_array();
            $resp_json = $sugg_arr;
            $app->setJSONBody($resp_json, 200);
        });

    });
});
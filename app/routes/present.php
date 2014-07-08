<?php
use \Model as ParisModel;

$app->group('/present', function () use ($app) {

    $app->get('/', function () use ($app) {
        $sugg = ParisModel::factory('\GLLApp\Model\Suggestion');
        $suggestions = $sugg
                            ->limit(4)
                            ->order_by_desc('created_at')
                            ->find_many();
        // the first shall be last
        $suggestions = array_reverse($suggestions);
        $app->render('pages/present/doors.html', ['suggestions' => $suggestions]);
    });

});

<?php
use \Model as ParisModel;

$app->error(function (\Exception $e) use ($app) {
    $app->log->addError("Exception thrown: " . $e->getMessage());
    $app->render('pages/error.html', 500);
});

$app->get('/', function () use ($app) {
    $sugg = ParisModel::factory('\GLLApp\Model\Suggestion');
    $suggestions = $sugg
                        ->limit(10)
                        ->order_by_desc('created_at')
                        ->find_many();
    // the first shall be last
    $suggestions = array_reverse($suggestions);
    $app->render('pages/index.html', ['suggestions' => $suggestions]);
});


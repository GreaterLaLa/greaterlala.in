#!/usr/bin/env php
<?php

/**
 * PSR2 can be annoying
 */
namespace GLLApp\scripts;

$BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
require "{$BASE_PATH}/vendor/autoload.php";
require "{$BASE_PATH}/app/settings/development.php";

use \GLLApp\Model\Generator;
use \GLLApp\settings\Fetcher as SettingsFetcher;

/**
 */
class MockGenerator extends Generator
{

    public $suggestions_types = ['text'];

    public function getRandom($list)
    {
        $idx = array_rand($list);
        return $list[$idx];
    }

    public function makeSuggestions($count = 50)
    {
        for ($i=0; $i < $count; $i++) {
            $this->makeTestSuggestion([
                'type_id' => 1,
            ]);
        }
    }

}


$mg = new MockGenerator(SettingsFetcher::$SETTINGS);
$rs = $mg->makeSuggestions();
var_dump($rs);

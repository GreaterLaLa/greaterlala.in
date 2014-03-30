<?php

$BASE_PATH = dirname(__FILE__) . '/../..';
require_once("{$BASE_PATH}/vendor/autoload.php");

use \FUnit as fu;
use \Resty\Resty;
use \Faker;


fu::setup(function () {
    $opts = [
        "supports_patch" => true,
        "json_to_array" => true,
    ];
    $r = new Resty($opts);
    $r->setBaseUrl('http://0.0.0.0:9909/api/');
    fu::fixture('r', $r);
    fu::fixture('fkr', Faker\Factory::create());
});

fu::teardown(function () {
    fu::reset_fixtures();
});

fu::test("test GET /suggestions", function () {

    $r = fu::fixture('r');

    $rs = $r->get('suggestions');
    fu::strict_equal(200, $rs['status']);
    fu::ok(is_array($rs['body']));
    fu::all_ok($rs['body'], function ($row) {
        return array_key_exists('id', $row);
    });
    fu::all_ok($rs['body'], function ($row) {
        return array_key_exists('type_id', $row);
    });
    fu::all_ok($rs['body'], function ($row) {
        return array_key_exists('type', $row);
    });
    fu::all_ok($rs['body'], function ($row) {
        return array_key_exists('id', $row['type']);
    });
    fu::all_ok($rs['body'], function ($row) {
        return array_key_exists('type', $row['type']);
    });
    fu::all_ok($rs['body'], function ($row) {
        return array_key_exists('content', $row);
    });
    fu::all_ok($rs['body'], function ($row) {
        return array_key_exists('created_at', $row);
    });
    fu::all_ok($rs['body'], function ($row) {
        return array_key_exists('updated_at', $row);
    });
});
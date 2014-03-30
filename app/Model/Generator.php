<?php

namespace GLLApp\Model;

use \GLLApp\Model\Suggestion;
use \GLLApp\Model\SuggestionType;
use \Model as ParisModel;

class Generator
{

    /**
     * @var Faker\Generator
     */
    public $fkr;

    /**
     * @var array  app settings
     */
    public $settings;

    public function __construct($settings)
    {
        $this->fkr = \Faker\Factory::create();
        $this->settings = $settings;

        \ORM::configure("mysql:host={$settings['mysql_host']};dbname={$settings['mysql_dbname']}");
        \ORM::configure("username", $settings['mysql_username']);
        \ORM::configure("password", $settings['mysql_password']);
    }

    public function makeTestSuggestion($s_data = [])
    {
        $defaults = [
            'type_id' => 1,
            'content' => $this->fkr->text(32),
        ];

        $s_data = array_merge($defaults, $s_data);
        $suggestion = ParisModel::factory('\GLLApp\Model\Suggestion')->create();
        $suggestion->type_id = $s_data['type_id'];
        $suggestion->content = $s_data['content'];
        $suggestion->set_expr('created_at', 'NOW()');
        $suggestion->set_expr('updated_at', 'NOW()');
        $suggestion->save();
    }

}

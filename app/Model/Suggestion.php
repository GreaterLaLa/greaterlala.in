<?php

namespace GLLApp\Model;
use \Model as ParisModel;

class Suggestion extends ParisModel
{
    public static $_table = 'suggestions';

    public function type() {
        return $this->belongs_to('GLLApp\Model\SuggestionType', 'type_id');
    }
}
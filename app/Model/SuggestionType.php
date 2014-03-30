<?php

namespace GLLApp\Model;
use \Model as ParisModel;

class SuggestionType extends ParisModel
{
    public static $_table = 'suggestions_types';

    public function suggestion() {
        return $this->has_many('\GLLApp\Model\SuggestionType', 'type_id');
    }
}
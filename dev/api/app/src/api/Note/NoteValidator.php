<?php namespace api\Note;

use Validator;

class NoteValidator {

    private $validationRules = array(
        'title' => 'required'
    );

    public function validate($data)
    {
        $validator = Validator::make($data, $this->validationRules);

        return $validator;
    }
}

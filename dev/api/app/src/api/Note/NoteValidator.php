<?php namespace api\Note;

use Validator;

class NoteValidator {

    private $validationRules = array(
        'title' => 'required',
        'description' => 'required'
    );

    public function validate($data)
    {
        $validator = Validator::make($data, $this->validationRules);

        return $validator;
    }

    public function update($data, $note_id)
    {
        // titles and descriptions can be empty when updating notes
        unset($this->validationRules['title']);
        unset($this->validationRules['description']);

        return $this;
    }
}

<?php namespace api\User;

use Validator;

class UserValidator {

    private $validationRules = array(
        'username' => 'required|unique:user',
        'password' => 'required',
        'confirm_password' => 'required|same:password'
    );

    public function validate($data)
    {
        $validator = Validator::make($data, $this->validationRules);

        return $validator;
    }

    public function update($data, $user_id)
    {
        // update validation rules to accept current username
        $this->validationRules['username'] = str_replace('unique:user', 'unique:user,username,' . $user_id, $this->validationRules['username']);

        return $this;
    }
}

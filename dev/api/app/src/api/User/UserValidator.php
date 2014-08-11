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

    public function update($requestData, $user_id)
    {
        // clear out the required username rules if the user isn't updating their username
        if (empty($requestData['username'])) {
            unset($this->validationRules['username']);
        } else {
            // allow user to pass in their own username when updating
            $this->validationRules['username'] = str_replace('unique:user', 'unique:user,username,' . $user_id, $this->validationRules['username']);
        }

        // clear out the required password rules if the user isn't resetting their password
        if (empty($requestData['password'])) {
            unset($this->validationRules['password']);
            unset($this->validationRules['confirm_password']);
        }

        return $this;
    }
}

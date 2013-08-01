<?php
require_once 'gump.class.php';

class ValidationModel {
	
	static function validate($app, $requestParams, $validationArr){
		// Check if valid JSON
		if($requestParams === NULL){
			$app->halt(500, 'Must be valid JSON');
		}

		// Check if valid
		$isValid = GUMP::is_valid($requestParams, $validationArr);

		if($isValid !== true){
			$app->halt(500, join(', ', $isValid));
			return false;
		}

		return array_intersect_key($requestParams, $validationArr);
	}

}
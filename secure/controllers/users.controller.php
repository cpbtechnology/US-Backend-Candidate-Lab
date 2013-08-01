<?php

require_once "validation.model.php";

$app->post('/users', function () use($app) {
	$requestParams = json_decode($app->request()->getBody(), true);

	$validParams = ValidationModel::validate($app, $requestParams, array(
	    'user_name' => 'required|valid_email|max_len,100',
	    'password' => 'required|max_len,100|min_len,6'
	));

	$validParams['password'] = crypt($validParams['password'], CRYPT_SALT);
	

	if(!ORM::for_table('users')->where('user_name', $validParams['user_name'])->find_one()){
		$notes = ORM::for_table('users')->create($validParams);
		$notes->save();
		echo json_encode(array('id'=>$notes->id()));
	}
	else{
		$app->halt(500, 'User Already Exists');
	}
    
	
});

?>
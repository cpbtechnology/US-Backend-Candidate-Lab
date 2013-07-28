<?php
require_once 'validation.model.php';


$app->post('/login', function () use($app) {
	$request = $app->request();
	$requestParams = json_decode($request->getBody(), true);

	$is_valid = ValidationModel::validate($app, $requestParams, array(
	    'user_name' => 'required|valid_email|max_len,100',
	    'password' => 'required|max_len,100|min_len,6'
	));

	if($is_valid === true){
			$user = ORM::for_table('users')
			->where('user_name', $userName)
			->where('password', $password)
			->find_one();
					
		if($user){
			$authToken = md5(rand());
			$app->config('cookies.userId', $user->id);
			$_SESSION['loggedIn'] = true;
			$_SESSION['authToken'] = $authToken;
			$_SESSION['userId'] = $user->id;
		}
		else{
			$app->response()->status(403);
		}
	}

});


$app->get('/logout', function() use($app){
	$sessionName = session_name();
	session_destroy();
});

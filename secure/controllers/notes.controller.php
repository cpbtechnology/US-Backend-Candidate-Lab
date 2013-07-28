<?php

$app->get('/notes', function () use($app) {
    $notes = ORM::for_table('notes')
    	->where('user_id', $_SESSION['userId'])
		->find_many(true);

	if(!empty($notes)){
		$app->halt(500, 'Does not exist or you do not have access.');
	}

	$app->response()->header('Content-Type', 'application/json');
    echo json_encode($notes);
	
});

$app->get('/notes/:id', function ($id) use($app) {
    $note = ORM::for_table('notes')
    	->where('id', $id)
    	->where('user_id', $_SESSION['userId'])
		->find_one();

	if(!$notes){
		$app->halt(500, 'Does not exist or you do not have access.');
	}

    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($note);
	
});

$app->post('/notes', function () use($app) {
	$requestParams = json_decode($app->request()->getBody(), true);

	$validParams = ValidationModel::validate($app, $requestParams, array(
	    'title' => 'required|valid_email|max_len,255',
	    'description' => 'required|max_len,10000'
	));

	$validParams['user_id'] = $_SESSION['userId'];
	
    $notes = ORM::for_table('notes')->create($validParams);
	$notes->save();
	
});

$app->put('/notes/:id', function ($id) use($app) {	
    $requestParams = json_decode($app->request()->getBody(), true);

	$validParams = ValidationModel::validate($app, $requestParams, array(
	    'title' => 'required|valid_email|max_len,255',
	    'description' => 'required|max_len,10000'
	));

	$validParams['user_id'] = $_SESSION['userId'];
	
    $notes = ORM::for_table('notes')
	    ->where('user_id', $_SESSION['userId'])
	    ->where('id', $id)
	    ->find_one();

	if(!$notes){
		$app->halt(500, 'Does not exist or you do not have access.');
	}

	$notes->set($validParams);
	$notes->save();
	
});

$app->delete('/notes/:id', function ($id) use($app) {	
    $note = ORM::for_table('notes')
    	->where('user_id', $_SESSION['userId'])
    	->where('id', $id)
    	->find_one();

    if(!$notes){
		$app->halt(500, 'Does not exist or you do not have access.');
	}

	$note->delete();
	
});

?>
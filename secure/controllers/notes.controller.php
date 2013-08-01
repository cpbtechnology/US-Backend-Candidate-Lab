<?php

require_once "validation.model.php";

$app->get('/notes', function () use($app) {
    $notes = ORM::for_table('notes')
    	->where('user_id', $app->userId)
		->find_many(true);

	if(empty($notes)){
		$app->halt(500, 'Does not exist or you do not have access.');
	}

	$decryptedNotes = array_map(function($note) use($app){
		$output = $note;
		$output['description'] = $app->cryptastic->decrypt($note['description'], $app->cryptKey);
		return $output;
	}, $notes);

	$app->response()->header('Content-Type', 'application/json');
    echo json_encode($decryptedNotes);
	
});

$app->get('/notes/:id', function ($id) use($app) {
    $note = ORM::for_table('notes')
    	->where('id', $id)
    	->where('user_id', $app->userId)
		->find_one();

	if(!$note){
		$app->halt(500, 'Does not exist or you do not have access.');
	}

	$note->description = $app->cryptastic->decrypt($note->description, $app->cryptKey);

    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($note->as_array());
	
});

$app->post('/notes', function () use($app) {
	$requestParams = json_decode($app->request()->getBody(), true);

	$validParams = ValidationModel::validate($app, $requestParams, array(
	    'title' => 'required|max_len,255',
	    'description' => 'required|max_len,10000'
	));

	// Setup Params
	$validParams['user_id'] = $app->userId;
	$validParams['description'] = $app->cryptastic->encrypt(
		$validParams['description'], 
		$app->cryptKey
	);

	
    $notes = ORM::for_table('notes')->create($validParams);
	$notes->save();

	echo json_encode(array('id'=>$notes->id()));
	
});

$app->put('/notes/:id', function ($id) use($app) {	
    $requestParams = json_decode($app->request()->getBody(), true);

	$validParams = ValidationModel::validate($app, $requestParams, array(
	    'title' => 'max_len,255',
	    'description' => 'max_len,10000'
	));

	// Setup Params
	$validParams['user_id'] = $app->userId;
	if(isset($validParams['description'])){
		$validParams['description'] = $app->cryptastic->encrypt(
			$validParams['description'], 
			$app->cryptKey
		);
	}
	
    $notes = ORM::for_table('notes')
	    ->where('user_id', $app->userId)
	    ->where('id', $id)
	    ->find_one();

	if(!$notes){
		$app->halt(500, 'Does not exist or you do not have access.');
	}

	$notes->set($validParams);
	$notes->save();
	echo json_encode(array('id'=>$id));
	
});

$app->delete('/notes/:id', function ($id) use($app) {	
    $note = ORM::for_table('notes')
    	->where('user_id', $app->userId)
    	->where('id', $id)
    	->find_one();

    if(!$note){
		$app->halt(500, 'Does not exist or you do not have access.');
	}

	$note->delete();

	$app->response()->header('Content-Type', 'application/json');
    echo json_encode(array('id'=>$id));

});

?>
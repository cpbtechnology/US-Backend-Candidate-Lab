<?php

$app->get('/notes', function () use($app) {
    $notes = ORM::for_table('notes')
	->find_many(true);

    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($notes);
	
});

$app->post('/notes', function () use($app) {
	
	$params = (array) json_decode($app->request()->getBody());
	
    $notes = ORM::for_table('notes')->create($params);
	$notes->save();
	
});

?>
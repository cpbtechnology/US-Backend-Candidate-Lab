<?php

$app->get('/posts', function () use($app) {
    $posts = ORM::for_table('posts')
	->find_many(true);

    $app->response()->header('Content-Type', 'application/json');
    echo json_encode($posts);
	
});

$app->post('/posts', function () use($app) {
	
	$params = (array) json_decode($app->request()->getBody());
	
    $post = ORM::for_table('posts')->create($params);
	$post->save();
	
});

?>
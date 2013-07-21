<?php
// turn debugging on
ini_set("display_errors",1);
error_reporting(E_ALL|E_STRICT);
date_default_timezone_set('MST');

// auto-include
set_include_path(get_include_path() . PATH_SEPARATOR . "../secure/libs");
set_include_path(get_include_path() . PATH_SEPARATOR . "../secure/models");
require_once 'Slim/Slim.php';
require_once 'idiorm.php';
\Slim\Slim::registerAutoloader();

// Setup DB
ORM::configure('mysql:host=localhost;dbname=testBlog');
ORM::configure('username', 'root');
ORM::configure('password', 'root');


$app = new \Slim\Slim(array(
	'templates.path' => '../secure/Views',
	'cookies.secret_key' => 'IkMHwZssJVe7XgdznBby'
));
$app->get('/', function () use($app) {
    $app->render("index.php");
});

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

$app->run();
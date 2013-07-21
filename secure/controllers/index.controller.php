
<?php

	$app->get('/', function () use($app) {
	    $app->render("index.php");
	});

?>
<?php
require_once 'core.php';

use Core\App;
use Core\Request;
$app = new App('settings.php');

$request = new Request($app->getSettings()->root_url);
$response = $app->process($request);
echo $response;

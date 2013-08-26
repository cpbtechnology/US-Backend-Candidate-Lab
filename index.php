<?php
require_once 'core.php';

use Core\App;
use Core\Request;
$request = new Request();

$app = new App('settings.php');
$response = $app->process($request);
echo $response;

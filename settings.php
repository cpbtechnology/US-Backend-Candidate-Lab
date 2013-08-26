<?php
require_once 'core/url_resolver.php';

use Core\URLResolver;

$settings = [];

$settings['root_url'] = '/backend/';

$settings['db'] = [
    'dsn' => 'mysql:dbname=test;host=127.0.0.1',
    'user' => 'root',
    'password' => '',
];

$settings['urls'] = new URLResolver([
    '#notes/get/(\d+)/$#' => ['Notes', 'get'],
]);

return $settings;

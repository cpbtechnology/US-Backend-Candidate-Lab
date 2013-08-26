<?php
require_once 'core/url_resolver.php';

use Core\URLResolver;

$settings = [];

$settings['urls'] = new URLResolver([
    '#(?P<controller>[\w-]+)/(?P<action>[\w-]+)/$#' => [null, null],
]);

return $settings;

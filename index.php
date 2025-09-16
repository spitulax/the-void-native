<?php

define('ROOT', __DIR__);

require 'system/router.php';

$router = new Router();

$router->add('get', '/', function () {
    require 'pages/index.php';
});
$router->add('get', '/test.php', function () {
    require 'pages/test.php';
});

$router->dispatch();

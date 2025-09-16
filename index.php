<?php

session_start();

ob_start();

require_once 'system/router.php';
require_once 'system/controllers/user.php';

$router = new Router();

$router->page('/', 'app.php');

$router->page('test.php');

$router->page('login.php');
$router->post('/login', [UserController::class, 'login']);

$router->post('/logout', [UserController::class, 'logout']);

$router->dispatch();

ob_end_flush();

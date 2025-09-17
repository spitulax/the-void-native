<?php

const BUFFERED = true;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (BUFFERED) {
    ob_start();
}

// TODO: Move routing to separate file
require_once 'system/helpers.php';
require_once 'system/router.php';
require_once 'system/controllers/user.php';

$router = new Router();

$router->page('/', 'app.php');

$router->page('test.php');

$router->page('login.php');
$router->page('register.php');
$router->post('/login', [UserController::class, 'login']);
$router->post('/logout', [UserController::class, 'logout']);
$router->post('/register', [UserController::class, 'register']);
$router->post('/user/delete', [UserController::class, 'delete']);

$router->page('admin/dashboard.php');

$router->dispatch();

if (BUFFERED) {
    ob_end_flush();
}

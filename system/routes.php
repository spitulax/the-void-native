<?php

require_once 'system/router.php';
require_once 'system/controllers/post.php';
require_once 'system/controllers/user.php';

$router = new Router();

$router->page('/', 'app.php');
$router->page('404.php');

$router->page('test.php');

$router->page('login.php');
$router->page('register.php');
$router->page('user/view.php');
$router->page('user/edit.php');
$router->post('/login', [UserController::class, 'login']);
$router->post('/logout', [UserController::class, 'logout']);
$router->post('/register', [UserController::class, 'register']);
$router->post('/user/edit', [UserController::class, 'edit']);
$router->post('/user/delete', [UserController::class, 'delete']);
$router->post('/user/follow', [UserController::class, 'follow']);

$router->page('view.php');
$router->page('post.php');
$router->page('reply.php');
$router->page('edit.php');
$router->post('/post', [PostController::class, 'post']);
$router->post('/post/reply', [PostController::class, 'reply']);
$router->post('/post/edit', [PostController::class, 'edit']);
$router->post('/post/delete', [PostController::class, 'delete']);
$router->post('/post/like', [PostController::class, 'like']);

$router->page('admin/dashboard.php');

$router->dispatch();

<?php

require_once 'system/router.php';
require_once 'system/controllers/post.php';
require_once 'system/controllers/user.php';
require_once 'system/controllers/like.php';

$router = new Router();

$router->page('/', 'app.php');
$router->page('404.php');

$router->page('test.php');

$router->page('login.php');
$router->page('register.php');
$router->post('/login', [UserController::class, 'login']);
$router->post('/logout', [UserController::class, 'logout']);
$router->post('/register', [UserController::class, 'register']);
$router->post('/user/delete', [UserController::class, 'delete']);

$router->page('post.php');
$router->page('view.php');
$router->post('/post', [PostController::class, 'post']);
$router->post('/post/delete', [PostController::class, 'delete']);
$router->post('/like', [LikeController::class, 'like']);

$router->page('admin/dashboard.php');

$router->dispatch();

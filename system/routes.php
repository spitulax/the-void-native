<?php

require_once 'system/router.php';
require_once 'system/controllers/post.php';
require_once 'system/controllers/user.php';
require_once 'system/controllers/notif.php';

$router = new Router();

$router->page('/', 'app.php');
$router->page('404.php');

$router->page('test.php');

$router->page('login.php');
$router->page('register.php');
$router->page('notifs.php');
$router->page('user/view.php');
$router->page('user/followers.php');
$router->page('user/edit.php');
$router->page('user/changePassword.php');
$router->post('/login', [UserController::class, 'login']);
$router->post('/logout', [UserController::class, 'logout']);
$router->post('/register', [UserController::class, 'register']);
$router->post('/user/edit', [UserController::class, 'edit']);
$router->post('/user/change-password', [UserController::class, 'changePassword']);
$router->post('/user/delete', [UserController::class, 'delete']);
$router->post('/user/mute', [UserController::class, 'mute']);
$router->post('/user/follow', [UserController::class, 'follow']);
$router->post('/notif/notify', [NotifController::class, 'notify']);
$router->post('/notif/data', [NotifController::class, 'notifData']);
$router->post('/notif/clear', [NotifController::class, 'clearNotifs']);
$router->post('/notif/delete', [NotifController::class, 'deleteNotif']);

$router->page('post.php');
$router->page('post/view.php');
$router->page('post/reply.php');
$router->page('post/edit.php');
$router->page('post/likes.php');
$router->post('/post', [PostController::class, 'post']);
$router->post('/post/reply', [PostController::class, 'reply']);
$router->post('/post/edit', [PostController::class, 'edit']);
$router->post('/post/delete', [PostController::class, 'delete']);
$router->post('/post/like', [PostController::class, 'like']);

$router->page('admin/dashboard.php');
$router->page('admin/notify.php');
$router->page('admin/approve.php');
$router->post('/admin/approve-data', [PostController::class, 'approveData']);
$router->post('/admin/approve', [PostController::class, 'approve']);
$router->post('/admin/reject', [PostController::class, 'reject']);

$router->dispatch();
